@extends('layouts.main')

@section('content')
    <style>
        .grid-cols-12 {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    </style>
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Leads Management
        </h2>
    </div>
    <form id='complaint_form' method="POST" action="{{ route('lead.store') }}">
        @csrf
        <div class="grid grid-cols-12 gap-6 mt-5">
            <div class="intro-y col-span-12 lg:col-span-6">
                <!-- BEGIN: Input -->
                <div class="intro-y box">
                    <div
                        class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                        <h2 class="font-medium text-base mr-auto">
                            Add Leads
                        </h2>
                    </div>
                    <div id="inline-form" class="p-5">
                        <div class="preview">
                            <div class="grid grid-cols-12 gap-2">
                                <div>
                                    <label for="regular-form-1" class="form-label">Salutation <span
                                            style="color: red">*</span></label>
                                    <select data-placeholder="Select your favorite actors" name='salutation'
                                        class="tom-select w-full tomselected" id="tomselect-1" tabindex="-1"
                                        hidden="hidden" required>
                                        <option value="0" selected="true">-- Select Salutation --</option>
                                        <option value="Mr">Mr</option>
                                        <option value="Mrs">Mrs</option>
                                        <option value="Miss">Miss</option>
                                        <option value="Dr">Dr</option>
                                        <option value="Sir">Sir</option>
                                        <option value="Madam">Madam</option>
                                    </select>
                                    @error('salutation')
                                        <span class="text-danger" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                                <div>
                                    <label for="regular-form-1" class="form-label">Lead Name <span
                                            style="color: red">*</span></label>
                                    <input type="text" class="form-control col-span-4" name="lead_name"
                                        placeholder="Lead Name" aria-label="default input inline 2" required>
                                    @error('lead_name')
                                        <span class="text-danger" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                                <div>
                                    <label for="regular-form-1" class="form-label">CNIC <span
                                            style="color: red">*</span></label>
                                    <input type="text" id="cnic" class="form-control col-span-4" name="cnic"
                                        placeholder="42201-XXXXXXX-X" aria-label="default input inline 2" required>
                                    @error('cnic')
                                        <span class="text-danger" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                                <div class="mt-3">
                                    <label for="regular-form-1" class="form-label">Email <span
                                            style="color: red">*</span></label>
                                    <input type="email" class="form-control col-span-4" name="email" placeholder="Email"
                                        aria-label="default input inline 1" required>
                                    @error('email')
                                        <span class="text-danger" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                                <div class="mt-3">
                                    <label for="regular-form-1" class="form-label">Gender <span
                                            style="color: red">*</span></label>
                                    <select data-placeholder="Select your favorite actors" name='gender'
                                        class="tom-select w-full tomselected" id="tomselect-1" tabindex="-1"
                                        hidden="hidden" required>
                                        <option value="0" selected="true">-- Select Gender --</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="others">Others</option>
                                    </select>
                                    @error('gender')
                                        <span class="text-danger" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                                <div class="mt-3">
                                    <label for="regular-form-1" class="form-label">Lead Source
                                        <span style="color: red">*</span></label>
                                    <select data-placeholder="Select your favorite actors" name='lead_source'
                                        class="tom-select w-full tomselected" id="tomselect-1" tabindex="-1"
                                        hidden="hidden" required>
                                        <option value="0" selected="true">-- Lead Source --</option>
                                        <option value="Email">Email</option>
                                        <option value="Google">Google</option>
                                        <option value="Facebook">Facebook</option>
                                        <option value="Friend">Friend</option>
                                        <option value="Direct Visit">Direct Visit</option>
                                        <option value="Tv Ad">Tv Ad</option>
                                    </select>
                                    @error('lead_source')
                                        <span class="text-danger" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                                <div class="mt-3">
                                    <label for="regular-form-1" class="form-label">Lead Value<span
                                            style="color: red">*</span></label>
                                    <input type="text" class="form-control col-span-4" name="lead_value"
                                        placeholder="Lead Value" onkeypress="return validateNumbers(event)"
                                        aria-label="default input inline 1" required>
                                    @error('lead_value')
                                        <span class="text-danger" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                                <div class="mt-3">
                                    <label for="regular-form-1" class="form-label">Allow Follow Up <span
                                            style="color: red">*</span></label>
                                    <select data-placeholder="Select your favorite actors" name='allow_follow_up'
                                        class="tom-select w-full tomselected" id="tomselect-1" tabindex="-1"
                                        hidden="hidden" required>
                                        <option value="0" selected="true">-- Select Follow up --</option>
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                    </select>
                                    @error('allow_follow_up')
                                        <span class="text-danger" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                                <div class="mt-3">
                                    <label for="regular-form-1" class="form-label">Status <span
                                            style="color: red">*</span></label>
                                    <select data-placeholder="Select your favorite actors" name='status'
                                        class="tom-select w-full tomselected" id="tomselect-1" tabindex="-1"
                                        hidden="hidden" required>
                                        <option value="0" selected="true">-- Select Status --</option>
                                        <option value="initiated">Initiated</option>
                                        <option value="in process">In Process</option>
                                        <option value="follow up">Follow-up</option>
                                        <option value="bought">Bought</option>
                                        <option value="not interested">Not Interested</option>
                                        <option value="general inquiry">General Inquiry</option>
                                        <option value="convert to customer">Convert To Customer</option>
                                    </select>
                                    @error('status')
                                        <span class="text-danger" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                                @if ($userType == '1')
                                    <div class="mt-3">
                                        <label for="regular-form-1" class="form-label">Group<span
                                                style="color: red">*</span></label>
                                        <select data-placeholder="Select your favorite actors" id="group_id"
                                            name='group_id' class="tom-select w-full tomselected" id="tomselect-1"
                                            tabindex="-1" hidden="hidden" required onchange="getUser()">
                                            <option value="0" selected="true">Select Group
                                            </option>
                                            @for ($i = 0; $i < count($group); $i++)
                                                <option value="{{ $group[$i]->id }}">{{ $group[$i]->group_name }}
                                                </option>
                                            @endfor
                                        </select>
                                        @error('group')
                                            <span class="text-danger" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="mt-3">
                                        <label for="regular-form-1" class="form-label">Assigned to<span
                                                style="color: red">*</span></label>
                                        <select data-placeholder="Select your favorite actors" id="assigned_to"
                                            name='assigned_to' class="form-select" id="tomselect-1" required>
                                            <option value="0" selected="true">Select Assigned to</option>
                                            {{-- @for ($i = 0; $i < count($user); $i++)
                                                <option value="{{ $user[$i]->id }}">{{ $user[$i]->first_name }}
                                                    {{ $user[$i]->last_name }}
                                                </option>
                                            @endfor --}}
                                        </select>
                                        @error('assigned_to')
                                            <span class="text-danger" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                @else
                                    <input hidden name="assigned_to" value="0" />
                                @endif
                                <div class="mt-3">
                                    <label for="regular-form-1" class="form-label">Lead Category<span
                                            style="color: red">*</span></label>
                                    <select data-placeholder="Select your favorite actors" name='lead_category'
                                        class="tom-select w-full tomselected" id="tomselect-1" tabindex="-1"
                                        hidden="hidden" required>
                                        <option value="0" selected="true">-- Select Lead Category --</option>
                                        @for ($i = 0; $i < count($category); $i++)
                                            <option value="{{ $category[$i]->id }}">{{ $category[$i]->category }}
                                            </option>
                                        @endfor
                                    </select>
                                    @error('lead_category')
                                        <span class="text-danger" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                                <div class="mt-3">
                                    <label for="regular-form-1" class="form-label">Description<span
                                            style="color: red">*</span></label>
                                    <textarea id="validation-form-6" onkeyup="validateAlphabetsAndNUumber(event)" maxlength='255' class="form-control"
                                        name="description" placeholder="Enter details about lead" minlength="10" maxlength='255' required></textarea>
                                    @error('description')
                                        <span class="text-danger" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="intro-y col-span-12 lg:col-span-6">
                <!-- BEGIN: Input -->
                <div class="intro-y box">
                    <div
                        class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                        <h2 class="font-medium text-base mr-auto">
                            Company Details
                        </h2>
                    </div>
                    <div id="inline-form" class="p-5">
                        <div class="preview">
                            <div class="grid grid-cols-12 gap-2">
                                <div>
                                    <label for="regular-form-1" class="form-label">Company Name</label>
                                    <input type="text" class="form-control col-span-4 " name="company_name"
                                        placeholder="Company Name" aria-label="default input inline 1">
                                </div>
                                <div>
                                    <label for="regular-form-1" class="form-label">Website</label>
                                    <input type="text" class="form-control col-span-4 " name="website"
                                        placeholder="e.g. https://www.example.com" aria-label="default input inline 1">
                                </div>
                                <div>
                                    <label for="regular-form-1" class="form-label">Office Phone Number</label>
                                    <input type="text" class="form-control col-span-4 number"
                                        name="office_phone_number" placeholder="92-XXXXXXXX"
                                        aria-label="default input inline 1">
                                </div>
                                <div class="mt-3">
                                    <label for="regular-form-1" class="form-label">State</label>
                                    <input type="text" class="form-control col-span-4 " name="state"
                                        placeholder="State" aria-label="default input inline 1">
                                </div>
                                <div class="mt-3">
                                    <label for="regular-form-1" class="form-label">City</label>
                                    <input type="text" class="form-control col-span-4 " name="city"
                                        placeholder="City" aria-label="default input inline 1">
                                </div>
                                <div class="mt-3">
                                    <label for="regular-form-1" class="form-label">Postal code</label>
                                    <input type="text" class="form-control col-span-4 " name="postal_code"
                                        placeholder="Postal code" aria-label="default input inline 1">
                                </div>
                                <div class="mt-3">
                                    <label for="regular-form-1" class="form-label">Address</label>
                                    <textarea id="validation-form-6" onkeyup="validateAlphabetsAndNUumber(event)" class="form-control" name="address"
                                        placeholder="Enter Address" minlength="10" maxlength='255'></textarea>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-5">Save</button>

                    </div>

                </div>
            </div>
        </div>
    </form>

    @push('scripts')
        <script>
            function getUser() {
                val = $("#group_id").val();
                let value = {
                    group_id: val,
                };
                $.ajax({
                    type: 'GET',
                    url: "{{ route('lead_user') }}",
                    data: value,
                    success: function(result) {
                        document.getElementById('assigned_to').innerHTML =
                            '<option value="0" selected="true">Select Assigned to</option>';
                        for (var i = 0; i < result.length; i++) {
                            var product = document.createElement('option');
                            product.value = result[i].id;
                            product.innerHTML = result[i].first_name + result[i].last_name;
                            document.getElementById('assigned_to').appendChild(product);
                        }
                    }
                });
            }
        </script>
    @endpush

@endsection
