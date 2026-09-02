<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\Authenticatable;

class Admin extends Model implements Authenticatable
{
    use Notifiable;

    protected $table = 'admin';

    protected $fillable = ['email', 'password'];
    protected $hidden = ['password'];

    public function getAuthIdentifierName() { return 'id'; }
    public function getAuthIdentifier() { return $this->getKey(); }
    public function getAuthPassword() { return $this->password; }
    public function getRememberToken() { return null; }
    public function setRememberToken($value) {}
    public function getRememberTokenName() { return null; }
}
