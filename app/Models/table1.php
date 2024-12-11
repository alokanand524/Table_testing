<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;
use Request;

class table1 extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email'];

    public function companies()
    {
        return $this->hasMany(companies::class, 'user_id');
    }
    public function searcByEmail($email){
        return table1::select(
            "*"
        )
        ->where("email",$email)
        ->first();
    }

}




