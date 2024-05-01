<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'birthday',
        'gender_id',
        'description',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * @param string $field
     * @return void
     */
    public static function setToken(string $field): void
    {
        $obj = self::find(Auth::user()->id);
        $obj->token = $field;
        $obj->save();
    }

    /**
     * @param array $fields
     * @return void
     */
    public static function add_comment_user(array $fields): void
    {
        $object = self::find($fields['id']);
        $object->comment = $fields['comment'];
        $object->save();
    }

    /**
     * @param array $fields
     * @return void
     */
    public static function add(array $fields): void
    {
        $object = new self();
        $object->fill($fields);
        $object->password = bcrypt($fields['password']);
        $object->save();
    }

    /**
     * @param array $fields
     * @param string $id
     * @return void
     */
    public static function edit(array $fields, string $id): void
    {
        $object = self::find($id);
        $object->fill($fields);
        if (!is_null($fields['password'])) {
            $object->password = bcrypt($fields['password']);
        }
        $object->save();
    }

    /**
     * @param string $id
     * @return void
     */
    public static function remove(string $id): void
    {
        $object = self::find($id);
        $object->delete();
    }

    /**
     * @return string
     */
    public function getAvatar(): string
    {
        if ($this->profile_photo_path == null) {
            return '/profile-photos/no-user-image.png';
        }

        return '/'.$this->profile_photo_path;
    }


}
