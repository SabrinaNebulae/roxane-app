<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $member_id
 * @property string|null $nextcloud_user_id
 * @property array<array-key, mixed>|null $data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Member $member
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NextCloudMember newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NextCloudMember newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NextCloudMember query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NextCloudMember whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NextCloudMember whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NextCloudMember whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NextCloudMember whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NextCloudMember whereNextcloudUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NextCloudMember whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NextCloudMember whereUsername($value)
 * @mixin \Eloquent
 */
class NextCloudMember extends Model
{
    protected $table = 'nextclouds_members';

    protected $fillable = [
        'member_id',
        'nextcloud_user_id',
        'data',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }
}
