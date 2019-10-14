<?php

namespace App;

use Storage;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasRoles;

    protected $guard_name = 'api';

    protected $fillable = [
        'name', 'apellido', 'direccion', 'departamento_id', 'celular', 'fecha_naci', 'cedula', 'nit', 'telefono', 'email', 'password', 'avatar', 'estado_user', 'avatar_url'
    ];

    protected $hidden = [
        'password', 'created_at', 'updated_at', 'email_verified_at', 'remember_token',
    ];

    protected $appends = ['avatar_url'];

    public function getAvatarUrlAttribute()
    {
        return Storage::url('avatars/'.$this->id.'/'.$this->avatar);
    }
    
    public function estados()
    {
        return $this->belongsToMany('App\Modelos\Estado')->withPivot('User_id', 'Estado_id', 'Actualizado_por')->withTimestamps();
    }

    public function agendas(){
        return $this->hasMany('App\Modelos\agenda');
    }
}
