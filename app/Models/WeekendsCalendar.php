<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeekendsCalendar extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbl_calendar_weekends';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'effective_from', 'effective_to', 'week_day','created_on','updated_on'
    ];
    /**
     * The table associated with the model disable auto created_at and updated_at.
     *
     * @var string
     */
    public $timestamps = false;
}
