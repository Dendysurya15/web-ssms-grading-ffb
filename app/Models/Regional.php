<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regional extends Model
{
    protected $connection = 'mysql2';

    protected $table = 'reg';
    use HasFactory;

    public function Wilayah()
    {
        return $this->hasMany(Wilayah::class, 'regional');
    }
}
