<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $identifier
 * @property string $name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MemberType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MemberType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MemberType onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MemberType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MemberType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MemberType whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MemberType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MemberType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MemberType whereIdentifier($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MemberType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MemberType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MemberType withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MemberType withoutTrashed()
 * @mixin \Eloquent
 */
class MemberType extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'identifier',
        'name',
        'description',
    ];
}
