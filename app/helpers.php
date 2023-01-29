<?php

if (!function_exists('test_fixture_path')) {
    function test_fixture_path(string $path = ''): string
    {
        return base_path('tests/fixtures/' . $path);
    }
}

if (!function_exists('fixture_path')) {
    function fixture_path(string $path = ''): string
    {
        return base_path('resources/fixtures/' . $path);
    }
}

if (!function_exists('list_of_tariffs_for_non_private_consumers')) {
    function list_of_tariffs_for_non_private_consumers(): string
    {
        return File::get(fixture_path() . 'ListOfTariffsForNonPrivateConsumers.txt');
    }
}
