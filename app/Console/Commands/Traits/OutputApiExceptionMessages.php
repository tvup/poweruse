<?php

namespace App\Console\Commands\Traits;

trait OutputApiExceptionMessages
{
    /**
     * @param $errors
     * @param $meteringPointId
     */
    function logExceptionApiMessages($errors, $text): void
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