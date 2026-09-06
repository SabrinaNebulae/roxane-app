<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $member_id
 * @property int|null $listmonk_user_id
 * @property array<array-key, mixed>|null $data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Member $member
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListmonkMember newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListmonkMember newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListmonkMember query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListmonkMember whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListmonkMember whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListmonkMember whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListmonkMember whereListmonkUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListmonkMember whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListmonkMember whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ListmonkMember extends Model
{
    protected $table = 'listmonks_members';

    protected $fillable = [
        'member_id',
        'listmonk_user_id',
        'data',
    ];

    protected function casts(): array
    {
        return [
            'data' => 'array',
        ];
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }
}
