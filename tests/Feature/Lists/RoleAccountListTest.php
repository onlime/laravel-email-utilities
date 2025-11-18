<?php

declare(strict_types=1);

namespace AshAllenDesign\EmailUtilities\Tests\Feature\Lists;

use AshAllenDesign\EmailUtilities\Lists\RoleAccountList;
use AshAllenDesign\EmailUtilities\Tests\Feature\TestCase;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\Test;
use TypeError;

class RoleAccountListTest extends TestCase
{
    #[Test]
    public function default_role_accounts_are_loaded_correctly(): void
    {
        config(['email-utilities.role_accounts_list_path' => null]);

        $this->assertCount(8, RoleAccountList::get());
    }

    #[Test]
    public function custom_disposable_domains_are_loaded_correctly(): void
    {
        Storage::fake(config('email-utilities.storage_disk'));

        $path = 'lists/role-accounts-list-test.json';
        RoleAccountList::disk()->put(
            $path,
            json_encode(['admin', 'support'])
        );

        config(['email-utilities.role_accounts_list_path' => $path]);

        $this->assertCount(2, RoleAccountList::get());
    }

    #[Test]
    public function exception_is_thrown_if_the_custom_list_does_not_exist(): void
    {
        Storage::fake(config('email-utilities.storage_disk'));

        $this->expectException(FileNotFoundException::class);

        config(['email-utilities.role_accounts_list_path' => 'invalid-path.json']);

        RoleAccountList::get();
    }

    #[Test]
    public function exception_is_thrown_if_the_list_is_not_valid_json(): void
    {
        Storage::fake(config('email-utilities.storage_disk'));

        $this->expectException(TypeError::class);

        $path = 'lists/role-accounts-list-test.json';
        RoleAccountList::disk()->put($path, 'NOT VALID JSON');

        config(['email-utilities.role_accounts_list_path' => $path]);

        RoleAccountList::get();
    }
}
