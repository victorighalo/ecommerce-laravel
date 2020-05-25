
                    @foreach($categories as $category)
                                <section>
                                    <div class="font-weight-bold shadow-sm bg-gray-400 p-3 m-2 rounded">
                                    <span class="pr-2 edit_category" id="{{$category->id}}">{{$category->name}}</span>
                                        <span class="delete_category pr-2" id="{{$category->id}}"><i class="fas fa-trash"></i></span>
{{--                                        <span class="edit_category pr-2" id="{{$category->id}}"><i class="fas fa-edit"></i></span>--}}
                                        <span class="edit_category_image pr-2" id="{{$category->id}}" ><i class="fas fa-image" aria-hidden="true"></i></span>
                                    </div>
                                    <img src="{{asset('thumbnail/'.$category->image)}}" alt="" style="width: 80px;padding: 10px">
                                </section>
                                <section>
                                    <div class="row">
                                        @foreach($category->rootLevelTaxons() as $subcategory)
                                            <div class="col-12 pb-3">
                                            <div class="font-weight-bold shadow-sm bg-gray-300 p-2 m-2 rounded">
                                                <span class="edit_subcategory pr-2" id="{{$subcategory->id}}" data-category_id="{{$category->id}}">{{ucwords($subcategory->name)}} </span>
                                                <span class="delete_subcategory pr-2" id="{{$subcategory->id}}"><i class="fas fa-trash"></i></span>
                                                <span class="add_child_category"
                                                      data-taxonomy_id="{{$category->id}}"
                                                      data-taxon_id="{{$subcategory->id}}"
                                                      data-taxonomy_name="{{ucwords($category->name)}}"
                                                      data-taxon_name="{{ucwords($subcategory->name)}}"
                                                      id="{{$subcategory->id}}"><i class="fas fa-plus"></i></span>
                                            </div>
                                            </div>
{{--                                            <div class="col-sm-12 pb-1">--}}
{{--                                                <div class="btn-group">--}}
{{--                                                    <button class="btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
{{--                                                        <span>{{ucwords($subcategory->name)}} </span>--}}
{{--                                                    </button>--}}
{{--                                                    <div class="dropdown-menu">--}}
{{--                                                        <a class="btn btn-sm dropdown-item delete_subcategory" id="{{$subcategory->id}}"><i class="fas fa-trash"></i> Delete</a>--}}
{{--                                                        <a class="btn btn-sm dropdown-item edit_subcategory" id="{{$subcategory->id}}" data-category_id="{{$category->id}}"><i class="fas fa-edit"></i> Edit</a>--}}
{{--                                                        <div class="dropdown-divider"></div>--}}
{{--                                                        <a--}}
{{--                                                                class="btn btn-sm dropdown-item add_child_category"--}}
{{--                                                                data-taxonomy_id="{{$category->id}}"--}}
{{--                                                                data-taxon_id="{{$subcategory->id}}"--}}
{{--                                                                data-taxonomy_name="{{ucwords($category->name)}}"--}}
{{--                                                                data-taxon_name="{{ucwords($subcategory->name)}}"--}}
{{--                                                        ><i class="fas fa-plus"></i> Add child-category </a>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
                                            @if($subcategory->children)
                                                <div class="col-12 pb-3">
                                                    @foreach($subcategory->children as $child_category)
                                                        <div class="d-inline-block font-weight-bold shadow-sm bg-gray-200 p-2 m-2 rounded">
                                                            <span class="edit_subcategory pr-2" id="{{$child_category->id}}" data-category_id="{{$category->id}}">{{$child_category->name}}</span>
                                                            <span class="delete_subcategory pr-2" id="{{$child_category->id}}"><i class="fas fa-trash"></i></span>
                                                        </div>
{{--                                                        <div class="btn-group">--}}
{{--                                                            <button class="btn-xs btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
{{--                                                                {{$child_category->name}}</button>--}}
{{--                                                            <div class="dropdown-menu">--}}
{{--                                                                <a class="btn btn-sm dropdown-item delete_subcategory" id="{{$child_category->id}}"><i class="fas fa-trash"></i> Delete</a>--}}
{{--                                                                <a class="btn btn-sm dropdown-item edit_subcategory" id="{{$child_category->id}}" data-category_id="{{$category->id}}"><i class="fas fa-edit"></i> Edit</a>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
                                                    @endforeach
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </section>
                    @endforeach
            <input type="file" placeholder="Upload image" style="visibility: hidden;" class="upload_cat_image" >


