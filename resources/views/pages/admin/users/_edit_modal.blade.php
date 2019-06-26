<div class="modal" tabindex="-1" role="dialog" id="edit_modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="loader_container">
                <img src="{{asset('assets/images/loader.gif')}}" alt="">
                </div>
                <form id="update_user">
                    @csrf
                    <input type="hidden" name="user_id">
                    <div class="row form-group">
                        <div class="col-sm-12">
                            <label for="firstname">Firstname</label>
                            <input type="text" id="firstname" class="form-control" name="firstname" required>
                            <span class="invalid-feedback errorshow" role="alert">
                                                </span>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-sm-12">
                            <label for="lastname">Lastname</label>
                            <input type="text" id="lastname" class="form-control" name="lastname" required>
                            <span class="invalid-feedback errorshow" role="alert">
                                                </span>
                        </div>
                    </div>


                    <div class="row form-group">
                        <div class="col-sm-12">
                            <label for="role">Role</label>
                            <select class="form-control" name="role" id="role">
                            </select>
                            <span class="invalid-feedback errorshow" role="alert">
                                                    </span>
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