<?php

declare(strict_types=1);

namespace AshAllenDesign\EmailUtilities\Tests\Feature\Commands;

use AshAllenDesign\EmailUtilities\Commands\FetchDisposableEmailDomains;
use AshAllenDesign\EmailUtilities\Tests\Feature\TestCase;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\Test;

class FetchDisposableEmailDomainsTest extends TestCase
{
    #[Test]
    public function command_fails_when_config_not_set(): void
    {
        config(['email-utilities.disposable_email_list_path' => null]);

        $this->artisan(FetchDisposableEmailDomains::class)
            ->expectsOutput("The configuration 'email-utilities.disposable_email_list_path' is not set. Please set it to a valid file path.")
            ->assertExitCode(Command::FAILURE);
    }

    #[Test]
    public function command_fetches_stores_and_logs_blocklist(): void
    {
        Storage::fake(config('email-utilities.storage_disk'));

        $fakeBody = implode(PHP_EOL, array_fill(0, 1200, 'example.com'));

        Http::fake([
            FetchDisposableEmailDomains::BLOCKLIST_URL => $fakeBody,
        ]);

        $path = 'testing/disposable-domains.txt';
        config(['email-utilities.disposable_email_list_path' => $path]);

        $this->artisan(FetchDisposableEmailDomains::class)
            ->expectsOutput('Blocklist successfully fetched and stored. Domain count: 1200')
            ->assertExitCode(Command::SUCCESS);

        Storage::assertExists($path);
        $this->assertEquals($fakeBody, Storage::get($path));
        $this->assertSame(strlen($fakeBody), Storage::size($path));
    }
}
