<?php

if (!function_exists('fixture_path')) {
    function fixture_path(string $path = ''): string
    {
        return base_path('tests/fixtures/' . $path);
    }
}
