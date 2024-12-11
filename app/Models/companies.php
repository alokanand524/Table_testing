<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

class companies extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'company_name'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function companyLog()
    {
        return $this->hasMany(CompaniesLog::class);

    }



}

