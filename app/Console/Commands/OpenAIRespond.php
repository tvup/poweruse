<?php

namespace App\Console\Commands;

use App\Services\OpenAIService;
use App\Services\SourceCodeService;
use App\StreamUtilities\RemoveAllTheOpenAINoiseFromStreamFilter;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use League\Flysystem\FilesystemException;
use Symfony\Component\Console\Command\Command as CommandAlias;

class OpenAIRespond extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'openai:respond {question?} {--file=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Asks OPENAI your questions and streams back the response';

    private SourceCodeService $sourceCodeService;

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
        stream_filter_register('remove_all_the_open_a_i_noise_from_stream_filter', RemoveAllTheOpenAINoiseFromStreamFilter::class);

        $question = $this->ask('What do you want me to do?');

        $fileContent = '';

        if ($file = $this->option('file')) {
            $fileContent = $this->getSourceCodeFile($file); //Exits if file can't be loaded
            $this->sourceCodeService->createDirIfNotExists($file);
            $testFileName = Str::beforeLast($file, '.') . 'Test.' . Str::afterLast($file, '.');
            $testDisk = Storage::disk('test');
            $testDisk->put($testFileName, '');
        }

        //Concatenate question and file name
        $finalQuestion = $question . ' ' . (!empty($fileContent) ? PHP_EOL . $fileContent : '');
        $this->requestOpenAI($finalQuestion, $testDisk ?? null, $testFileName ?? null); //Exits if GuzzleException occurs

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
            $this->output->writeln('It wasn\'t possible to read the file: ' . $file);
            $this->output->writeln('Exception: ' . $e->getMessage());
            exit(CommandAlias::INVALID);
        }

        return $fileContent;
    }

    private function requestOpenAI(string $question, FilesystemAdapter $testDisk = null, string $testFileName = null): void
    {
        try {
            $response = app(OpenAIService::class)->ask($question);
            $handle = $response->getBody()->detach();

            stream_filter_append($handle, 'remove_all_the_open_a_i_noise_from_stream_filter');

            while ($binary = fread($handle, 1)) {
                $this->output->write($binary);

                $testDisk?->append($testFileName, $binary, '');
            }
        } catch (GuzzleException $e) {
            $this->output->writeln('An error occurred while sending post request to chat gtp');
            $this->output->writeln('Code: ' . $e->getCode() . ' Message: ' . $e->getMessage());
            exit(CommandAlias::FAILURE);
        }
    }
}
