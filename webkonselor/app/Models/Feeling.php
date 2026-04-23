<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class Feeling extends Model
{
    use HasFactory;

    // no explicit primaryKey so MongoDB uses default _id
    protected $fillable = [
        'feeling_name',
        'feeling_code',
    ];

    public function dailyCheckins()
    {
        return $this->hasMany(DailyCheckin::class, 'feeling_id', 'feeling_id');
    }
}
