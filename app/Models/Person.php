<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'email', 'mobile'];

    public function transactions()
    {
        return $this->hasMany(people_trans::class);
    }

}
// app/Models/Person.php

