<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HoursTransaction extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'worked_hours', 'is_done', 'hours_transaction_created'];

}
