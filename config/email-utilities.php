<?php

return [

    /*
     * -----------------------------------------------------------------------------------
     * Storage Disk for the Lists
     * -----------------------------------------------------------------------------------
     *
     * Specify the storage disk that should be used when storing and retrieving
     * files related to this package. This should correspond to one of the
     * disks defined in your `config/filesystems.php` file.
     * The default is `local`, which uses the `storage/app/private` directory.
     */
    'storage_disk' => env('EMAIL_UTILITIES_STORAGE_DISK', 'local'),

    /*
    |-----------------------------------------------------------------------------------
    | Disposable Email Domains List
    |-----------------------------------------------------------------------------------
    |
    | Specify where the disposable email domains list is stored. If `null` is specified,
    | the package's built-in list will be used. Otherwise, provide the relative path
    | to the file from the storage disk which you have configured above. For example,
    | if the file is stored in `storage/app/private/disposable-domains.txt`, you would
    | specify `disposable-domains.txt` here.
    |
    | IMPORTANT: Providing a custom path/filename here is required for the
    | `FetchDisposableEmailDomains` Artisan command.
    |
    */
    // 'disposable_email_list_path' => 'disposable-domains.txt',
    'disposable_email_list_path' => null,

    /*
    |-----------------------------------------------------------------------------------
    | Role Accounts List
    |-----------------------------------------------------------------------------------
    |
    | Specify where the role accounts list is stored. If `null` is specified, the
    | package's built-in list will be used. Otherwise, provide the relative path
    | to the file from the storage disk which you have configured above. For example,
    | if the file is stored in `storage/app/private/role-accounts.json`, you would
    | specify `role-accounts.json` here.
    |
    */
    'role_accounts_list_path' => null,

    /*
    |-----------------------------------------------------------------------------------
    | Validate Config
    |-----------------------------------------------------------------------------------
    |
    | Specify whether the package should validate the configuration values in this
    | file when the package is booted. This helps to catch any misconfigurations
    | early. If the validation fails, the following exception will be thrown:
    |
    | AshAllenDesign\EmailUtilities\Exceptions\ValidationException
    |
    */
    'validate_config' => false,
];
