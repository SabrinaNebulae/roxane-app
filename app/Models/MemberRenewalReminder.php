<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $member_id
 * @property int $renewal_year
 * @property bool $reminder_1_sent
 * @property bool $reminder_2_sent
 * @property bool $reminder_3_sent
 * @property bool $deactivation_sent
 * @property \Illuminate\Support\Carbon|null $reminder_1_sent_at
 * @property \Illuminate\Support\Carbon|null $reminder_2_sent_at
 * @property \Illuminate\Support\Carbon|null $reminder_3_sent_at
 * @property \Illuminate\Support\Carbon|null $deactivated_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Member $member
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MemberRenewalReminder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MemberRenewalReminder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MemberRenewalReminder query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MemberRenewalReminder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MemberRenewalReminder whereDeactivatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MemberRenewalReminder whereDeactivationSent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MemberRenewalReminder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MemberRenewalReminder whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MemberRenewalReminder whereReminder1Sent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MemberRenewalReminder whereReminder1SentAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MemberRenewalReminder whereReminder2Sent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MemberRenewalReminder whereReminder2SentAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MemberRenewalReminder whereReminder3Sent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MemberRenewalReminder whereReminder3SentAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MemberRenewalReminder whereRenewalYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MemberRenewalReminder whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MemberRenewalReminder extends Model
{
    protected $fillable = [
        'member_id',
        'renewal_year',
        'reminder_1_sent',
        'reminder_2_sent',
        'reminder_3_sent',
        'deactivation_sent',
        'reminder_1_sent_at',
        'reminder_2_sent_at',
        'reminder_3_sent_at',
        'deactivated_at',
    ];

    protected function casts(): array
    {
        return [
            'reminder_1_sent' => 'boolean',
            'reminder_2_sent' => 'boolean',
            'reminder_3_sent' => 'boolean',
            'deactivation_sent' => 'boolean',
            'reminder_1_sent_at' => 'datetime',
            'reminder_2_sent_at' => 'datetime',
            'reminder_3_sent_at' => 'datetime',
            'deactivated_at' => 'datetime',
            'renewal_year' => 'integer',
        ];
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function markAsReminder1Sent(): void
    {
        $this->update([
            'reminder_1_sent' => true,
            'reminder_1_sent_at' => now(),
        ]);
    }

    public function markAsReminder2Sent(): void
    {
        $this->update([
            'reminder_2_sent' => true,
            'reminder_2_sent_at' => now(),
        ]);
    }

    public function markAsReminder3Sent(): void
    {
        $this->update([
            'reminder_3_sent' => true,
            'reminder_3_sent_at' => now(),
        ]);
    }

    public function markAsDeactivated(): void
    {
        $this->update([
            'deactivation_sent' => true,
            'deactivated_at' => now(),
        ]);
    }
}
