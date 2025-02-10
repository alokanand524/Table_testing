<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationGenerate extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_number',
        'name',
        'email',
    ];
}
