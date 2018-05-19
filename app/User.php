<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_role');
    }

    /**
     * Метод возвращает true, если пользователь администратор, в противном случае false
     * @return bool
     */
    public function isAdmin()
    {
        return $this->roles()->where('name', 'admin')->exists();
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->remember_token = str_random(30);
        });
    }

    /**
     * Метод устанавливает поля verified и remember_token модели User и сохраняет изменения
     */
    public function confirmEmail()
    {
        $this->verified = true;
        $this->remember_token = null;
        $this->save();
    }
}
