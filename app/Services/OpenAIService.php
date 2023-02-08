<?php

namespace App\Services;

use Illuminate\Http\Client\PendingRequest;

class OpenAIService
{
    public function __construct(private PendingRequest $openAi)
    {
    }

    public function ask(string $question): mixed
    {
        return $this->openAi->send('POST', 'v1/completions', [
            'stream' => true,
            'laravel_data' => [
                'scheme' => 'http',
            ],
            'json' => [
                'model' => 'text-davinci-003',
                'temperature' => 0.7,
                'top_p' => 1,
                'frequency_penalty' => 0,
                'presence_penalty' => 0,
                'max_tokens' => 600,
                'prompt' => "' . $question . '",
                'stream' => true,
            ],
        ]);
    }
}
