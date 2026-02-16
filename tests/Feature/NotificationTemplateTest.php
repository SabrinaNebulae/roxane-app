<?php

namespace Tests\Feature;

use App\Models\NotificationTemplate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NotificationTemplateTest extends TestCase
{
    use RefreshDatabase;

    public function test_find_by_identifier_returns_active_template(): void
    {
        $template = NotificationTemplate::factory()->create([
            'identifier' => 'test_template',
            'is_active' => true,
        ]);

        $found = NotificationTemplate::findByIdentifier('test_template');

        $this->assertNotNull($found);
        $this->assertEquals($template->id, $found->id);
    }

    public function test_find_by_identifier_returns_null_for_inactive_template(): void
    {
        NotificationTemplate::factory()->inactive()->create([
            'identifier' => 'inactive_template',
        ]);

        $found = NotificationTemplate::findByIdentifier('inactive_template');

        $this->assertNull($found);
    }

    public function test_render_subject_replaces_placeholders(): void
    {
        $template = NotificationTemplate::factory()->create([
            'subject' => 'Bonjour {member_name}, votre adhésion expire le {expiry_date}',
        ]);

        $result = $template->renderSubject([
            'member_name' => 'Jean Dupont',
            'expiry_date' => '2026-01-31',
        ]);

        $this->assertEquals('Bonjour Jean Dupont, votre adhésion expire le 2026-01-31', $result);
    }

    public function test_render_body_replaces_placeholders(): void
    {
        $template = NotificationTemplate::factory()->create([
            'body' => '<p>Bonjour {member_name}</p><p>Expiration : {expiry_date}</p>',
        ]);

        $result = $template->renderBody([
            'member_name' => 'Marie Martin',
            'expiry_date' => '2026-06-15',
        ]);

        $this->assertEquals('<p>Bonjour Marie Martin</p><p>Expiration : 2026-06-15</p>', $result);
    }

    public function test_missing_placeholder_is_left_intact(): void
    {
        $template = NotificationTemplate::factory()->create([
            'subject' => 'Bonjour {member_name}, date : {expiry_date}',
        ]);

        $result = $template->renderSubject([
            'member_name' => 'Jean Dupont',
        ]);

        $this->assertEquals('Bonjour Jean Dupont, date : {expiry_date}', $result);
    }
}
