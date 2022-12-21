@extends('layouts.main')

@section('content')
<style>
    .grid-cols-12 {
    grid-template-columns: repeat(3, minmax(0, 1fr));
}
</style>
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
                        Edit Message & Announcement
                    </h2>
                </div>
                <form  method="POST" action="{{ route('announcement_update',$announcement->id) }}" enctype="multipart/form-data">
                    @csrf
                <div id="inline-form" class="p-5">
                    <div class="preview">
                        <div class="grid grid-cols-12 gap-2">
                            <div>
                            <label for="regular-form-1" class="form-label">Type<span style="color: red">*</span></label>
                                <select data-placeholder="Select your favorite actors" id="type" name="type" class="tom-select w-full tomselected" id="tomselect-1" tabindex="-1" hidden="hidden" required onchange="showAndHideDiv()">
                                    <option value="news" {{$announcement->type == 'news' ? 'Selected' : '' }}>News</option>
                                    <option value="message" {{$announcement->type == 'message' ? 'Selected' : '' }}>Message</option>
                                </select>
                            </div>
                            <div id="news">
                                <label for="regular-form-1" class="form-label">Group<span style="color: red">*</span></label>
                                    <select data-placeholder="Select your favorite actors" name="forward_to_user_type" class="tom-select w-full tomselected" id="tomselect-1" tabindex="-1" hidden="hidden" required>
                                        @for ($i = 0; $i < count($group); $i++) 
                                        <option value="{{$group[$i]->id}}" {{$announcement->forward_to_user_type == $group[$i]->id ? 'Selected' : ''}}>{{ucwords($group[$i]->group_name)}}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div id="message">
                                    <label for="regular-form-1" class="form-label">Users<span style="color: red">*</span></label>
                                        <select data-placeholder="Select your favorite actors" name="forward_to_user[]" class="tom-select w-full tomselected" id="tomselect-1" multiple tabindex="-1" hidden="hidden" required>
                                            @for ($i = 0; $i < count($user); $i++) 
                                            @php $users=explode(',',$announcement->forward_to_user) @endphp 
                                            <option value="{{$user[$i]->id}}" {{in_array($user[$i]->id, $users) ? "Selected" : ''}}>{{ucwords($user[$i]->first_name)}} {{ucwords($user[$i]->last_name)}}</option>
                                            @endfor
                                        </select>
                                </div>
                                <div id="file"> 
                                    <label for="regular-form-1" class="form-label">File<span style="color: red">*</span></label>
                                    <input type="file" class="form-control col-span-4" name="file" placeholder="Subject" aria-label="default input inline 2" >
                                </div>
                            <div>
                            <label for="regular-form-1" class="form-label">Subject<span style="color: red">*</span></label>
                            <input type="text" class="form-control col-span-4" value="{{$announcement->subject}}" name="subject" placeholder="Subject" aria-label="default input inline 2" required>
                        </div>
                        <div>
                            <label for="regular-form-1" class="form-label">Description <span style="color: red">*</span></label>
                            <textarea id="validation-form-6" class="form-control" onkeyup="validateAlphabetsAndNUumber(event)" name="description" placeholder="Description" minlength="10" maxlength='255' required>{{$announcement->description}}</textarea>
                        </div>
                        <div class="form-check form-switch sm:mt-0" style="margin-top: 17px;margin-bottom: 10px;">
                            <label for="regular-form-1" class="form-label">IsActive</label>
                            <input id="show-example-3" data-target="#header" name="is_active" {{$announcement->is_active == '1' ? "checked" : ''}} value="1" class="show-code form-check-input mr-0 ml-3" type="checkbox" >
                        </div>
                        </div>
                            <button type="submit" class="btn btn-primary mt-5">Update</button>
                    </div>
                   
                </div>
                </form>
           
        </div>
     
     
    </div>
    @push('scripts')
    <script>
        showAndHideDiv()
        function showAndHideDiv()
        {
            $type=$("#type").val();
            if($type == 'news')
            {
                $("#news").show();
                $("#message").hide();
                $("#file").hide();
               
                $("#news *").prop('disabled',false);
                $("#message *").prop('disabled',true);
                $("#file *").prop('disabled',true);
            }
            else if($type == 'message')
            {
                $("#news").hide()
                $("#message").show()
                $("#file").show()
                $("#news *").prop('disabled',true);
                $("#message *").prop('disabled',false);
                $("#file *").prop('disabled',false);
            }
            else
            {
                $("#news").hide()
                $("#message").hide()
                $("#file").hide()
                $("#news *").prop('disabled',true);
                $("#message *").prop('disabled',true);
                $("#file *").prop('disabled',true);
            }
        }
    </script>
    @endpush

@endsection
