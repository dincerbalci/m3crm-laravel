<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ComplaintType extends Model
{
    use HasFactory;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbl_complaint_type';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'group_id', 'product_category_id', 'product_id','fullname','tat','operation_mode','isactive','created_on'
    ];
    /**
     * The table associated with the model disable auto created_at and updated_at.
     *
     * @var string
     */
    public $timestamps = false;

    public function complaintType($search)
    {
        $paginationEnv=env('PAGINATION');
      return  DB::table('tbl_complaint_type AS ct')
        ->join('tbl_product AS p', 'ct.product_id', '=', 'p.id')
        ->join('tbl_product_category AS pc', 'pc.id', '=', 'ct.product_category_id')
        ->select(DB::raw('ct.*,p.fullname AS product_name,pc.fullname AS category_name'))
        ->when($search, function ($query, $search) {
            return $query->whereRaw("CONCAT(ct.fullname,p.fullname,pc.fullname) like '%$search%'");
        })
        
        ->orderBy('ct.id', 'desc')->paginate($paginationEnv);
    }

}
