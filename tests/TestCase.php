<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function loadTestData(string $path) : array
    {
        $file_get_contents = file_get_contents($path);
        if (is_string($file_get_contents)) {
            return json_decode($file_get_contents, true);
        } else {
            return [];
        }
    }
}
