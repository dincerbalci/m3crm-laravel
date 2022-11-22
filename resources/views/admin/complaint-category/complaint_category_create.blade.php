@extends('layouts.main')

@section('content')
<style>
    .grid-cols-12 {
    grid-template-columns: repeat(3, minmax(0, 1fr));
}
</style>
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Product Management
        </h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 lg:col-span-6">
            <!-- BEGIN: Input -->
            <div class="intro-y box">
                <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="font-medium text-base mr-auto">
                        Add Product Category Complaint
                    </h2>
                </div>
                <form  method="POST" action="{{ route('complaint_category_create') }}" >
                    @csrf
                <div id="inline-form" class="p-5">
                    <div class="preview">
                        <div class="grid grid-cols-12 gap-2">
                            <div>
                            <label for="regular-form-1" class="form-label">Product Category<span style="color: red">*</span></label>
                            <input type="text" class="form-control col-span-4" name='product_category' placeholder="Product Category" aria-label="default input inline 2" required>
                        </div>
                      
                        <div class="form-check form-switch  sm:mt-0" style="margin-top: 13px;">
                            <label for="regular-form-1" class="form-label">Is Active</label>
                            <input id="show-example-3" data-target="#header" name='is_active' checked value="1" class="show-code form-check-input mr-0 ml-3" type="checkbox">
                        </div>
                        </div>
                        
                    </div>
                   
                    <button type="submit" class="btn btn-primary mt-5">Save</button>
                </div>
            </form>
           
        </div>
     
     
    </div>
 
</div>
@endsection
