<?php

namespace App\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class OpenAIService
{
    private PendingRequest $openAiClient;

    public function __construct()
    {
        $this->openAiClient = Http::baseUrl(config('services.openai.base_url'))->withToken(config('services.openai.key'));
    }

    public function ask(string $question): mixed
    {
        return $this->openAiClient->withOptions([
            'debug' => true,
        ])->asJson()->send('POST', '/v1/chat/completions', [
            'model' => 'gpt-3.5-turbo',
            'messages' => [['role'=>'user', 'content' => $question ]],
            "temperature" => 0.7,
            "stream" => true,
        ]);
    }
}
