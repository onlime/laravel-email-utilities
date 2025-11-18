<?php

declare(strict_types=1);

namespace AshAllenDesign\EmailUtilities\Lists;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\File;

class RoleAccountList
{
    use HasStorageDisk;

    public static function getListPath(): string
    {
        $relPath = config('email-utilities.role_accounts_list_path');

        return $relPath
            ? self::disk()->path($relPath)
            : __DIR__.'/../../lists/role-accounts.json';
    }

    /**
     * @return list<string>
     * @throws FileNotFoundException
     */
    public static function get(): array
    {
        return array_values(File::json(
            self::getListPath()
        ));
    }
}
