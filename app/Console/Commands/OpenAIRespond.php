<?php

namespace App\Console\Commands;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use League\Flysystem\FilesystemException;
use Symfony\Component\Console\Command\Command as CommandAlias;
use Symfony\Component\Console\Output\ConsoleOutput;

class OpenAIRespond extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'openai:respond {question*} {--file=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Asks OPENAI your questions and streams back the response';

    /**
     * Execute the console command.
     *
     * @return int
     * @throws BindingResolutionException
     */
    public function handle(): int
    {
        stream_filter_register('remove_all_the_open_a_i_noise_from_stream_filter', 'App\StreamUtilities\RemoveAllTheOpenAINoiseFromStreamFilter');

        $question = implode(' ', $this->argument()['question']);

        $output = new ConsoleOutput();

        $fileContent = '';

        $file = $this->option('file');

        if ($file) {
            try {
                $fileContent = Storage::disk('src')->read($file);
            } catch (FilesystemException $e) {
                $output->writeln('It wasn\'t possible to read the file: ' . $file);
                $output->writeln('Exception: ' . $e->getMessage());

                return CommandAlias::INVALID;
            }

            //Make sure directory is present
            $directory = Str::beforeLast($file, '/');
            if (!is_dir('tests/' . $directory)) {
                mkdir('tests/' . $directory, 0777, true);
            }
        }

        //Concatenate question and file name
        $str = $question . ' ' . (!empty($fileContent) ? PHP_EOL . $fileContent : '');

        $url = 'https://api.openai.com/v1/completions';
        $token = config('services.openai_api_key');

        $client = app()->make(Client::class);
        $data = [
            'debug' => false,
            'stream' => true,
            'headers' => ['Authorization' => 'Bearer ' . $token],
            'json' => [
                'model' => 'text-davinci-003',
                'temperature' => 0.7,
                'top_p' => 1,
                'frequency_penalty' => 0,
                'presence_penalty' => 0,
                'max_tokens' => 600,
                'prompt' => "' . $str . '",
                'stream' => true,
            ],
        ];
        try {
            $response = $client->post($url, $data);
            $handle = $response->getBody()->detach();

            stream_filter_append($handle, 'remove_all_the_open_a_i_noise_from_stream_filter');

            $testDisk = Storage::disk('test');

            $testFileName = Str::beforeLast($file, '.') . 'Test.' . Str::afterLast($file, '.');

            //Clear file content
            $testDisk->put($testFileName, '');

            while ($binary = fread($handle, 8)) {
                $output->write($binary);
                $testDisk->append($testFileName, $binary, '');
            }
        } catch (GuzzleException $e) {
            $output->writeln('An error occurred while sending post request to: ' . $url);
            $output->writeln('Code: ' . $e->getCode() . ' Message: ' . $e->getMessage());

            return CommandAlias::FAILURE;
        }

        return CommandAlias::SUCCESS;
    }
}
