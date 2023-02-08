<?php

namespace App\Console\Commands;

use App\Services\SourceCodeService;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Filesystem\FilesystemAdapter;
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

    private SourceCodeService $sourceCodeService;

    /**
     * @var ConsoleOutput
     */
    private ConsoleOutput $consoleOutput;

    /**
     * Execute the console command.
     *
     * @param SourceCodeService $sourceCodeService
     * @return int
     * @throws BindingResolutionException
     */
    public function handle(SourceCodeService $sourceCodeService): int
    {
        $this->sourceCodeService = $sourceCodeService;
        $this->consoleOutput = app()->make(ConsoleOutput::class);
        stream_filter_register('remove_all_the_open_a_i_noise_from_stream_filter', 'App\StreamUtilities\RemoveAllTheOpenAINoiseFromStreamFilter');

        $question = implode(' ', $this->argument()['question']);

        $fileContent = '';

        $file = $this->option('file');

        if ($file) {
            $fileContent = $this->getSourceCodeFile($file); //Exits if file can't be loaded
            $this->sourceCodeService->touchTestDir($file);
            $testFileName = Str::beforeLast($file, '.') . 'Test.' . Str::afterLast($file, '.');
            $testDisk = Storage::disk('test');
            $testDisk->put($testFileName, '');
        }

        //Concatenate question and file name
        $str = $question . ' ' . (!empty($fileContent) ? PHP_EOL . $fileContent : '');

        $url = 'https://api.openai.com/v1/completions';
        $token = config('services.openai_api_key');

        $client = app()->make(Client::class);
        $this->requestOpenAI($token, $str, $url, $client, $testDisk ?? null, $testFileName ?? null); //Exits if GuzzleException occurs

        return CommandAlias::SUCCESS;
    }

    /**
     * @param bool|array|string $file
     * @return string
     */
    private function getSourceCodeFile(bool|array|string $file): string
    {
        try {
            $fileContent = $this->sourceCodeService->getSourceCodeFile($file);
        } catch (FilesystemException $e) {
            $this->consoleOutput->writeln('It wasn\'t possible to read the file: ' . $file);
            $this->consoleOutput->writeln('Exception: ' . $e->getMessage());
            exit(CommandAlias::INVALID);
        }

        return $fileContent;
    }

    /**
     * @param mixed $token
     * @param string $str
     * @return array
     */
    private function buildRequestData(mixed $token, string $str): array
    {
        return [
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
    }

    private function requestOpenAI(string $token, string $str, string $url, Client $client, FilesystemAdapter $testDisk = null, string $testFileName = null): void
    {
        $data = $this->buildRequestData($token, $str);
        try {
            $response = $client->post($url, $data);
            $handle = $response->getBody()->detach();

            stream_filter_append($handle, 'remove_all_the_open_a_i_noise_from_stream_filter');

            while ($binary = fread($handle, 1)) {
                $this->consoleOutput->write($binary);
                $testDisk?->append($testFileName, $binary, '');
            }
        } catch (GuzzleException $e) {
            $this->consoleOutput->writeln('An error occurred while sending post request to: ' . $url);
            $this->consoleOutput->writeln('Code: ' . $e->getCode() . ' Message: ' . $e->getMessage());
            exit(CommandAlias::FAILURE);
        }
    }
}
