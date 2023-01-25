<form method="POST" action="{{ route('lead_note.store') }}" style="margin-bottom: 47px;">
    @csrf
    <input hidden name="lead_id" value="{{ $leadId }}" />
    <div class="col-span-2 sm:col-span-2">
        <div>
            <label for="regular-form-1" class="form-label">Note Title <span style="color: red">*</span></label>
            <input type="text" class="form-control col-span-4" name="note_title" placeholder="Enter Note Title"
                aria-label="default input inline 2" required>
            @error('note_title')
                <span class="text-danger" role="alert">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-span-2 sm:col-span-2">
        <div class="mt-3">
            <label for="regular-form-1" class="form-label">Description<span style="color: red">*</span></label>
            <textarea id="validation-form-6" onkeyup="validateAlphabetsAndNUumber(event)" class="form-control"
                name="note_description" placeholder="Enter details about lead" minlength="10" maxlength='255' required></textarea>
            @error('note_description')
                <span class="text-danger" role="alert">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="mt-3 mr-5 absolute bottom-10 right-0">
        <button type="submit" class="btn btn-primary w-20">Add</button>
        <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
    </div>
</form>
