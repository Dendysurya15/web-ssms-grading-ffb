<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estate extends Model
{
    use HasFactory;
    protected $connection = 'mysql3';

    protected $table = 'estate';


    public function Wilayah()
    {
        return $this->belongsTo(Wilayah::class, 'wil');
    }
}
