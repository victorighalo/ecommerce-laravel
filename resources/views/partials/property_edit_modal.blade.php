<div class="modal" id="property_edit_modal" tabindex="-1" role="dialog" aria-labelledby="property_edit_modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Update product properties </h4>
                <h5 id="product_name"></h5>
            </div>

            <div class="modal-body">
                <div class="col-sm-12 edit_property_values">
                    <div><label for="">{{ __('Properties') }}</label></div>
                    @foreach($properties as $property)
                        <div class="form-group">
                        <label for="">{{$property->name}}</label>
                            <select name="product_property" id="{{$property->id}}" class="form-control">
                                <option value="null">None</option>
                                @foreach($property->values() as $value)
                                    <option value="{{$value->id}}">{{$value->value}} {{$value->title}}</option>
                                @endforeach
                            </select>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-dialog" data-dismiss="modal" id="cancel_update_property_btn">Cancel</button>
                <button type="button" class="btn btn-dialog" id="update_property_btn"> <i class="fas fa-spinner fa-spin off process_indicator"></i> Save</button>
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div>