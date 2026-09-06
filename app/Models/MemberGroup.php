<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $identifier
 * @property string $name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Member> $members
 * @property-read int|null $members_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MemberGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MemberGroup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MemberGroup query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MemberGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MemberGroup whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MemberGroup whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MemberGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MemberGroup whereIdentifier($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MemberGroup whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MemberGroup whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MemberGroup extends Model
{
    protected $fillable = [
        'name',
        'description',
        'identifier',
    ];

    public static function getAttributeLabel(string $attribute): string
    {
        return __('member_groups.fields.'.$attribute);
    }

    public function members(): HasMany
    {
        return $this->hasMany(Member::class, 'group_id');
    }
}
