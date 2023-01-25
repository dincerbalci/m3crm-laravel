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
    <form id='complaint_form' method="POST" action="{{ route('lead.update', $lead->id) }}">
        @method('PUT')
        @csrf
        <input hidden name="id" value="{{ $lead->id }}" />
        <div class="grid grid-cols-12 gap-6 mt-5">
            <div class="intro-y col-span-12 lg:col-span-6">
                <!-- BEGIN: Input -->
                <div class="intro-y box">
                    <div
                        class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                        <h2 class="font-medium text-base mr-auto">
                            Edit Leads
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
                                        <option value="Mr" {{ $lead->salutation == 'Mr' ? 'Selected' : '' }}>Mr</option>
                                        <option value="Mrs" {{ $lead->salutation == 'Mrs' ? 'Selected' : '' }}>Mrs
                                        </option>
                                        <option value="Miss" {{ $lead->salutation == 'Miss' ? 'Selected' : '' }}>Miss
                                        </option>
                                        <option value="Dr" {{ $lead->salutation == 'Dr' ? 'Selected' : '' }}>Dr</option>
                                        <option value="Sir" {{ $lead->salutation == 'Sir' ? 'Selected' : '' }}>Sir
                                        </option>
                                        <option value="Madam" {{ $lead->salutation == 'Madam' ? 'Selected' : '' }}>Madam
                                        </option>
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
                                        placeholder="Lead Name" value="{{ $lead->lead_name }}"
                                        aria-label="default input inline 2" required>
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
                                        placeholder="42201-XXXXXXX-X" value="{{ $lead->cnic }}"
                                        aria-label="default input inline 2" required>
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
                                        aria-label="default input inline 1" value="{{ $lead->email }}" required>
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
                                        <option value="male" {{ $lead->gender == 'male' ? 'Selected' : '' }}>Male
                                        </option>
                                        <option value="female" {{ $lead->gender == 'female' ? 'Selected' : '' }}>Female
                                        </option>
                                        <option value="others" {{ $lead->gender == 'other' ? 'Selected' : '' }}>Others
                                        </option>
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
                                        <option value="Email" {{ $lead->lead_source == 'Email' ? 'Selected' : '' }}>Email
                                        </option>
                                        <option value="Google" {{ $lead->lead_source == 'Google' ? 'Selected' : '' }}>
                                            Google
                                        </option>
                                        <option value="Facebook" {{ $lead->lead_source == 'Facebook' ? 'Selected' : '' }}>
                                            Facebook</option>
                                        <option value="Friend" {{ $lead->lead_source == 'Friend' ? 'Selected' : '' }}>
                                            Friend</option>
                                        <option value="Direct Visit"
                                            {{ $lead->lead_source == 'Direct Visit' ? 'Selected' : '' }}>Direct Visit
                                        </option>
                                        <option value="Tv Ad" {{ $lead->lead_source == 'Tv Ad' ? 'Selected' : '' }}>Tv Ad
                                        </option>
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
                                        value="{{ $lead->lead_value }}" aria-label="default input inline 1" required>
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
                                        <option value="yes" {{ $lead->allow_follow_up == 'yes' ? 'Selected' : '' }}>Yes
                                        </option>
                                        <option value="no" {{ $lead->allow_follow_up == 'no' ? 'Selected' : '' }}>No
                                        </option>
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
                                        <option value="initiated" {{ $lead->status == 'initiated' ? 'Selected' : '' }}>
                                            Initiated
                                        </option>
                                        <option value="in process" {{ $lead->status == 'in process' ? 'Selected' : '' }}>
                                            In Process
                                        </option>
                                        <option value="follow up" {{ $lead->status == 'follow up' ? 'Selected' : '' }}>
                                            Follow-up
                                        </option>
                                        <option value="bought" {{ $lead->status == 'bought' ? 'Selected' : '' }}>
                                            Bought</option>
                                        <option value="not interested"
                                            {{ $lead->status == 'not interested' ? 'Selected' : '' }}>Not
                                            Interested</option>
                                        <option value="general inquiry"
                                            {{ $lead->status == 'general inquiry' ? 'Selected' : '' }}>General
                                            Inquiry</option>
                                        <option value="convert to customer"
                                            {{ $lead->status == 'convert to customer' ? 'Selected' : '' }}>Convert To
                                            Customer</option>
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
                                                <option value="{{ $group[$i]->id }}"
                                                    {{ $lead->group_id == $group[$i]->id ? 'Selected' : '' }}>
                                                    {{ $group[$i]->group_name }}

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
                                            <option value="{{ $category[$i]->id }}"
                                                {{ $lead->lead_category_id == $category[$i]->id ? 'Selected' : '' }}>
                                                {{ $category[$i]->category }}
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
                                    <textarea id="validation-form-6" onkeyup="validateAlphabetsAndNUumber(event)" class="form-control"
                                        name="description" placeholder="Enter details about lead" minlength="10" maxlength='255' required>{{ $lead->description }}</textarea>
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
                                        placeholder="Company Name" value="{{ $lead->company_name }}"
                                        aria-label="default input inline 1">
                                </div>
                                <div>
                                    <label for="regular-form-1" class="form-label">Website</label>
                                    <input type="text" class="form-control col-span-4 " name="website"
                                        placeholder="e.g. https://www.example.com" value="{{ $lead->website }}"
                                        aria-label="default input inline 1">
                                </div>
                                <div>
                                    <label for="regular-form-1" class="form-label">Office Phone Number</label>
                                    <input type="text" class="form-control col-span-4 number"
                                        value="{{ $lead->office_phone_number }}" name="office_phone_number"
                                        placeholder="92-XXXXXXXX" aria-label="default input inline 1">
                                </div>
                                <div class="mt-3">
                                    <label for="regular-form-1" class="form-label">State</label>
                                    <input type="text" class="form-control col-span-4 " name="state"
                                        placeholder="State" value="{{ $lead->state }}"
                                        aria-label="default input inline 1">
                                </div>
                                <div class="mt-3">
                                    <label for="regular-form-1" class="form-label">City</label>
                                    <input type="text" class="form-control col-span-4 " name="city"
                                        placeholder="City" value="{{ $lead->city }}"
                                        aria-label="default input inline 1">
                                </div>
                                <div class="mt-3">
                                    <label for="regular-form-1" class="form-label">Postal code</label>
                                    <input type="text" class="form-control col-span-4 " name="postal_code"
                                        placeholder="Postal code" value="{{ $lead->postal_code }}"
                                        aria-label="default input inline 1">
                                </div>
                                <div class="mt-3">
                                    <label for="regular-form-1" class="form-label">Address</label>
                                    <textarea id="validation-form-6" onkeyup="validateAlphabetsAndNUumber(event)" maxlength='255' class="form-control"
                                        name="address" placeholder="Enter Address" minlength="10" maxlength='255'>{{ $lead->address }}</textarea>
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
                            if (result[i].id == "{{ $lead->assigned_to }}") product.defaultSelected =
                                true;
                            document.getElementById('assigned_to').appendChild(product);
                        }
                    }
                });
            }
            getUser();
        </script>
    @endpush
@endsection
