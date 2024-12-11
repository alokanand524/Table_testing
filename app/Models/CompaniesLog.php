<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompaniesLog extends Model
{
    use HasFactory;

    // Specify the table name if it doesn't follow Laravel's conventions
    protected $table = 'companies_log';

    // Define the fillable attributes
    protected $fillable = [
        'user_id',
        'company_id',
        'company_name',
    ];

    // Optionally, you can define relationships here if needed
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function company()
    {
        return $this->belongsTo(companies::class);
    }

}
