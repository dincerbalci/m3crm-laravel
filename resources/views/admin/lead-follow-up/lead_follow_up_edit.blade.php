<form method="POST" action="{{ route('lead_follow_up.update', $leadFollowUp->id) }}" style="margin-bottom: 47px;">
    @method('PUT')
    @csrf
    <div class="col-span-2 sm:col-span-2">
        <div class="mt-3">
            <label for="regular-form-1" class="form-label">Follow-up Date<span style="color: red">*</span></label>
            <input type="datetime-local" class="form-control col-span-4" name="next_follow_up"
                placeholder="Follow-up Date" value="{{ date('Y-m-d H:i:s', strtotime($leadFollowUp->next_follow_up)) }}"
                aria-label="default input inline 2" required>
        </div>
    </div>
    <div class="col-span-2 sm:col-span-2">
        <div class="mt-3">
            <label for="regular-form-1" class="form-label">Remark<span style="color: red">*</span></label>
            <textarea id="validation-form-6" onkeyup="validateAlphabetsAndNUumber(event)" class="form-control" name="remark"
                placeholder="Enter details about lead" minlength="10" maxlength='255' required>{{ $leadFollowUp->remark }}</textarea>
        </div>
    </div>
    <div class="mt-3 mr-5 absolute bottom-10 right-0">
        <button type="submit" class="btn btn-primary w-20">Update</button>
        <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
    </div>
</form>
