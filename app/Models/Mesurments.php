<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mesurments extends Model
{
    use HasFactory;
    protected $table = 'mesurments';
    protected $primaryKey = 'ID';
    public $incrementing = false;
    protected $keyType = 'integer';
    public $timestamps = false;
    protected $fillable = [
        'Device_ID',
        'Temperature',
        'Pressure',
        'Humidity',
        'Date',
    ];
}