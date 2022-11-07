<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbl_groups';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'group_name', 'email', 'isactive','created_by','created_on','updated_by','updated_on'
    ];
    /**
     * The table associated with the model disable auto created_at and updated_at.
     *
     * @var string
     */
    public $timestamps = false;

}
