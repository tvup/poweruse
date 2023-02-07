<?php

namespace App\StreamUtilities;

use Illuminate\Support\Str;
use php_user_filter;

class RemoveAllTheOpenAINoiseFromStreamFilter extends php_user_filter
{
    public function filter($in, $out, &$consumed, $closing): int
    {
        while ($bucket = stream_bucket_make_writeable($in)) {
            $bucket->data = $this->transform($bucket->data);
            $consumed += $bucket->datalen;
            stream_bucket_append($out, $bucket);
        }

        return PSFS_PASS_ON;
    }

    private function transform(string $in): string
    {
        $out = '';
        if ($json = json_decode(trim(Str::substr($in, 6)))) {
            foreach ($json->choices as $choice) {
                $out .= $choice->text;
            }
        }

        return $out;
    }
}
