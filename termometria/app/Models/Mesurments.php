<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mesurments extends Model
{
    use HasFactory;

    // Set the table name if it doesn't follow Laravel's naming convention
    protected $table = 'mesurments';

    // Set primary key if it is not 'id' (default in Laravel)
    protected $primaryKey = 'ID';

    // Disable auto-increment if ID is not auto-incremented
    public $incrementing = false;

    // Specify data type of primary key
    protected $keyType = 'integer';

    // Disable timestamps if your table doesn't have `created_at` and `updated_at` columns
    public $timestamps = false;

    // Define the fillable fields
    protected $fillable = [
        'Device_ID',
        'Temperature',
        'Pressure',
        'Humidity',
        'Date',
    ];
}