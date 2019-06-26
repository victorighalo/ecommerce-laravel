<div class="modal" tabindex="-1" role="dialog" id="edit_password_modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Change Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="update_user_password">
                    @csrf
                    <input type="hidden" name="user_id">
                    <div class="row form-group">
                        <div class="col-sm-12">
                            <label for="firstname">Password</label>
                            <div class="input-group mb-3">
                            <input type="password" id="password" class="form-control" name="password" required>
                            <span class="invalid-feedback errorshow" role="alert">
                                                </span>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" id="toggle_password">Show password</button>
                                </div>
                        </div>
                        </div>
                    </div>

                    <div class="mt-5 pb-5">
                        <button class="btn float-right btn-lg btn-primary font-weight-medium updateformbtn" type="submit">
                            <i class="fas fa-spinner fa-spin off process_indicator"></i>
                            <span>{{ __('Update') }}</span>
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>