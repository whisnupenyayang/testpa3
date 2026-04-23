<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class JournalText extends Model
{
    use HasFactory;

    protected $fillable = [
        'nim',
        'description',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'nim', 'nim');
    }
}
