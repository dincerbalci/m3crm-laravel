<?php

namespace App\Http\Controllers;

use App\Models\ComplaintCategory;
use Illuminate\Http\Request;


class ComplaintCategoryController extends Controller
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
        $complaintCategory=ComplaintCategory::orderBy('id', 'desc')
        ->when($search, function ($query, $search) {
            return $query->where('fullname', 'like', '%' . $search . '%');
        })
        ->paginate($paginationEnv);
        $complaintCategory->appends(['search' => $search]);
        return view('admin/complaint-category/complaint_category_index',compact('complaintCategory'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/complaint-category/complaint_category_create');
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
        
        $data = ComplaintCategory::create([
            'fullname' => $request->product_category,
            'isactive' => $isactive,
            'end_date' => GetCurrentDate(),
        ]);
        $this->ActivityLogs("Add Product Category tbl_product_category [CategoryId:$data->id, Category Name: $request->product_category]");
        return $this->redirect();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ComplaintCategory  $complaintCategory
     * @return \Illuminate\Http\Response
     */
    public function show(ComplaintCategory $complaintCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ComplaintCategory  $complaintCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $complaintCategory=ComplaintCategory::find($id);
        return view('admin/complaint-category/complaint_category_edit',compact('complaintCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ComplaintCategory  $complaintCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $request->validate([
            'product_category' => ['required'],
        ]);
        $isactive=is_null($request->is_active) ? '0' : '1';
        $complaintCategory = ComplaintCategory::find($id);
        $complaintCategory['fullname']=$request->product_category;
        $complaintCategory['isactive']=$isactive;
        $complaintCategory->save();
        $this->ActivityLogs("Update Product Category tbl_product_category [CategoryId:$id, Category Name: $request->product_category]");
        return $this->redirect();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ComplaintCategory  $complaintCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(ComplaintCategory $complaintCategory)
    {
        //
    }
    private function redirect()
    {   

        return redirect()->route('complaint_category_index');
    }
}
