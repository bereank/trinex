<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserGroup extends Model
{
    use HasFactory;

    protected $connection = 'mysql';

    protected $guarded = ['id'];

    protected $table = 'user_groups';

    public function usersdetails()
    {
        return $this->hasMany(UserDatabase::class, 'group_id');
    }
}
