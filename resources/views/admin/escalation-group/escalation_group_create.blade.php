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
                <div
                    class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="font-medium text-base mr-auto">
                        Escalation Group Add
                    </h2>
                </div>
                <form method="POST" action="{{ route('escalation_group.store') }}">
                    @csrf
                    <div id="inline-form" class="p-5">
                        <div class="preview">
                            <div class="grid grid-cols-12 gap-2">
                                <div>
                                    <label for="regular-form-1" class="form-label">Escalation Group Name <span
                                            style="color: red">*</span></label>
                                    <input type="text" name="group_name" class="form-control col-span-4"
                                        placeholder="Escalation Group Name" aria-label="default input inline 2" required>
                                    {{-- <div class="form-help">Note: Enter values in hours.</div> --}}
                                </div>

                            </div>
                            <div class="grid grid-cols-12 gap-2" id='clonediv'>
                                <div class="mt-3">
                                    <label for="regular-form-1" class="form-label">User Name </label>
                                    <input type="text" class="form-control col-span-4" name="full_name[]"
                                        placeholder="User Name" aria-label="default input inline 2">
                                </div>

                                <div class="mt-3">
                                    <label for="regular-form-1" class="form-label">User Email </label>
                                    <input type="email" class="form-control col-span-4" name="email[]"
                                        placeholder="User Email" aria-label="default input inline 2">
                                </div>
                                <div style="margin-top: 39px;">
                                    <button type="button" class="btn btn-primary mr-1 mb-2" onclick="appendDiv(this)"> <svg
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" icon-name="activity"
                                            data-lucide="activity" class="lucide lucide-activity w-5 h-5">
                                            <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                                        </svg> </button>
                                    <button type="button" class="btn btn-danger mr-1 mb-2" style="display: none"
                                        onclick="removeDiv(this)"> <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            icon-name="trash" data-lucide="trash" class="lucide lucide-trash w-5 h-5">
                                            <polyline points="3 6 5 6 21 6"></polyline>
                                            <path
                                                d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2">
                                            </path>
                                        </svg> </button>
                                </div>
                            </div>
                            <div id='appenddiv'>
                            </div>
                            <button type="submit" class="btn btn-primary mt-5">Save</button>

                        </div>

                    </div>
                </form>

            </div>


        </div>
    </div>
    <script>
        function removeDiv(obj) {
            obj.parentElement.parentElement.remove()
            i--;
        }
        var i = 0;

        function appendDiv(obj) {
            if (i == 5) {
                alert('Limit is 5');
                return false;
            }
            ids = obj.parentElement.parentElement.id;
            aa = $('#' + ids).clone();
            aa[0].children[2].children[0].remove();
            aa[0].children[2].children[0].style.display = 'block';
            aa[0].id = '';
            aa[0].children[0].children[1].value = '';
            aa[0].children[1].children[1].value = '';
            aa.appendTo("#appenddiv");
            i++;


        }


        function assignee(val) {
            if (val == 'auto') {
                $('#aaa').show();
            }
            if (val == 'manual') {
                $('#aaa').hide();
            }
        }
    </script>
@endsection
