<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function loadTestData(string $path)
    {
        return json_decode(file_get_contents($path), true);
    }
}
