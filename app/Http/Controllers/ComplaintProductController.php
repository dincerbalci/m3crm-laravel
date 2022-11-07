<?php

namespace App\Http\Controllers;

use App\Models\ComplaintProduct;
use Illuminate\Http\Request;
use App\Models\ComplaintCategory;


class ComplaintProductController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $paginationEnv=env('PAGINATION');

        $search=$request->search;
        $complaintProduct=ComplaintProduct::with('complaintCategory')->orderBy('id', 'desc')
        ->when($search, function ($query, $search) {
            return $query->where('fullname', 'like', '%' . $search . '%');
        })
        ->paginate($paginationEnv);
        $complaintProduct->appends(['search' => $search]);
      return view('admin/complaint-product/complaint_product_index',compact('complaintProduct'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $complainCategory=ComplaintCategory::where('isactive','1')->get();
        return view('admin/complaint-product/complaint_product_create',compact('complainCategory'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_code' => ['required'],
            'product_category_id' => ['required'],
            'product_name' => ['required'],
        ]);
        $isactive=is_null($request->is_active) ? '0' : '1';
        
        $data = ComplaintProduct::create([
            'product_code' => $request->product_code,
            'fullname' => $request->product_name,
            'product_category' => $request->product_category_id,
            'isactive' => $isactive,
        ]);
        $this->ActivityLogs("Add Product tbl_product [ProductId: $data->id, Product Name: $request->product_name]");
        return $this->redirect();
        // 'end_date' => GetCurrentDate(),
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ComplaintProduct  $complaintProduct
     * @return \Illuminate\Http\Response
     */
    public function show(ComplaintProduct $complaintProduct)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ComplaintProduct  $complaintProduct
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $complainCategory=ComplaintCategory::where('isactive','1')->get();
        $complaintProduct=ComplaintProduct::find($id);
        return view('admin/complaint-product/complaint_product_edit' ,compact('complainCategory','complaintProduct'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ComplaintProduct  $complaintProduct
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $request->validate([
            'product_code' => ['required'],
            'product_category_id' => ['required'],
            'product_name' => ['required'],
        ]);
        $isactive=is_null($request->is_active) ? '0' : '1';
        $complaintProduct = ComplaintProduct::find($id);
        $complaintProduct['product_code']=$request->product_code;
        $complaintProduct['fullname']=$request->product_name;
        $complaintProduct['product_category']=$request->product_category_id;
        $complaintProduct['isactive']=$isactive;
        $complaintProduct->save();
        $this->ActivityLogs("Edit Product tbl_product [ProductId: $id, Product Name: $request->product_name]");

        return $this->redirect();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ComplaintProduct  $complaintProduct
     * @return \Illuminate\Http\Response
     */
    public function destroy(ComplaintProduct $complaintProduct)
    {
        //
    }
    private function redirect()
    {
        return redirect()->route('complaint_product_index');

    }
}
