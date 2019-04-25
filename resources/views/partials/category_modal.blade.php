<div class="modal" id="child_category_modal" tabindex="-1" role="dialog" aria-labelledby="child_category_modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <small id="child_category_modal">Add a child category </small>
                <h5 id="parent_category_details"></h5>
            </div>

            <div class="modal-body">
                <input type="text" id="child_category_input" class="form-control" name="child_category_input" required placeholder="Enter name here">
                <span class="invalid-feedback errorshow" role="alert">
                </span>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-dialog" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-dialog" id="save_child_category"> <i class="fas fa-spinner fa-spin off process_indicator"></i> Save</button>
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div>