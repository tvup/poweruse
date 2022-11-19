<?php

namespace App\Console\Commands\Traits;

trait OutputApiExceptionMessages
{
    /**
     * @param array<string, string>|string $errors
     * @param string $text
     */
    function logExceptionApiMessages(array|string $errors, string $text): void
    {
        logger()->error($text);
        switch (gettype($errors)) {
            case 'array':
                $this->table(array_keys($errors), [array_values($errors)]);
                break;
            case 'string':
                $this->error($errors);
                break;
            default:
                $this->error('Exception didn\'t return useful error messages either');

        }
    }
}