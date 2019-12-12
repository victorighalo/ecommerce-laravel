<div class="card" ng-app="create-properties">
    <div class="card-body" ng-controller="propertiesController">
        <h5 class="card-title mb-4">Variants</h5>
        <div class="table-responsive">
            <table class="table table-hover table-bordered" id="categories-table">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Values</th>
                </tr>
                </thead>
                <tbody>
                <tr ng-repeat="property in properties">
                    <td>
                        @{{property.name}}
{{--                        <div class="row">--}}
{{--                            <div class="col-4 pb-1">--}}
{{--                                @{{property.name}}--}}
{{--                            </div>--}}
{{--                            <div class="col-8 pb-1">--}}
{{--                                <a class="btn dropdown-item delete_property" id=""><i class="fas fa-trash"></i></a>--}}
{{--                                <a class="btn dropdown-item edit_property" id=""><i class="fas fa-edit"></i></a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                    </td>
                    <td>
                        <div class="row justify-content-center">
                    <div class="col-xs-12 col-sm-2" ng-repeat="value in property.values">
                        <span>@{{(value.value)}} </span>
                        <button type="button" class="btn btn-link delete_property_value" id="@{{value.id}}" ng-click="deleteItem(this)"><i class="fas fa-trash"></i></button>
                        <button type="button" class="btn btn-link edit_property_value" id="@{{value.id}}" data-property_id="@{{value.id}}" ng-click="editItem(this)"><i class="fas fa-edit"></i></button>
                    </div>
                        </div>

                            {{--                                                        <div class="col-4 pb-1">--}}
                            {{--                                                                    <a class="btn dropdown-item delete_property_value" id="{{$property_value->id}}"><i class="fas fa-trash"></i></a>--}}
                            {{--                                                                    <a class="btn dropdown-item edit_property_value" id="{{$property_value->id}}" data-property_id="{{$property_value->id}}"><i class="fas fa-edit"></i></a>--}}
                            {{--                                                             </div>--}}

                    </td>

                </tr>
                {{--                @foreach($properties as $property)--}}
                {{--                    <tr>--}}
                {{--                        <td>--}}
                {{--                            <div class="row">--}}
                {{--                                <div class="col-8 pb-1">--}}
                {{--                            {{$property->name}}--}}
                {{--                                </div>--}}
                {{--                                <div class="col-4 pb-1">--}}
                {{--                                    <a class="btn dropdown-item delete_property" id="{{$property->slug}}"><i class="fas fa-trash"></i></a>--}}
                {{--                                    <a class="btn dropdown-item edit_property" id="{{$property->slug}}"><i class="fas fa-edit"></i></a>--}}
                {{--                                </div>--}}
                {{--                            </div>--}}
                {{--                        </td>--}}
                {{--                        <td>--}}
                {{--                            <div class="row">--}}
                {{--                                @foreach($property->values() as $property_value)--}}
                {{--                                    <div class="col-8 pb-1">--}}
                {{--                                        <span>{{ucwords($property_value->value)}}</span>--}}
                {{--                                        <br>--}}
                {{--                                        <br>--}}
                {{--                                        <span>Title - {{ucwords($property_value->title)}} </span>--}}
                {{--                                        <br>--}}
                {{--                                    </div>--}}
                {{--                                    <div class="col-4 pb-1">--}}
                {{--                                                <a class="btn dropdown-item delete_property_value" id="{{$property_value->id}}"><i class="fas fa-trash"></i></a>--}}
                {{--                                                <a class="btn dropdown-item edit_property_value" id="{{$property_value->id}}" data-property_id="{{$property_value->id}}"><i class="fas fa-edit"></i></a>--}}
                {{--                                         </div>--}}
                {{--                                @endforeach--}}
                {{--                            </div>--}}
                {{--                        </td>--}}

                {{--                    </tr>--}}
                {{--                @endforeach--}}
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('script')

@endpush
