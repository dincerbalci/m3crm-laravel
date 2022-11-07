<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ComplaintCategory;

class ComplaintProduct extends Model
{
    use HasFactory;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbl_product';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_code', 'fullname', 'product_category','isactive','end_date'
    ];
    /**
     * The table associated with the model disable auto created_at and updated_at.
     *
     * @var string
     */
    public $timestamps = false;

    public function complaintCategory()
    {
        return $this->belongsTo(ComplaintCategory::class,'product_category');
    }
}
