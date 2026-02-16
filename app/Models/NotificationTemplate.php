<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NotificationTemplate extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'identifier',
        'name',
        'subject',
        'body',
        'variables',
        'is_active',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'variables' => 'array',
            'is_active' => 'boolean',
        ];
    }

    public static function getAttributeLabel(string $attribute): string
    {
        return __('notification_templates.fields.'.$attribute);
    }

    public static function findByIdentifier(string $identifier): ?self
    {
        return self::query()
            ->where('identifier', $identifier)
            ->where('is_active', true)
            ->first();
    }

    public function renderSubject(array $vars): string
    {
        return $this->replacePlaceholders($this->subject, $vars);
    }

    public function renderBody(array $vars): string
    {
        return $this->replacePlaceholders($this->body, $vars);
    }

    private function replacePlaceholders(string $text, array $vars): string
    {
        foreach ($vars as $key => $value) {
            $text = str_replace('{'.$key.'}', (string) $value, $text);
        }

        return $text;
    }
}
