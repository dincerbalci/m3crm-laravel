<?php

namespace App\Http\Controllers;

use App\Models\EFormCategory;
use Illuminate\Http\Request;

class EFormCategoryController extends Controller
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
        $eFormCategory=EFormCategory::orderBy('id', 'desc')
        ->when($search, function ($query, $search) {
            return $query->where('fullname', 'like', '%' . $search . '%');
        })
        ->paginate($paginationEnv);
        $eFormCategory->appends(['search' => $search]);
        return view('admin/e-form-category/e_form_category_index',compact('eFormCategory'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/e-form-category/e_form_category_create');
        
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
            'product_category' => ['required'],
        ]);
        $isactive=is_null($request->is_active) ? '0' : '1';
        
        $data = EFormCategory::create([
            'fullname' => $request->product_category,
            'isactive' => $isactive,
        ]);
        $this->ActivityLogs("Add Product Category tbl_product_category_eform [CategoryId:$data->id, Category Name: $request->product_category]");
        session()->flash('message', 'Successfully Saved!');
        session()->flash('alert-type', 'success');
        return $this->redirect();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EFormCategory  $eFormCategory
     * @return \Illuminate\Http\Response
     */
    public function show(EFormCategory $eFormCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EFormCategory  $eFormCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $eFormCategory=EFormCategory::find($id);
        return view('admin/e-form-category/e_form_category_edit',compact('eFormCategory'));
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EFormCategory  $eFormCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $request->validate([
            'product_category' => ['required'],
        ]);
        $isactive=is_null($request->is_active) ? '0' : '1';
        $complaintCategory = EFormCategory::find($id);
        $complaintCategory['fullname']=$request->product_category;
        $complaintCategory['isactive']=$isactive;
        $complaintCategory->save();
        $this->ActivityLogs("Update Product Category tbl_product_category_eform [CategoryId:$id, Category Name: $request->product_category]");
        session()->flash('message', 'Successfully Updated!');
        session()->flash('alert-type', 'success');
        return $this->redirect();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EFormCategory  $eFormCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(EFormCategory $eFormCategory)
    {
        //
    }
    private function redirect()
    {   
        return redirect()->route('e_form_category_index');
    }
}
