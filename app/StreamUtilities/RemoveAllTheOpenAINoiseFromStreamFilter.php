<?php

namespace App\StreamUtilities;

use Illuminate\Support\Str;
use php_user_filter;

class RemoveAllTheOpenAINoiseFromStreamFilter extends php_user_filter
{
    public function filter($in, $out, &$consumed, $closing): int
    {
        while ($bucket = stream_bucket_make_writeable($in)) {
            list($text, $choicesCount, $finishReason) = $this->transform($bucket->data);
            //If choiceCount and finishReason are both null, we are beyond end of stream
            //If choiceCount is different from 1 or finishReason has a value, we have reached end of stream, and we're
            //appending some data from the context.
            if (null == $choicesCount && null == $finishReason) {
                $bucket->data = '';
            } elseif ($choicesCount != 1 || $finishReason != null) {
                $bucket->data = $text . json_encode(['choicesCount'=>$choicesCount, 'finishReason'=>$finishReason]);
            } else {
                $bucket->data = $text;
            }
            $consumed += $bucket->datalen;
            stream_bucket_append($out, $bucket);
        }

        return PSFS_PASS_ON;
    }

    private function transform(string $in): array
    {
        $out = '';
        if ($json = json_decode(trim(Str::substr($in, 6)))) {
            foreach ($json->choices as $choice) {
                $out .= $choice->text;
                $finishReason = $choice->finish_reason;
            }
            $choicesCount = count($json->choices);
        }

        return [$out, $choicesCount ?? null, $finishReason ?? null];
    }
}
