<?php

namespace App\Http\Controllers;

use App\Models\Template;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search=$request->search;
        $paginationEnv=env('PAGINATION');
        $template=Template::where('is_active','1')->orderby('id','desc')
        ->when($search, function ($query, $search) {
            return $query->whereRaw("CONCAT(template_type,template_name) like '%$search%'");
        })
        ->paginate($paginationEnv);
        $template->appends(['search' => $search]);
        return view('admin/template/template_index',compact('template'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/template/template_create');
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
            'template_type' => ['required'],
            'template_name' => ['required'],
            'template_desc' => ['required'],
            'template_subject' => ['required'],
            'template_detail' => ['required'],
        ]);
        $isActive=is_null($request->is_active) ? '0' : '1';
        $templateDetail = $request->template_type == 'SMS' ? strip_tags($request->template_detail) : $request->template_detail;
        
        $data = Template::create([
            'template_type' => $request->template_type,
            'template_name' => $request->template_name,
            'template_desc' => $request->template_desc,
            'template_subject' => $request->template_subject,
            'template_detail' => $templateDetail,
            'is_active' => $isActive,
            'create_date'=> GetCurrentDateTime(),
        ]);
        session()->flash('message', 'Successfully Saved!');
        session()->flash('alert-type', 'success');
        return $this->redirect();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Template  $template
     * @return \Illuminate\Http\Response
     */
    public function show(Template $template)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Template  $template
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $template=Template::find($id);
        return view('admin/template/template_edit',compact('template'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Template  $template
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $request->validate([
            'template_type' => ['required'],
            'template_name' => ['required'],
            'template_desc' => ['required'],
            'template_subject' => ['required'],
            'template_detail' => ['required'],
        ]);
        $isActive=is_null($request->is_active) ? '0' : '1';
        $templateDetail = $request->template_type == 'SMS' ? strip_tags($request->template_detail) : $request->template_detail;

        $template=Template::find($id);
        $template['template_type']=$request->template_type;
        $template['template_name']=$request->template_name;
        $template['template_desc']=$request->template_desc;
        $template['template_subject']=$request->template_subject;
        $template['template_detail']=$templateDetail;
        $template['is_active']=$isActive;
        $template['update_date']=GetCurrentDateTime();
        $template->save();
        session()->flash('message', 'Successfully Updated!');
        session()->flash('alert-type', 'success');
        return $this->redirect();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Template  $template
     * @return \Illuminate\Http\Response
     */
    public function destroy(Template $template)
    {
        //
    }
    public function chat()
    {
        return view('admin/chat/chat_view');

    }
    private function redirect()
    {
        return redirect()->route('template.index');
    }
}
