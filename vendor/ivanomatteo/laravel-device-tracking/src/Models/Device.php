<?php

namespace IvanoMatteo\LaravelDeviceTracking\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * IvanoMatteo\LaravelDeviceTracking\Models\Device
 *
 * @property int $id
 * @property string $device_uuid
 * @property string $device_type
 * @property string $ip
 * @property \Illuminate\Support\Carbon|null $device_hijacked_at
 * @property array|null $data
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $is_rogue_device
 * @property-read \IvanoMatteo\LaravelDeviceTracking\Models\DeviceUser|null $currentUserStatus
 * @property-read \Illuminate\Database\Eloquent\Collection|\IvanoMatteo\LaravelDeviceTracking\Models\DeviceUser[] $pivot
 * @property-read int|null $pivot_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $user
 * @property-read int|null $user_count
 * @method static \Illuminate\Database\Eloquent\Builder|Device newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Device newQuery()
 * @method static \Illuminate\Database\Query\Builder|Device onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Device query()
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereDeviceHijackedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereDeviceType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereDeviceUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereIsRogueDevice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Device withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Device withoutTrashed()
 *
 * @mixin \Eloquent
 */
class Device extends Model
{
    use SoftDeletes;
    protected static $class;

    public function getTable()
    {
        return config('laravel-device-tracking.device_table');
    }

    protected $hidden = [
        'device_uuid',
        'admin_note',
        'data',
    ];
    protected $guarded = [];
    protected $casts = [
        'data' => 'array',
        'device_hijacked_at' => 'datetime',
    ];


    /**
     * @return string user class fqn
     */
    public static function getUserClass()
    {
        if (isset(static::$class)) {
            return static::$class;
        }

        $u = config('laravel-device-tracking.user_model');

        if (!$u) {
            if (class_exists("App\\Models\\User")) {
                $u = "App\\Models\\User";
            } else if (class_exists("App\\User")) {
                $u = "App\\User";
            }
        }

        if (!class_exists($u)) {
            throw new HttpException(500, "class $u not found");
        }

        if (!is_subclass_of($u, Model::class)) {
            throw new HttpException(500, "class $u is not  model");
        }

        static::$class = $u;

        return $u;
    }

    public function user()
    {
        return $this->belongsToMany(static::getUserClass(), 'device_user')
            ->using(DeviceUser::class)
            ->withPivot([
                'verified_at', 'name', 'reported_as_rogue_at', 'note', 'admin_note'
            ])->withTimestamps();
    }



    public function pivot()
    {
        return $this->hasMany(DeviceUser::class);
    }

    public function currentUserStatus()
    {
        $fieldName = config('laravel-device-tracking.model_relation_id');

        return $this->hasOne(DeviceUser::class)
            ->where($fieldName, '=', optional(Auth::user())->id);
    }

    public function isUsedBy($user_id)
    {
        $fieldName = config('laravel-device-tracking.model_relation_id');
        return $this->user()
            ->where('device_user.'.$fieldName, $user_id)->exists();
    }

    public function isCurrentUserAttached()
    {
        $attached = !!$this->currentUserStatus;
        if (!$this->currentUserStatus) {
            $this->unsetRelation('currentUserStatus');
        }
        return $attached;
    }
}
