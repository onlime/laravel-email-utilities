<?php

declare(strict_types=1);

namespace AshAllenDesign\EmailUtilities\Tests\Feature\Lists;

use AshAllenDesign\EmailUtilities\Lists\DisposableDomainList;
use AshAllenDesign\EmailUtilities\Tests\Feature\TestCase;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\Test;

class DisposableDomainListTest extends TestCase
{
    #[Test]
    public function default_disposable_domains_are_loaded_correctly(): void
    {
        config(['email-utilities.disposable_email_list_path' => null]);

        $this->assertCount(4931, DisposableDomainList::get());
    }

    #[Test]
    public function custom_disposable_domains_are_loaded_correctly(): void
    {
        Storage::fake(config('email-utilities.storage_disk'));

        $path = 'lists/disposable-domains-test.txt';

        DisposableDomainList::disk()->put(
            $path,
            implode(PHP_EOL, ['customdomain.com', 'hellodomain.com'])
        );

        config(['email-utilities.disposable_email_list_path' => $path]);

        $this->assertCount(2, DisposableDomainList::get());
    }

    #[Test]
    public function exception_is_thrown_if_the_custom_list_does_not_exist(): void
    {
        $this->expectException(FileNotFoundException::class);

        config(['email-utilities.disposable_email_list_path' => 'invalid-path.txt']);

        DisposableDomainList::get();
    }
}
