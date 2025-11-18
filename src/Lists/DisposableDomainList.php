<?php

declare(strict_types=1);

namespace AshAllenDesign\EmailUtilities\Lists;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\File;

class DisposableDomainList
{
    use HasStorageDisk;

    public static function getListPath(): string
    {
        $relPath = config('email-utilities.disposable_email_list_path');

        return $relPath
            ? self::disk()->path($relPath)
            : __DIR__.'/../../lists/disposable-domains.txt';
    }

    /**
     * @return list<string>
     * @throws FileNotFoundException
     */
    public static function get(): array
    {
        // Laravel-ish file($listLocation, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES)
        // File::lines() already applies SplFileObject::DROP_NEW_LINE flag, so we just need to filter out empty lines.
        return File::lines(self::getListPath())
            ->filter() // remove empty lines
            ->values()
            ->all();
    }
}
