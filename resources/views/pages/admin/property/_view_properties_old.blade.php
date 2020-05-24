<div class="card">
    <div class="card-body">
        <h5 class="card-title mb-4">Properties</h5>
        <div id="product_properties"></div>
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
                        <div class="row">
                            <div class="col-8 pb-1">
                               @{{property.name}}
                            </div>
                            <div class="col-4 d-flex justify-content-around">
                                <a class="btn delete_property" id=""><i class="fas fa-trash"></i></a>
                                <a class="btn edit_property" id=""><i class="fas fa-edit"></i></a>
                            </div>
                        </div>
                    </td>
                    <td>
                                                <div class="row">
                                                        <div class="col-12 pb-1">
                                                            <div ng-repeat="value in property.values" class="d-inline font-weight-bold">
                                                            <span>@{{(value.value)}}</span>
                                                            <span ng-if="value.title.trim()">( @{{(value.title)}} )</span>
                                                                <span>|</span>
                                                            </div>
                                                        </div>
{{--                                                        <div class="col-4 pb-1">--}}
{{--                                                                    <a class="btn dropdown-item delete_property_value" id="{{$property_value->id}}"><i class="fas fa-trash"></i></a>--}}
{{--                                                                    <a class="btn dropdown-item edit_property_value" id="{{$property_value->id}}" data-property_id="{{$property_value->id}}"><i class="fas fa-edit"></i></a>--}}
{{--                                                             </div>--}}
                                                </div>
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
    <script src="{{asset('js/angular.min.js')}}"></script>
    <script src="{{asset('js/angular-resource.min.js')}}"></script>
    <script>
        var app = angular.module('create-properties', ['ngResource']);
        app.controller('propertiesController', function propertiesController($scope, $http) {
            $scope.properties = [];
           var getProperties = function () {
               $http.get('{!! url("office/properties.json") !!}')
                   .then(function (res) {
                       $scope.properties = res.data.data;
                   })
           }
            getProperties()
        });
    </script>
    @endpush
