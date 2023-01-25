<form method="POST" action="{{ route('lead_file.store') }}" style="margin-bottom: 47px;"enctype="multipart/form-data">
    @csrf
    <input hidden name="lead_id" value="{{ $leadId }}" />
    <div class="col-span-2 sm:col-span-2">
        <div>
            <label for="regular-form-1" class="form-label">Select File<span style="color: red">*</span></label>
            <input type="file" class="form-control col-span-4" multiple name="file[]"
                aria-label="default input inline 2">
        </div>
    </div>
    <div class="mt-3 mr-5 absolute bottom-10 right-0">
        <button type="submit" class="btn btn-primary w-20">Add</button>
        <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
    </div>
</form>
