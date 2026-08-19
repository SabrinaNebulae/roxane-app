<?php

namespace Tests\Feature\Commands;

use App\Enums\IspconfigType;
use App\Models\IspconfigMember;
use App\Models\Member;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateISPWebAccountsTest extends TestCase
{
    use RefreshDatabase;

    public function test_command_exits_successfully_when_no_members_with_websites(): void
    {
        $this->artisan('ext:create-isp-accounts')
            ->expectsOutput('No members with websites found')
            ->assertExitCode(0);
    }

    public function test_command_processes_members_regardless_of_status(): void
    {
        Member::factory()->create([
            'status' => 'draft',
            'website_url' => 'example.com',
            'firstname' => 'John',
            'lastname' => 'Doe',
        ]);

        $this->artisan('ext:create-isp-accounts --dry-run')
            ->expectsOutput('DRY RUN MODE - No changes will be made')
            ->assertExitCode(0);
    }

    public function test_command_runs_in_dry_run_mode(): void
    {
        Member::factory()->create([
            'status' => 'valid',
            'website_url' => 'example.com',
            'firstname' => 'John',
            'lastname' => 'Doe',
        ]);

        $this->artisan('ext:create-isp-accounts --dry-run')
            ->expectsOutput('DRY RUN MODE - No changes will be made')
            ->assertExitCode(0);
    }

    public function test_command_skips_member_with_existing_client(): void
    {
        $member = Member::factory()->create([
            'status' => 'valid',
            'website_url' => 'example.com',
        ]);

        IspconfigMember::create([
            'member_id' => $member->id,
            'type' => IspconfigType::WEB,
            'ispconfig_client_id' => '123',
        ]);

        $this->artisan('ext:create-isp-accounts --dry-run')
            ->assertExitCode(0);

        $this->assertDatabaseCount('ispconfigs_members', 1);
    }
}
