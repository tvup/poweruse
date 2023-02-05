<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Str;
use Orhanerday\OpenAi\OpenAi;
use Symfony\Component\Console\Command\Command as CommandAlias;
use Symfony\Component\Console\Output\ConsoleOutput;

class OpenAIRespond extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'openai:respond {question*}';

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
    public function handle() : int
    {
        $question = implode(' ', $this->argument()['question']);

        $output = new ConsoleOutput();

        $open_ai = app()->makeWith(OpenAi::class, ['OPENAI_API_KEY' => config('services.openai_api_key')]);
        $open_ai->completion(
            [
                'model' => 'text-davinci-003',
                'prompt' => $question,
                'temperature' => 0.7,
                'max_tokens' => 600,
                'top_p' => 1,
                'frequency_penalty' => 0,
                'presence_penalty' => 0,
                'stream' => true,
            ],
            function ($curl_info, $data) use ($output) {
                $choices = json_decode(trim(Str::substr($data, 6)));
                if ($choices) {
                    foreach ($choices->choices as $choice) {
                        $output->write($choice->text);
                    }
                }
                flush();

                return strlen($data);
            }
        );

        $output->writeln('');

        return CommandAlias::SUCCESS;
    }
}
