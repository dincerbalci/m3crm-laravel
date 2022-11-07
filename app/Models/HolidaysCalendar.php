<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HolidaysCalendar extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbl_calendar_holidays';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'event_name', 'from_date', 'to_date','is_repeat','created_datetime','updated_datetime'
    ];
    /**
     * The table associated with the model disable auto created_at and updated_at.
     *
     * @var string
     */
    public $timestamps = false;
}
