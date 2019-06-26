<div class="row justify-content-center flex-grow mb-5 mt-1">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">  Create User
                    <a class="btn btn-link float-right" data-toggle="collapse" href="#form_collapse" role="button" aria-expanded="false" aria-controls="collapseExample">
                        <i class="fas fa-ellipsis-v"></i>
                    </a></h5>
                <div class="collapse" id="form_collapse">
                    <div class="row">
                        <div class="col-sm-12 p-4">
                            <form id="user_form">
                                @csrf
                                <div class="row form-group">
                                    <div class="col-sm-3">
                                        <label for="firstname">Firstname</label>
                                        <input type="text" id="firstname" class="form-control" name="firstname" required>
                                        <span class="invalid-feedback errorshow" role="alert">
                                                </span>
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="lastname">Lastname</label>
                                        <input type="text" id="lastname" class="form-control" name="lastname" required>
                                        <span class="invalid-feedback errorshow" role="alert">
                                                </span>
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="email">Email</label>
                                        <input type="email" id="email" class="form-control" name="email" required>
                                        <span class="invalid-feedback errorshow" role="alert">
                                                </span>
                                    </div>
                                    <div class="col-sm-2">
                                        <label for="role">Role</label>
                                        <select class="form-control" name="role" id="role">
                                            @foreach($roles as $role)
                                                <option value="{{$role->name}}">{{$role->name}}</option>
                                            @endforeach
                                        </select>
                                        <span class="invalid-feedback errorshow" role="alert">
                                                    </span>
                                    </div>

                                </div>

                                <div class="row form-group">
                                    <div class="col-sm-4">
                                        <label for="password">Password</label>
                                        <input type="password" id="password" class="form-control" name="password" required>
                                        <span class="invalid-feedback errorshow" role="alert">
                                                </span>
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="password_confirmation">Confirm Password</label>
                                        <input type="password" id="password_confirmation" class="form-control" name="password_confirmation" required>
                                        <span class="invalid-feedback errorshow" role="alert">
                                                </span>
                                    </div>

                                </div>


                                <div class="mt-1">
                                    <button class="btn float-right btn-primary btn-lg font-weight-medium add_user_btn" type="submit">
                                        <i class="fas fa-spinner fa-spin off process_indicator"></i>
                                        <span><i class="fas fa-save"></i> {{ __('Save') }}</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
