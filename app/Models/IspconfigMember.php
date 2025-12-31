<?php

namespace App\Models;

use App\Enums\IspconfigType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
