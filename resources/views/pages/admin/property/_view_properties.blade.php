<div class="card">
    <div class="card-body">
        <h5 class="card-title mb-4">Properties</h5>
        <div class="table-responsive">
            <table class="table table-hover table-bordered" id="categories-table">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Values</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($properties as $property)
                    <tr>
                        <td>
                            {{$property->name}}
                        </td>
                        <td>
                            <div class="row">
                                @foreach($property->values() as $property_value)
                                    <div class="col-12 pb-1">
                                    <span>{{$property_value->value}} {{$property_value->title}} </span>
                                        <a class="btn btn-xs btn-link delete_property_value" id="{{$property_value->id}}"><i class="fas fa-trash"></i></a>
                                        <a class="btn btn-xs btn-link edit_property_value" id="{{$property_value->id}}" data-property_id="{{$property_value->id}}"><i class="fas fa-edit"></i></a>
                                    </div>
                                @endforeach
                            </div>
                        </td>
                        <td>
                            <a class="btn btn-sm btn-link delete_property" id="{{$property->slug}}"><i class="fas fa-trash"></i></a>
                            <a class="btn btn-sm btn-link edit_property" id="{{$property->slug}}"><i class="fas fa-edit"></i></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
