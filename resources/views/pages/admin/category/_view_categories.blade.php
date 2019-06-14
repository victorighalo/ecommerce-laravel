<input type="file" placeholder="Upload image" style="visibility: hidden;" class="upload_cat_image" >
    <div class="card">
        <div class="card-body">
            <h5 class="card-title mb-4">Categories</h5>
            <div class="table-responsive">
                <table class="table table-hover " id="categories-table">
                    <thead>
                    <tr>
                        <th>Category</th>

                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <td>
                                <section class="p-2 mb-3">
                                <strong>{{$category->name}}</strong>
                                    <img src="{{asset('thumbnail/'.$category->image)}}" alt="" style="width: 80px;">
                                </section>
                                <section>
                                    <div class="row">
                                        @foreach($category->rootLevelTaxons() as $subcategory)
                                            <div class="col-sm-12 pb-1">
                                                <div class="btn-group">
                                                    <button class="btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <span>{{ucwords($subcategory->name)}} </span>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="btn btn-sm dropdown-item delete_subcategory" id="{{$subcategory['id']}}"><i class="fas fa-trash"></i> Delete</a>
                                                        <a class="btn btn-sm dropdown-item edit_subcategory" id="{{$subcategory['id']}}" data-category_id="{{$category->taxonomy_id}}"><i class="fas fa-edit"></i> Edit</a>
                                                        <div class="dropdown-divider"></div>
                                                        <a
                                                                class="btn btn-sm dropdown-item add_child_category"
                                                                data-taxonomy_id="{{$category->id}}"
                                                                data-taxon_id="{{$subcategory->id}}"
                                                                data-taxonomy_name="{{ucwords($category->name)}}"
                                                                data-taxon_name="{{ucwords($subcategory->name)}}"
                                                        ><i class="fas fa-plus"></i> Add child-category </a>
                                                    </div>
                                                </div>
                                            </div>
                                            @if($subcategory->children)
                                                <div class="col-12 pb-3">
                                                    @foreach($subcategory->children as $child_category)
                                                        <div class="btn-group">
                                                            <button class="btn-xs btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                {{$child_category->name}}</button>
                                                            <div class="dropdown-menu">
                                                                <a class="btn btn-sm dropdown-item delete_subcategory" id="{{$child_category->id}}"><i class="fas fa-trash"></i> Delete</a>
                                                                <a class="btn btn-sm dropdown-item edit_subcategory" id="{{$child_category->id}}" data-category_id="{{$category->id}}"><i class="fas fa-edit"></i> Edit</a>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </section>
                            </td>

                            <td>
                                <a class="btn btn-sm btn-link delete_category" id="{{$category->id}}"><i class="fas fa-trash"></i></a>
                                <a class="btn btn-sm btn-link edit_category" id="{{$category->id}}"><i class="fas fa-edit"></i></a>
                                <a class="btn btn-sm btn-link edit_subcategory_image" id="{{$category->id}}" ><i class="fas fa-image" aria-hidden="true"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

