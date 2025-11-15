<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

/**
 * @property int $id
 * @property int|null $user_id
 * @property string|null $dolibarr_id
 * @property string|null $keycloak_id
 * @property string $status
 * @property string $nature
 * @property int|null $type_id
 * @property int|null $group_id
 * @property string|null $lastname
 * @property string|null $firstname
 * @property string $email
 * @property string|null $retzien_email
 * @property string|null $company
 * @property string|null $date_of_birth
 * @property string|null $address
 * @property string|null $zipcode
 * @property string|null $city
 * @property string|null $country
 * @property string|null $phone1
 * @property string|null $phone2
 * @property int $public_membership
 * @property string|null $website_url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read string $full_name
 * @property-read \App\Models\MemberGroup|null $group
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Membership> $memberships
 * @property-read int|null $memberships_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\MemberFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereDateOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereDolibarrId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereKeycloakId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereNature($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member wherePhone1($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member wherePhone2($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member wherePublicMembership($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereRetzienEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereWebsiteUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereZipcode($value)
 * @mixin \Eloquent
 */
class Member extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'user_id',
        'dolibarr_id',
        'keycloak_id',
        'status',
        'nature',
        'type_id',
        'group_id',
        'lastname',
        'firstname',
        'email',
        'company',
        'date_of_birth',
        'address',
        'zipcode',
        'city',
        'country',
        'phone1',
        'phone2',
        'public_membership',
        'website_url'
    ];

    public static function getAttributeLabel(string $attribute): string
    {
        return __("members.fields.$attribute");
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->firstname} {$this->lastname}";
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(MemberGroup::class);
    }

    public function memberships(): HasMany
    {
        return $this->hasMany(Membership::class);
    }
}
