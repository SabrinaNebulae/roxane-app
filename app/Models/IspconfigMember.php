<?php

namespace App\Models;

use App\Enums\IspconfigType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $member_id
 * @property string|null $ispconfig_client_id
 * @property string|null $ispconfig_service_user_id
 * @property string|null $email
 * @property IspconfigType $type
 * @property array<array-key, mixed>|null $data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Member $member
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IspconfigMember newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IspconfigMember newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IspconfigMember query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IspconfigMember whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IspconfigMember whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IspconfigMember whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IspconfigMember whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IspconfigMember whereIspconfigClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IspconfigMember whereIspconfigServiceUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IspconfigMember whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IspconfigMember whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IspconfigMember whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class IspconfigMember extends Model
{
    protected $table = 'ispconfigs_members';

    protected $fillable = [
        'member_id',
        'ispconfig_client_id',
        'ispconfig_service_user_id',
        'email',
        'type',
        'data',
    ];

    protected $casts = [
        'type' => IspconfigType::class,
        'data' => 'array',
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }
}
