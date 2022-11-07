@extends('layouts.main')

@section('content')
<style>
    .grid-cols-12 {
    grid-template-columns: repeat(3, minmax(0, 1fr));
}
</style>
<div class="content">
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Administration
        </h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 lg:col-span-6">
            <!-- BEGIN: Input -->
            <div class="intro-y box">
                <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="font-medium text-base mr-auto">
                        Add Template
                    </h2>
                </div>
                <form  method="POST" action="{{ route('template.update',$template->id) }}" >
                    @method("PUT")
                    @csrf
                <div id="inline-form" class="p-5">
                    <div class="preview">
                        <div class="grid grid-cols-12 gap-2">
                            <div>
                            <label for="regular-form-1" class="form-label">Tempate Type  <span style="color: red">*</span></label>
                                <select data-placeholder="Select your favorite actors" name="template_type" class="tom-select w-full tomselected" id="tomselect-1" tabindex="-1" hidden="hidden" required>
                                    <option value="Attachement" {{$template->template_type == "Attachement" ? "Selected": ""}}>Attachement</option>
                                    <option value="Email" {{$template->template_type == "Email" ? "Selected": ""}}>Email</option>
                                    <option value="SMS" {{$template->template_type == "SMS" ? "Selected": ""}}>SMS</option>
                                </select>
                            </div>
                            <div>
                            <label for="regular-form-1" class="form-label">Tempate Name <span style="color: red">*</span></label>
                            <input type="text" class="form-control col-span-4" value="{{$template->template_name}}" name="template_name" placeholder="Tempate Name" aria-label="default input inline 2" required>
                        </div>
                        <div>
                            <label for="regular-form-1" class="form-label">Description <span style="color: red">*</span></label>
                            <textarea id="validation-form-6" class="form-control"  name="template_desc" placeholder="Additional Information" minlength="10" >{{$template->template_desc}}</textarea>
                        </div>
                        <div>
                            <label for="regular-form-1" class="form-label">Subject <span style="color: red">*</span></label>
                            <input type="text" class="form-control col-span-4" value="{{$template->template_subject}}" name="template_subject" placeholder="Subject" aria-label="default input inline 2" required>
                        </div>
                        <div class="form-check form-switch sm:mt-0" style="margin-top: 17px;margin-bottom: 10px;">
                            <label for="regular-form-1" class="form-label">IsActive</label>
                            <input id="show-example-3" data-target="#header" {{$template->is_active == '1' ? 'checked' : ''}} name="is_active" class="show-code form-check-input mr-0 ml-3" type="checkbox" >
                        </div>
                        
                        </div>
                        <textarea hidden name="template_detail" id="template_detail">{{$template->template_detail}}</textarea>
                        <div class="grid grid-cols-12 gap-6 mt-5">
                            <!-- BEGIN: Classic Editor -->
                            <div class="col-span-12">
                                <div class="box">
                                    <div class="flex flex-col p-5 border-b  dark:border-darkmode-400">
                                        <div id="faq-accordion-2" class="accordion accordion-boxed">
                                            <div class="accordion-item">
                                                <div id="faq-accordion-content-5" class="accordion-header">
                                                    <button class="accordion-button collapsed" type="button" data-tw-toggle="collapse" data-tw-target="#faq-accordion-collapse-5" aria-expanded="false" aria-controls="faq-accordion-collapse-5">Short Code</button>
                                                </div>
                                                <div id="faq-accordion-collapse-5" class="accordion-collapse collapse" aria-labelledby="faq-accordion-content-5" data-tw-parent="#faq-accordion-2" style="display: block;">
                                                        <mark class="p-1 bg-yellow-200" style="margin: 3px;cursor: pointer;">{CUSTOMER_NAME}
                                                        </mark>
                                                        <mark class="p-1 bg-yellow-200" style="margin: 3px;cursor: pointer;">{COMPLAINT_NUMBER}
                                                        </mark>
                                                        <mark class="p-1 bg-yellow-200" style="margin: 3px;cursor: pointer;">{COMPLAINT_NAME}
                                                        </mark>
                                                        <mark class="p-1 bg-yellow-200" style="margin: 3px;cursor: pointer;">{COMPLAINT_STATUS}
                                                        </mark>
                                                        <mark class="p-1 bg-yellow-200" style="margin: 3px;cursor: pointer;">{COMPLAINT_PROGRESS}
                                                        </mark>
                                                        <mark class="p-1 bg-yellow-200" style="margin: 3px;cursor: pointer;">{BRANCH_NAME}
                                                        </mark>
                                                        <mark class="p-1 bg-yellow-200" style="margin: 3px;cursor: pointer;">{E_FORM_NUMBER}
                                                        </mark>
                                                        <mark class="p-1 bg-yellow-200" style="margin: 3px;cursor: pointer;">{E_FORM_STATUS}
                                                        </mark>
                                                        <mark class="p-1 bg-yellow-200" style="margin: 3px;cursor: pointer;">{USER_NAME}
                                                        </mark>
                                                        <mark class="p-1 bg-yellow-200"style="margin: 3px;cursor: pointer;">{DATE}
                                                        </mark>
                                                        <mark class="p-1 bg-yellow-200"style="margin: 3px;cursor: pointer;">{COMPLAINT_CATEGORY}
                                                        </mark>
                                                        <mark class="p-1 bg-yellow-200"style="margin: 3px;cursor: pointer;">{COMPLAINT_PRODUCT}
                                                        </mark>
                                                        <mark class="p-1 bg-yellow-200"style="margin: 3px;cursor: pointer;">{COMPLAINT_TYPE}
                                                        </mark>
                                                        <mark class="p-1 bg-yellow-200"style="margin: 3px;cursor: pointer;">{ASSIGNEE}
                                                        </mark>
                                                        <mark class="p-1 bg-yellow-200"style="margin: 3px;cursor: pointer;">{DUE_DATE}
                                                        </mark>
                                                        <mark class="p-1 bg-yellow-200"style="margin: 3px;cursor: pointer;">{AGING}
                                                        </mark>
                                                        <mark class="p-1 bg-yellow-200"style="margin: 3px;cursor: pointer;">{REMAINING_TAT}
                                                        </mark>
                                                        <mark class="p-1 bg-yellow-200"style="margin: 3px;cursor: pointer;">{OVERALL_TAT}
                                                        </mark>
                                                        <mark class="p-1 bg-yellow-200"style="margin: 3px;cursor: pointer;">{CURRENT_ESCALATION_LEVEL}
                                                        </mark>
                                                        <mark class="p-1 bg-yellow-200"style="margin: 3px;cursor: pointer;">{DESCRIPTION}
                                                        </mark>
                                                 </div>
                                            </div>
                                            
                                        </div>
                                        {{-- <h2 class="font-medium text-base mr-auto">
                                            Classic Editor
                                        </h2> --}}
                                       
                                    </div>
                                    <div class="p-5" id="classic-editor">
                                        <div class="preview">
                                            <div class="editor">
                                                @php echo html_entity_decode($template->template_detail) @endphp
                                            </div>
                                        </div>
                                        <div class="source-code hidden">
                                            <button data-target="#copy-classic-editor" class="copy-code btn py-1 px-2 btn-outline-secondary"> <i data-lucide="file" class="w-4 h-4 mr-2"></i> Copy example code </button>
                                            <div class="overflow-y-auto mt-3 rounded-md">
                                                <pre class="source-preview" id="copy-classic-editor"> <code class="javascript"> import ClassicEditor from &quot;@ckeditor/ckeditor5-build-classic&quot;; $(&quot;.editor&quot;).each(function () { const el = this; ClassicEditor.create(el).catch((error) =HTMLCloseTag { console.error(error); }); }); </code> </pre>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END: Classic Editor -->
                        </div>
                   
                            <button type="submit" class="btn btn-primary mt-5">Update</button>
                        
                    </div>
                   
                </div>
                </form>
           
        </div>
     
     
    </div>
</div>
@push('scripts')
<script src="{{ asset('theme/dist/js/ckeditor-classic.js')}}"></script>
<script>
$(".ck-editor__editable_inline").keyup(function(){
    summerNote=document.getElementsByClassName('ck-editor__editable_inline');
    $('#template_detail').val(summerNote[0].innerHTML);
  });
  $(".ck-toolbar__items").click(function(){
    summerNote=document.getElementsByClassName('ck-editor__editable_inline');
    $('#template_detail').val(summerNote[0].innerHTML);
});
  
  </script>
@endpush

@endsection
