<?php

namespace App\Models;

use App\Enums\IspconfigType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
