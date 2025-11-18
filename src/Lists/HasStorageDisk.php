<?php

declare(strict_types=1);

namespace AshAllenDesign\EmailUtilities\Lists;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;

trait HasStorageDisk
{
    public static function disk(): Filesystem
    {
        return Storage::disk(config('email-utilities.storage_disk'));
    }
}
