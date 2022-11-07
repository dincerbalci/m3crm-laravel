<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Role extends Model
{
    use HasFactory;
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbl_roles';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'primary_name', 'secondary_name', 'email','expiry_date','isactive','created_on','updated_on'
    ];
    /**
     * The table associated with the model disable auto created_at and updated_at.
     *
     * @var string
     */
    public $timestamps = false;

    public function GetParentModules()
    {
        return DB::select(DB::raw("SELECT tbl_modules.id, tbl_modules.name FROM tbl_modules WHERE isactive = 1 and parent_id = '0' "));
    }
    public static function GetModules($parentId)
    {
        return DB::select(DB::raw("SELECT tbl_modules.id, tbl_modules.name FROM tbl_modules WHERE parent_id = '$parentId' and isactive = 1"));
    }
}
