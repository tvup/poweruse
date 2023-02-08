<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use League\Flysystem\FilesystemException;

class SourceCodeService
{
    /**
     * @param string $file
     * @return string
     * @throws FilesystemException
     */
    public function getSourceCodeFile(string $file): string
    {
        return Storage::disk('src')->read($file);
    }

    public function createDirIfNotExists(string $file) : void
    {
        //Make sure directory is present
        $directory = Str::beforeLast($file, '/');
        if (!is_dir('tests/' . $directory)) {
            mkdir('tests/' . $directory, 0777, true);
        }
    }
}
