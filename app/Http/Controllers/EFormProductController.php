<?php

namespace App\Http\Controllers;

use App\Models\EFormProduct;
use Illuminate\Http\Request;
use App\Models\EFormCategory;


class EFormProductController extends Controller
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
        $eFormProduct=EFormProduct::with('eFormCategory')->orderBy('id', 'desc')
        ->when($search, function ($query, $search) {
            return $query->where('fullname', 'like', '%' . $search . '%');
        })
        ->paginate($paginationEnv);
        $eFormProduct->appends(['search' => $search]);

        return view('admin/e-form-product/e_form_product_index',compact('eFormProduct'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $eFormCategory=EFormCategory::where('isactive','1')->get();
        return view('admin/e-form-product/e_form_product_create',compact('eFormCategory'));
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
        
        $data = EFormProduct::create([
            'product_code' => $request->product_code,
            'fullname' => $request->product_name,
            'product_category' => $request->product_category_id,
            'isactive' => $isactive,
        ]);
        $this->ActivityLogs("Add Product tbl_product_eform [ProductId: $data->id, Product Name: $request->product_name]");
        return $this->redirect();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EFormProduct  $eFormProduct
     * @return \Illuminate\Http\Response
     */
    public function show(EFormProduct $eFormProduct)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EFormProduct  $eFormProduct
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $eFormCategory=EFormCategory::where('isactive','1')->get();
        $eFormProduct=EFormProduct::find($id);
        return view('admin/e-form-product/e_form_product_edit',compact('eFormCategory','eFormProduct'));
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EFormProduct  $eFormProduct
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
        $eFormProduct = EFormProduct::find($id);
        $eFormProduct['product_code']=$request->product_code;
        $eFormProduct['fullname']=$request->product_name;
        $eFormProduct['product_category']=$request->product_category_id;
        $eFormProduct['isactive']=$isactive;
        $eFormProduct->save();
        $this->ActivityLogs("Edit Product tbl_product_eform [ProductId: $id, Product Name: $request->product_name]");

        return $this->redirect();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EFormProduct  $eFormProduct
     * @return \Illuminate\Http\Response
     */
    public function destroy(EFormProduct $eFormProduct)
    {
        //
    }
    private function redirect()
    {
        return redirect()->route('e_form_product_index');
            
    }
}
