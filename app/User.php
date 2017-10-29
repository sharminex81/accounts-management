<?php

namespace Besofty\Web\Attendance\Model;

use Illuminate\Contracts\Logging\Log;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * @var string
     */
    public $table = 'users';

    /**
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid', 'username', 'email_address', 'password', 'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @param $postData
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    public static function authentication($postData)
    {
        $user = [];
        try {
            $user = self::where('email_address', $postData['email_address'])
                ->where('password', $postData['password'])
                ->where('status', 1)
                ->first();
            if ($user) {
                return $user;
            }
        } catch (\Exception $exception) {
            throw $exception;
        }

        return false;
    }

    /**
     * @param $email
     * @return array|bool|\Illuminate\Database\Eloquent\Model|null|static
     * @throws \Exception
     */
    public static function details($uuid)
    {
        $user = [];
        try {
            $user = self::where('uuid', $uuid)
                ->where('status', 1)
                ->first();
            if ($user) {
                return $user;
            }
        } catch (\Exception $exception) {
            throw $exception;
        }

        return false;
    }
}
