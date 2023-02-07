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

    }
}
