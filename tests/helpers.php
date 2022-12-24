<?php

function fixture_path(string $path = ''): string
{
    return base_path('tests/fixtures/' . $path);
}

function loadTestData(string $path)
{
    return json_decode(file_get_contents($path), true);
}