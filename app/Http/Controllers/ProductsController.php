<?php

namespace App\Http\Controllers;

use App\User;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Taxon;
use Illuminate\Support\Facades\Storage;
use Vanilo\Product\Models\ProductState;
use Vanilo\Properties\Models\Property;
use Yajra\Datatables\Datatables;

class ProductsController extends BaseController
{
    public function __construct()
    {
        $this->middleware(['auth'])->except('addComment', 'addRating');
    }

    public function index()
    {

        $categories = Taxon::all();
        $products = \App\Product::all();
        $properties = Property::all();

        return view('pages.admin.products',
            compact('categories', 'products', 'properties')
        );
    }

    public function create(Request $request)
    {

        try {
            //Parse query-string input
            parse_str($request->form_data, $product_data);

            //Generate SKU
            $sku = strtoupper(substr($product_data['name'], 0, 3)) . "-" . $product_data['category_id'];

            //Create Product
            $product = \App\Product::create([
                'name' => $product_data['name'],
                'sku' => $sku,
                'price' => $product_data['price'],
                'meta_description' => $product_data['meta_description'],
                'description' => $request->description,
                'meta_keywords' => $product_data['tags'],
                'state' => ProductState::ACTIVE
            ]);

            //Get Taxon
            $taxon = Taxon::where('id', $product_data['category_id'])->first();
            $taxon = Taxon::findBySlug($taxon->slug);

            $get_product = \App\Product::where('id', $product->id)->first();
            //Add Taxon to product
            $get_product->taxons()->save($taxon);


            //Relate images to product
            foreach ($request['images'] as $image) {
                $product->addMedia($image)
                    ->preservingOriginal()
                    ->toMediaCollection('images');
            }
            return response()->json(['status' => 200, 'message' => 'Product created'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => 'Failed to create product'. $e->getMessage()], 400);
        }

    }

    public function update(Request $request)
    {
        $hasSameTaxon = null;
        try {
            //Parse query-string input
            parse_str($request->form_data, $product_data);

            //Generate SKU
            $sku = strtoupper(substr($product_data['name'], 0, 3)) . "-" . $product_data['category_id'];

            //Get Product
            $product = \App\Product::where('id', $product_data['id']);

            //Get Selected Taxon
            $getTaxon = Taxon::where('id',$product_data['category_id'])->first();


//            //check if product has Taxon
//            $hasTaxon = !is_null($product->first()->taxons);
            $hasSameTaxon = false;
            //Update product details
            $product->update([
                'name' => $product_data['name'],
                'sku' => $sku,
                'slug' => str_slug($product_data['name'], '-'),
                'price' => $product_data['price'],
                'description' => $product_data['description'],
                'meta_keywords' => $product_data['tags']
            ]);


            //Check if product already has same Taxon to prevent exception
            if($product->first()->taxons()->count()) {
                foreach ($product->first()->taxons as $item) {
                    $taxon = Taxon::findBySlug($item->slug);
                    $product->first()->taxons()->detach($taxon);
                }
            }

            //Add Taxon to product
                $taxon = Taxon::findBySlug($getTaxon->slug);
                $product->first()->taxons()->save($taxon);


            //Relate images to product
            if ($request['images']) {
                foreach ($request['images'] as $image) {
                    $product->first()
                        ->addMedia($image)
                        ->preservingOriginal()
                        ->toMediaCollection('images');
                }
            }
            return response()->json(['status' => 200, 'message' => 'Product updated'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => 'Failed to update product '.$e->getMessage()], 400);
        }

    }

    public function destroy($product_id, $taxon_id)
    {
        try {
            //Get product model
            $product = \App\Product::where('id', $product_id);

            if (!$taxon_id == 0 && $product->exists()) {
                //Get Taxon
                $taxon = Taxon::where('id', $taxon_id)->first();

                //Unlink Taxon
                $product->first()->taxons()->detach($taxon);
            }

            //Delete product
            $product->delete();
            return response()->json(['message' => 'Product Deleted', 'status' => 200], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to Delete' . $e->getMessage(), 'status' => 400], 400);
        }
    }

    public function getProductsData(Request $request)
    {

        $products = \App\Product::all();

        return Datatables::of($products)->editColumn('created_at', function ($data) {
            return $data->created_at ? with(new Carbon($data->created_at))->toDayDateTimeString() : '';
        })
            ->addColumn('image', function ($subdata) {
                if ($subdata->getMedia('images')->count()) {
                    return "<img src=" .env('APP_URL'). $subdata->getMedia('images')->first()->getUrl() . "  width='100px'>";
                } else {
                    return "None";
                }
            })->addColumn('taxons', function ($subdata) {
                if(($subdata->taxons->count())){
                   return $subdata->taxons->first()->name . '-' .$subdata->taxons->first()->taxonomy->name;
                }
                return 'Uncategorized';
            })->editColumn('price', function ($subdata) {

                return "&#8358;".number_format($subdata->price, '0', '.', ',');
            })
            ->editColumn('meta_description', function ($subdata) {

                return str_limit($subdata->meta_description, 30);
            })
            ->addColumn('action', function ($subdata) {
                return '      <td>
                                                    <button class="btn btn-danger btn-sm dropdown-toggle" type="button" id="settingcol" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fas fa-cogs"></i> </button>
                                                    <div class="dropdown-menu" aria-labelledby="settingcol">
                    
                                                        <a style="mrgin-bottom:25px; padding:15px 5px" class="dropdown-item activate_btn" href="#" id="' . $subdata->id . '" onclick="activate(' . $subdata->id . ')">Activate</a>
                                                        <a style="mrgin-bottom:25px; padding:15px 5px" class="dropdown-item deactivate_btn" href="#" id="' . $subdata->id . '" onclick="deactivate(' . $subdata->id . ')">Deactivate</a>
                                                        <a style="mrgin-bottom:25px; padding:15px 5px" class="dropdown-item" href="' . route('edit_product', ['id' => $subdata->id]) . '">Edit</a>
                                                        <a style="mrgin-bottom:25px; padding:15px 5px" class="dropdown-item del_btn" href="#" id="' . $subdata->id . '" onclick="destroy(' . $subdata->id . ',' . ( ($subdata->taxons->count()) ? $subdata->taxons->first()->id : null) . ')">Delete </a>
 </div></td>';
            })
            ->rawColumns(['image', 'action', 'price'])
            ->make(true);
    }

    public function deactivate($product_id)
    {
        try {
            //Get product model
            $product = \App\Product::where('id', $product_id)->first();
            $product->state = ProductState::INACTIVE();
            $product->save();

            return response()->json(['message' => 'Deactivated', 'status' => 200], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to Deactivate', 'status' => 400], 400);
        }
    }

    public function activate($product_id)
    {
        try {
            //Get product model
            $product = \App\Product::where('id', $product_id)->first();
            $product->state = ProductState::ACTIVE();
            $product->save();

            return response()->json(['message' => 'Activated', 'status' => 200], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to Activate', 'status' => 400], 400);
        }
    }

    public function edit($id)
    {
        $product = \App\Product::where('id', $id)->first();
        $categories = Taxon::all();
        return view('pages.admin.product_edit', compact('product', 'categories'));
    }

    public function addComment($product_id, Request $request){
        $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
        ]);
        try {
            $user = Auth::check() ? Auth::user()->firstname : User::where('firstname', 'guest')->first();
            $product = \App\Product::where('id', $product_id)->first();
            $product->comment([
                'title' => $request->title,
                'body' => $request->comment,
            ], $user);
            return back()->with('status', 'Comment created');
        }catch (\Exception $e){
            return back()->with('error', 'Comment creation failed');
        }
    }

    public function addRating(Request $request){
        $request->validate([
            'rating' => 'required',
            'slug' => 'required',
        ]);
        $user = Auth::guest() ? User::where('firstname', 'guest')->first()->id : Auth::id();
        $product = \App\Product::findBySlug($request->slug)->first();
        $rating = new \willvincent\Rateable\Rating;
        $rating->rating = $request->rating;
        $rating->user_id = $user;
        $product->ratings()->save($rating);
        return response()->json($product->averageRating);
    }

}
