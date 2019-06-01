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
                                        <div class="btn-group">
                                            <button class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span>{{ucwords($property_value->value)}} {{ucwords($property_value->title)}} </span>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="btn dropdown-item delete_property_value" id="{{$property_value->id}}"><i class="fas fa-trash"></i> Delete</a>
                                                <a class="btn dropdown-item edit_property_value" id="{{$property_value->id}}" data-property_id="{{$property_value->id}}"><i class="fas fa-edit"></i> Edit</a>

                                            </div>
                                        </div>
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
