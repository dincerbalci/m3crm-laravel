@extends('layouts.main')

@section('content')
    <style>
        .grid-cols-12 {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    </style>
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Lead Detail
        </h2>
        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
            <a href="{{ route('lead.create') }}" class="btn btn-primary shadow-md mr-2">Add New Lead</a>
            <div class="dropdown ml-auto sm:ml-0">
                <button class="dropdown-toggle btn px-2 box" aria-expanded="false" data-tw-toggle="dropdown">
                    <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4" data-lucide="plus"></i>
                    </span>
                </button>
                <div class="dropdown-menu w-40">
                    <ul class="dropdown-content">
                        <li>
                            <a href="javascript:;" onclick="leadNoteAdd({{ $lead->id }})" class="dropdown-item"> <i
                                    data-lucide="file-text" class="w-4 h-4 mr-2"></i>
                                Add Note</a>
                        </li>
                        @if ($lead->allow_follow_up == 'yes')
                            <li>
                                <a href="javascript:;" onclick="leadFollowUpAdd({{ $lead->id }})"
                                    class="dropdown-item"><i data-lucide="git-pull-request" class="w-4 h-4 mr-2"></i>Add
                                    Follow-up</a>
                            </li>
                        @endif
                        <li>
                            <a href="javascript:;" onclick="leadFileAdd({{ $lead->id }})" class="dropdown-item"><i
                                    data-lucide="file-plus" class="w-4 h-4 mr-2"></i>Add File</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 lg:col-span-6" id="SearchForm">
            <div class="intro-y col-span-12 lg:col-span-12">
                <!-- BEGIN: Input -->
                <div class="intro-y box mt-5">
                    <div
                        class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                        <ul class="nav nav-boxed-tabs" role="tablist">
                            <li class="nav-item flex-1 " role="presentation">
                                <button id="leadInfo-button" class="nav-link w-full py-2 " onclick="setCookies('leadInfo')"
                                    data-tw-toggle="pill" data-tw-target="#leadInfo-tab" type="button" role="tab"
                                    aria-controls="leadInfo-tab" aria-selected="true">Lead
                                    Info</button>
                            </li>
                            <li class="nav-item flex-1" role="presentation">
                                <button id="leadNote-button" class="nav-link w-full py-2 " onclick="setCookies('leadNote')"
                                    data-tw-toggle="pill" data-tw-target="#leadNote-tab" type="button" role="tab"
                                    aria-controls="leadNote-tab" aria-selected="false">Lead
                                    Note</button>
                            </li>
                            <li class="nav-item flex-1 " role="presentation">
                                <button id="leadFile-button" class="nav-link w-full py-2 " data-tw-toggle="pill"
                                    onclick="setCookies('leadFile')" data-tw-target="#leadFile-tab" type="button"
                                    role="tab" aria-controls="leadFile-tab" aria-selected="false">Lead
                                    Files</button>
                            </li>
                            @if ($lead->allow_follow_up == 'yes')
                                <li class="nav-item flex-1 " role="presentation">
                                    <button id="leadFollowUp-button" class="nav-link w-full py-2 " data-tw-toggle="pill"
                                        onclick="setCookies('leadFollowUp')" data-tw-target="#leadFollowUp-tab"
                                        type="button" role="tab" aria-controls="leadFollowUp-tab"
                                        aria-selected="false">Lead
                                        Follow-up</button>
                                </li>
                            @endif
                        </ul>
                    </div>
                    <div id="boxed-tab" class="p-1">
                        <div class="preview">
                            <div class="tab-content">
                                <div id="leadInfo-tab" class="tab-pane leading-relaxed " role="tabpanel"
                                    aria-labelledby="leadInfo-tab" style="">
                                    <div class="overflow-x-auto scrollbar-hidden">
                                        <form id='complaint_form' method="POST"
                                            action="{{ route('lead.update', $lead->id) }}">
                                            @method('PUT')
                                            @csrf
                                            <input hidden name="id" value="{{ $lead->id }}" />
                                            <div class="grid grid-cols-12 gap-6 mt-5">
                                                <div class="intro-y col-span-12 lg:col-span-6">
                                                    <!-- BEGIN: Input -->
                                                    <div class="intro-y ">
                                                        <div id="inline-form" class="p-5">
                                                            <div class="preview">
                                                                <div class="grid grid-cols-12 gap-2">
                                                                    <div>
                                                                        <label for="regular-form-1"
                                                                            class="form-label">Salutation </label>
                                                                        <select
                                                                            data-placeholder="Select your favorite actors"
                                                                            name='salutation'
                                                                            class="tom-select w-full tomselected"
                                                                            id="tomselect-1" tabindex="-1"
                                                                            hidden="hidden" required>
                                                                            <option value="0" selected="true">Select
                                                                                Salutation</option>
                                                                            <option value="Mr"
                                                                                {{ $lead->salutation == 'Mr' ? 'Selected' : '' }}>
                                                                                Mr</option>
                                                                            <option value="Mrs"
                                                                                {{ $lead->salutation == 'Mrs' ? 'Selected' : '' }}>
                                                                                Mrs
                                                                            </option>
                                                                            <option value="Miss"
                                                                                {{ $lead->salutation == 'Miss' ? 'Selected' : '' }}>
                                                                                Miss
                                                                            </option>
                                                                            <option value="Dr"
                                                                                {{ $lead->salutation == 'Dr' ? 'Selected' : '' }}>
                                                                                Dr</option>
                                                                            <option value="Sir"
                                                                                {{ $lead->salutation == 'Sir' ? 'Selected' : '' }}>
                                                                                Sir
                                                                            </option>
                                                                            <option value="Madam"
                                                                                {{ $lead->salutation == 'Madam' ? 'Selected' : '' }}>
                                                                                Madam
                                                                            </option>
                                                                        </select>
                                                                        @error('salutation')
                                                                            <span class="text-danger" role="alert">
                                                                                {{ $message }}
                                                                            </span>
                                                                        @enderror
                                                                    </div>
                                                                    <div>
                                                                        <label for="regular-form-1"
                                                                            class="form-label">Lead
                                                                            Name
                                                                        </label>
                                                                        <input type="text"
                                                                            class="form-control col-span-4"
                                                                            name="lead_name" placeholder="Lead Name"
                                                                            value="{{ $lead->lead_name }}"
                                                                            aria-label="default input inline 2" required>
                                                                        @error('lead_name')
                                                                            <span class="text-danger" role="alert">
                                                                                {{ $message }}
                                                                            </span>
                                                                        @enderror
                                                                    </div>
                                                                    <div>
                                                                        <label for="regular-form-1"
                                                                            class="form-label">CNIC
                                                                        </label>
                                                                        <input type="text" id="cnic"
                                                                            class="form-control col-span-4" name="cnic"
                                                                            placeholder="42201-XXXXXXX-X"
                                                                            value="{{ $lead->cnic }}"
                                                                            aria-label="default input inline 2" required>
                                                                        @error('cnic')
                                                                            <span class="text-danger" role="alert">
                                                                                {{ $message }}
                                                                            </span>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="mt-3">
                                                                        <label for="regular-form-1"
                                                                            class="form-label">Email
                                                                        </label>
                                                                        <input type="email"
                                                                            class="form-control col-span-4" name="email"
                                                                            placeholder="Email"
                                                                            aria-label="default input inline 1"
                                                                            value="{{ $lead->email }}" required>
                                                                        @error('email')
                                                                            <span class="text-danger" role="alert">
                                                                                {{ $message }}
                                                                            </span>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="mt-3">
                                                                        <label for="regular-form-1"
                                                                            class="form-label">Gender
                                                                        </label>
                                                                        <select
                                                                            data-placeholder="Select your favorite actors"
                                                                            name='gender'
                                                                            class="tom-select w-full tomselected"
                                                                            id="tomselect-1" tabindex="-1"
                                                                            hidden="hidden" required>
                                                                            <option value="0" selected="true">Select
                                                                                Gender</option>
                                                                            <option value="male"
                                                                                {{ $lead->gender == 'male' ? 'Selected' : '' }}>
                                                                                Male
                                                                            </option>
                                                                            <option value="female"
                                                                                {{ $lead->gender == 'female' ? 'Selected' : '' }}>
                                                                                Female
                                                                            </option>
                                                                            <option value="others"
                                                                                {{ $lead->gender == 'other' ? 'Selected' : '' }}>
                                                                                Others
                                                                            </option>
                                                                        </select>
                                                                        @error('gender')
                                                                            <span class="text-danger" role="alert">
                                                                                {{ $message }}
                                                                            </span>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="mt-3">
                                                                        <label for="regular-form-1"
                                                                            class="form-label">Lead
                                                                            Source
                                                                        </label>
                                                                        <select
                                                                            data-placeholder="Select your favorite actors"
                                                                            name='lead_source'
                                                                            class="tom-select w-full tomselected"
                                                                            id="tomselect-1" tabindex="-1"
                                                                            hidden="hidden" required>
                                                                            <option value="0" selected="true">Lead
                                                                                Source
                                                                            </option>
                                                                            <option value="Email"
                                                                                {{ $lead->lead_source == 'Email' ? 'Selected' : '' }}>
                                                                                Email
                                                                            </option>
                                                                            <option value="Google"
                                                                                {{ $lead->lead_source == 'Google' ? 'Selected' : '' }}>
                                                                                Google
                                                                            </option>
                                                                            <option value="Facebook"
                                                                                {{ $lead->lead_source == 'Facebook' ? 'Selected' : '' }}>
                                                                                Facebook</option>
                                                                            <option value="Friend"
                                                                                {{ $lead->lead_source == 'Friend' ? 'Selected' : '' }}>
                                                                                Friend</option>
                                                                            <option value="Direct Visit"
                                                                                {{ $lead->lead_source == 'Direct Visit' ? 'Selected' : '' }}>
                                                                                Direct Visit
                                                                            </option>
                                                                            <option value="Tv Ad"
                                                                                {{ $lead->lead_source == 'Tv Ad' ? 'Selected' : '' }}>
                                                                                Tv Ad
                                                                            </option>
                                                                        </select>
                                                                        @error('lead_source')
                                                                            <span class="text-danger" role="alert">
                                                                                {{ $message }}
                                                                            </span>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="mt-3">
                                                                        <label for="regular-form-1"
                                                                            class="form-label">Lead
                                                                            Value</label>
                                                                        <input type="text"
                                                                            class="form-control col-span-4"
                                                                            name="lead_value" placeholder="Lead Value"
                                                                            onkeypress="return validateNumbers(event)"
                                                                            value="{{ $lead->lead_value }}"
                                                                            aria-label="default input inline 1" required>
                                                                        @error('lead_value')
                                                                            <span class="text-danger" role="alert">
                                                                                {{ $message }}
                                                                            </span>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="mt-3">
                                                                        <label for="regular-form-1"
                                                                            class="form-label">Allow
                                                                            Follow Up </label>
                                                                        <select
                                                                            data-placeholder="Select your favorite actors"
                                                                            name='allow_follow_up'
                                                                            class="tom-select w-full tomselected"
                                                                            id="tomselect-1" tabindex="-1"
                                                                            hidden="hidden" required>
                                                                            <option value="0" selected="true">Select
                                                                                Follow up</option>
                                                                            <option value="yes"
                                                                                {{ $lead->allow_follow_up == 'yes' ? 'Selected' : '' }}>
                                                                                Yes
                                                                            </option>
                                                                            <option value="no"
                                                                                {{ $lead->allow_follow_up == 'no' ? 'Selected' : '' }}>
                                                                                No
                                                                            </option>
                                                                        </select>
                                                                        @error('allow_follow_up')
                                                                            <span class="text-danger" role="alert">
                                                                                {{ $message }}
                                                                            </span>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="mt-3">
                                                                        <label for="regular-form-1"
                                                                            class="form-label">Status
                                                                        </label>
                                                                        <select
                                                                            data-placeholder="Select your favorite actors"
                                                                            name='status'
                                                                            class="tom-select w-full tomselected"
                                                                            id="tomselect-1" tabindex="-1"
                                                                            hidden="hidden" required>
                                                                            <option value="0" selected="true">Select
                                                                                Status</option>
                                                                            <option value="initiated"
                                                                                {{ $lead->status == 'initiated' ? 'Selected' : '' }}>
                                                                                Initiated
                                                                            </option>
                                                                            <option value="in process"
                                                                                {{ $lead->status == 'in process' ? 'Selected' : '' }}>
                                                                                In Process
                                                                            </option>
                                                                            <option value="follow up"
                                                                                {{ $lead->status == 'follow up' ? 'Selected' : '' }}>
                                                                                Follow-up
                                                                            </option>
                                                                            <option value="bought"
                                                                                {{ $lead->status == 'bought' ? 'Selected' : '' }}>
                                                                                Bought</option>
                                                                            <option value="not interested"
                                                                                {{ $lead->status == 'not interested' ? 'Selected' : '' }}>
                                                                                Not
                                                                                Interested</option>
                                                                            <option value="general inquiry"
                                                                                {{ $lead->status == 'general inquiry' ? 'Selected' : '' }}>
                                                                                General
                                                                                Inquiry</option>
                                                                            <option value="convert to customer"
                                                                                {{ $lead->status == 'convert to customer' ? 'Selected' : '' }}>
                                                                                Convert To Customer</option>
                                                                        </select>
                                                                        @error('status')
                                                                            <span class="text-danger" role="alert">
                                                                                {{ $message }}
                                                                            </span>
                                                                        @enderror
                                                                    </div>
                                                                    @if ($userType == '1')
                                                                        <div class="mt-3">
                                                                            <label for="regular-form-1"
                                                                                class="form-label">Group<span
                                                                                    style="color: red">*</span></label>
                                                                            <select
                                                                                data-placeholder="Select your favorite actors"
                                                                                id="group_id" name='group_id'
                                                                                class="tom-select w-full tomselected"
                                                                                id="tomselect-1" tabindex="-1"
                                                                                hidden="hidden" required
                                                                                onchange="getUser()">
                                                                                <option value="0" selected="true">
                                                                                    Select Group
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
                                                                            <label for="regular-form-1"
                                                                                class="form-label">Assigned to<span
                                                                                    style="color: red">*</span></label>
                                                                            <select
                                                                                data-placeholder="Select your favorite actors"
                                                                                id="assigned_to" name='assigned_to'
                                                                                class="form-select" id="tomselect-1"
                                                                                required>
                                                                                <option value="0" selected="true">
                                                                                    Select Assigned to</option>
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
                                                                        <label for="regular-form-1"
                                                                            class="form-label">Lead
                                                                            Category</label>
                                                                        <select
                                                                            data-placeholder="Select your favorite actors"
                                                                            name='lead_category'
                                                                            class="tom-select w-full tomselected"
                                                                            id="tomselect-1" tabindex="-1"
                                                                            hidden="hidden" required>
                                                                            <option value="0" selected="true">Select
                                                                                Lead
                                                                                Category</option>
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
                                                                        <label for="regular-form-1"
                                                                            class="form-label">Description</label>
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
                                                    <div class="intro-y ">
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
                                                                        <label for="regular-form-1"
                                                                            class="form-label">Company
                                                                            Name</label>
                                                                        <input type="text"
                                                                            class="form-control col-span-4 "
                                                                            name="company_name" placeholder="Company Name"
                                                                            value="{{ $lead->company_name }}"
                                                                            aria-label="default input inline 1">
                                                                    </div>
                                                                    <div>
                                                                        <label for="regular-form-1"
                                                                            class="form-label">Website</label>
                                                                        <input type="text"
                                                                            class="form-control col-span-4 "
                                                                            name="website"
                                                                            placeholder="e.g. https://www.example.com"
                                                                            value="{{ $lead->website }}"
                                                                            aria-label="default input inline 1">
                                                                    </div>
                                                                    <div>
                                                                        <label for="regular-form-1"
                                                                            class="form-label">Office
                                                                            Phone Number</label>
                                                                        <input type="text"
                                                                            class="form-control col-span-4 number"
                                                                            value="{{ $lead->office_phone_number }}"
                                                                            name="office_phone_number"
                                                                            placeholder="92-XXXXXXXX"
                                                                            aria-label="default input inline 1">
                                                                    </div>
                                                                    <div class="mt-3">
                                                                        <label for="regular-form-1"
                                                                            class="form-label">State</label>
                                                                        <input type="text"
                                                                            class="form-control col-span-4 "
                                                                            name="state" placeholder="State"
                                                                            value="{{ $lead->state }}"
                                                                            aria-label="default input inline 1">
                                                                    </div>
                                                                    <div class="mt-3">
                                                                        <label for="regular-form-1"
                                                                            class="form-label">City</label>
                                                                        <input type="text"
                                                                            class="form-control col-span-4 "
                                                                            name="city" placeholder="City"
                                                                            value="{{ $lead->city }}"
                                                                            aria-label="default input inline 1">
                                                                    </div>
                                                                    <div class="mt-3">
                                                                        <label for="regular-form-1"
                                                                            class="form-label">Postal
                                                                            code</label>
                                                                        <input type="text"
                                                                            class="form-control col-span-4 "
                                                                            name="postal_code" placeholder="Postal code"
                                                                            value="{{ $lead->postal_code }}"
                                                                            aria-label="default input inline 1">
                                                                    </div>
                                                                    <div class="mt-3">
                                                                        <label for="regular-form-1"
                                                                            class="form-label">Address</label>
                                                                        <textarea id="validation-form-6" onkeyup="validateAlphabetsAndNUumber(event)" maxlength='255' class="form-control"
                                                                            name="address" placeholder="Enter Address" minlength="10" maxlength='255'>{{ $lead->address }}</textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <button type="submit"
                                                                class="btn btn-primary mt-5">Save</button>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div id="leadNote-tab" class="tab-pane leading-relaxed " role="tabpanel"
                                    aria-labelledby="leadNote-tab" style="">
                                    <div class="overflow-x-auto scrollbar-hidden">
                                        <div class="intro-y overflow-auto lg:overflow-visible mt-8 sm:mt-0">
                                            <table class="table table-report sm:mt-2">
                                                <thead>
                                                    <tr>
                                                        <th class="whitespace-nowrap">Note Title</th>
                                                        <th class="whitespace-nowrap">Note Description</th>
                                                        <th class="text-center">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="table_data">
                                                    @for ($i = 0; $i < count($leadNote); $i++)
                                                        <tr class="intro-x">
                                                            <td class="text-left">{{ $leadNote[$i]->note_title }}</td>
                                                            <td class="text-left">{{ $leadNote[$i]->note_description }}
                                                            </td>
                                                            <td class="text-left">
                                                                <div class="flex justify-center items-center">
                                                                    <a href="javascript:;" class="flex items-center mr-3"
                                                                        onclick="leadNoteEdit('{{ $leadNote[$i]->id }}')">
                                                                        <i data-lucide="check-square"
                                                                            class="w-4 h-4 mr-1"></i> Edit </a>
                                                                    <a class="flex items-center text-danger"
                                                                        href="javascript:;"
                                                                        onclick="leadNoteDelete('{{ $leadNote[$i]->id }}')">
                                                                        <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i>
                                                                        Delete </a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endfor

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div id="leadFile-tab" class="tab-pane leading-relaxed " role="tabpanel"
                                    aria-labelledby="leadFile-tab" style="">
                                    <div class="col-span-12 lg:col-span-9 2xl:col-span-10">
                                        <!-- BEGIN: File Manager Filter -->
                                        <div class="intro-y flex flex-col-reverse sm:flex-row items-center">
                                            @for ($i = 0; $i < count($leadFile); $i++)
                                                <div
                                                    class="intro-y col-span-6 sm:col-span-4 px-5 pt-5 pb-5 px-3 md:col-span-3 2xl:col-span-2">
                                                    <div
                                                        class="file box rounded-md px-5 pt-8 pb-5 px-3 sm:px-5 relative zoom-in">

                                                        <a href="{{ asset($leadFile[$i]->path) }}"
                                                            style="width: 82px !important;" target="_blank"
                                                            class="w-5/5 file__icon file__icon--file mx-auto"
                                                            download="">
                                                            <div class="file__icon__file-name">{{ $leadFile[$i]->ext }}
                                                            </div>
                                                        </a>
                                                        <a href="javascript:;"
                                                            class="block font-medium mt-4 text-center truncate">{{ $leadFile[$i]->file_name }}</a>
                                                        <div class="text-slate-500 text-xs text-center mt-0.5">
                                                            {{ $leadFile[$i]->size }}</div>
                                                        <div class="absolute top-0 right-0 mr-2 mt-3 dropdown ml-auto">
                                                            <a class="dropdown-toggle w-5 h-5 block" href="javascript:;"
                                                                aria-expanded="false" data-tw-toggle="dropdown"> <i
                                                                    data-lucide="more-vertical"
                                                                    class="w-5 h-5 text-slate-500"></i>
                                                            </a>
                                                            <div class="dropdown-menu w-40">
                                                                <ul class="dropdown-content">
                                                                    <li>
                                                                        <a href="javascript:;"
                                                                            onclick="leadFileEdit({{ $leadFile[$i]->id }})"
                                                                            class="dropdown-item"> <i
                                                                                data-lucide="check-square"
                                                                                class="w-4 h-4 mr-1"></i>
                                                                            Edit </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="javascript:;"
                                                                            onclick="leadFileDelete({{ $leadFile[$i]->id }})"
                                                                            class="dropdown-item"> <i data-lucide="trash"
                                                                                class="w-4 h-4 mr-2"></i>
                                                                            Delete
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                                @if ($lead->allow_follow_up == 'yes')
                                    <div id="leadFollowUp-tab" class="tab-pane leading-relaxed " role="tabpanel"
                                        aria-labelledby="leadFollowUp-tab" style="">
                                        <div class="overflow-x-auto scrollbar-hidden">
                                            <div class="intro-y overflow-auto lg:overflow-visible mt-8 sm:mt-0">
                                                <table class="table table-report sm:mt-2">
                                                    <thead>
                                                        <tr>
                                                            <th class="whitespace-nowrap">Next Follow Up</th>
                                                            <th class="whitespace-nowrap">Remarks</th>
                                                            <th class="text-center">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="table_data">
                                                        @for ($i = 0; $i < count($leadFollowUp); $i++)
                                                            <tr class="intro-x">
                                                                <td class="text-left">
                                                                    {{ $leadFollowUp[$i]->next_follow_up }}
                                                                </td>
                                                                <td class="text-left">
                                                                    {{ $leadFollowUp[$i]->remark }}
                                                                </td>
                                                                <td class="text-left">
                                                                    <div class="flex justify-center items-center">
                                                                        <a href="javascript:;"
                                                                            class="flex items-center mr-3"
                                                                            onclick="leadFollowUpEdit('{{ $leadFollowUp[$i]->id }}')">
                                                                            <i data-lucide="check-square"
                                                                                class="w-4 h-4 mr-1"></i> Edit </a>
                                                                        <a class="flex items-center text-danger"
                                                                            href="javascript:;"
                                                                            onclick="leadFollowUpDelete('{{ $leadFollowUp[$i]->id }}')">
                                                                            <i data-lucide="trash-2"
                                                                                class="w-4 h-4 mr-1"></i>
                                                                            Delete </a>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endfor

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            function leadFollowUpAdd(id) {
                value = {
                    id: id
                };
                jQuery.ajax({
                    type: 'GET',
                    url: "{{ route('lead_follow_up.create') }}",
                    data: value,
                    success: function(result) {
                        $('#myModalLgHeading').html('Create Follow-up');
                        $('#modalBodyLarge').html(result);
                        tailwind.Modal.getInstance(document.querySelector("#header-footer-modal-preview")).show();
                        runaaa();
                    }
                });
            }

            function runaaa() {
                var today = new Date().toISOString().slice(0, 16);
                document.getElementsByName("next_follow_up")[0].min = today;
            }

            function leadFollowUpEdit(id) {
                url = "{{ route('lead_follow_up.edit', ':id') }}";
                url = url.replace(':id', id);
                jQuery.ajax({
                    type: 'GET',
                    url: url,
                    success: function(result) {
                        $('#myModalLgHeading').html('Edit Follow-up');
                        $('#modalBodyLarge').html(result);
                        tailwind.Modal.getInstance(document.querySelector("#header-footer-modal-preview")).show();
                    }
                });
            }

            function leadFollowUpDelete(id) {
                value = {
                    id: id
                };
                jQuery.ajax({
                    type: 'GET',
                    url: "{{ route('lead_follow_up_delete') }}",
                    data: value,
                    success: function(result) {
                        $('#myModalLgHeading').html('Delete Follow-up');
                        $('#modalBodyLarge').html(result);
                        tailwind.Modal.getInstance(document.querySelector("#header-footer-modal-preview")).show();
                    }
                });
            }

            function leadNoteAdd(id) {
                value = {
                    id: id
                };
                jQuery.ajax({
                    type: 'GET',
                    url: "{{ route('lead_note.create') }}",
                    data: value,
                    success: function(result) {
                        $('#myModalLgHeading').html('Create Note');
                        $('#modalBodyLarge').html(result);
                        tailwind.Modal.getInstance(document.querySelector("#header-footer-modal-preview")).show();
                    }
                });
            }

            function leadNoteEdit(id) {
                url = "{{ route('lead_note.edit', ':id') }}";
                url = url.replace(':id', id);
                jQuery.ajax({
                    type: 'GET',
                    url: url,
                    success: function(result) {
                        $('#myModalLgHeading').html('Edit Note');
                        $('#modalBodyLarge').html(result);
                        tailwind.Modal.getInstance(document.querySelector("#header-footer-modal-preview")).show();
                    }
                });
            }

            function leadNoteDelete(id) {
                value = {
                    id: id
                };
                jQuery.ajax({
                    type: 'GET',
                    url: "{{ route('lead_note_delete') }}",
                    data: value,
                    success: function(result) {
                        $('#myModalLgHeading').html('Delete Note');
                        $('#modalBodyLarge').html(result);
                        tailwind.Modal.getInstance(document.querySelector("#header-footer-modal-preview")).show();
                    }
                });
            }

            function leadFileAdd(id) {
                value = {
                    id: id
                };
                jQuery.ajax({
                    type: 'GET',
                    url: "{{ route('lead_file.create') }}",
                    data: value,
                    success: function(result) {
                        $('#myModalLgHeading').html('Create File');
                        $('#modalBodyLarge').html(result);
                        tailwind.Modal.getInstance(document.querySelector("#header-footer-modal-preview")).show();
                    }
                });
            }

            function leadFileEdit(id) {
                url = "{{ route('lead_file.edit', ':id') }}";
                url = url.replace(':id', id);
                jQuery.ajax({
                    type: 'GET',
                    url: url,
                    success: function(result) {
                        $('#myModalLgHeading').html('Edit Note');
                        $('#modalBodyLarge').html(result);
                        tailwind.Modal.getInstance(document.querySelector("#header-footer-modal-preview")).show();
                    }
                });
            }

            function leadFileDelete(id) {
                value = {
                    id: id
                };
                jQuery.ajax({
                    type: 'GET',
                    url: "{{ route('lead_file_delete') }}",
                    data: value,
                    success: function(result) {
                        $('#myModalLgHeading').html('Delete Note');
                        $('#modalBodyLarge').html(result);
                        tailwind.Modal.getInstance(document.querySelector("#header-footer-modal-preview")).show();
                    }
                });
            }

            function setCookies(buttonId) {
                document.cookie = 'tabIdButton=' + buttonId;
            }
            getCookies();

            function getCookies() {
                let tabName = getCookie('tabIdButton');
                tabName = tabName == '' ? 'leadInfo' : tabName;
                let buttonId = tabName + "-button";
                let tabId = tabName + "-tab";
                $('#' + buttonId).addClass("active");
                $('#' + tabId).addClass("active");
            }

            function getCookie(cookieName) {
                let cookie = {};
                document.cookie.split(';').forEach(function(el) {
                    let [key, value] = el.split('=');
                    cookie[key.trim()] = value;
                })
                return cookie[cookieName];
            }

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
                            if (result[i].id == "{{ $lead->assigned_to }}")
                                product.defaultSelected = true;
                            document.getElementById('assigned_to').appendChild(product);
                        }
                    }
                });
            }
            getUser();
        </script>
    @endpush
@endsection
