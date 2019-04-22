<?php

namespace App\Http\Controllers;

use App\DeliveryPrice;
use App\Product;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Taxon;
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

            //Get Taxon
            $taxon = Taxon::findBySlug($product_data['taxon_slug']);

            //Generate SKU
            $sku = strtoupper(substr($product_data['name'], 0, 3)) . "-" . $taxon->id;

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


            //Add Taxon to product
            $product->taxons()->save($taxon);


            //Add images to product
            if($request['images']) {
                foreach ($request['images'] as $image) {
                $product->photos()->create([
                    'link' => $image,
                    'photoable_type' => get_class($product),
                    'photoable_id' => $product->id,
                ]);
                }
            }
            $delivery_price = new DeliveryPrice();
            $delivery_price->amount = $product_data['delivery_price'];
            //Create Delivery Price
                $product->delivery_price()->save($delivery_price);

            return response()->json(['status' => 200, 'message' => 'Product created'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => 'Failed to create product '. $e->getMessage()], 400);
        }

    }

    public function update(Request $request)
    {
        $hasSameTaxon = null;
        try {
            //Parse query-string input
            parse_str($request->form_data, $product_data);

            //Get Taxon
            $taxon = Taxon::findBySlug($product_data['taxon_slug']);

            //Generate SKU
            $sku = strtoupper(substr($product_data['name'], 0, 3)) . "-" . $taxon->id;

            //Get Product
            $product = \App\Product::where('id', $product_data['id']);


            $hasSameTaxon = false;
            //Update product details
            $product->update([
                'name' => $product_data['name'],
                'sku' => $sku,
                'slug' => str_slug($product_data['name'], '-'),
                'price' => $product_data['price'],
                'meta_description' => $product_data['meta_description'],
                'description' => $request->description,
                'meta_keywords' => $product_data['tags']
            ]);


            //Check if product already has same Taxon to prevent exception
//            if($product->first()->taxons()->count()) {
//                foreach ($product->first()->taxons as $item) {
//                    $taxon = Taxon::findBySlug($item->slug);
//                    $product->first()->taxons()->detach($taxon);
//                }
//            }

            //update Taxon to product
             $product->first()->taxons()->detach();
             $product->first()->taxons()->save($taxon);

            //update images for product
            if($request['images'] && count($request['images']) > 0) {
                foreach ($request['images'] as $image) {
                    $product->first()->photos()->create([
                        'link' => $image,
                        'photoable_type' => get_class($product->first()),
                        'photoable_id' => $product_data['id'],
                    ]);
                }
            }

            //update Delivery Price
            DeliveryPrice::where('delivery_price_id', $product_data['id'])->update(
               ['amount' => $product_data['delivery_price']]
            );


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
            $name = $product->first()->name;

//            if (!$taxon_id == 0 && $product->exists()) {
//                //Get Taxon
//                $taxon = Taxon::where('id', $taxon_id)->first();
//
//                //Unlink Taxon
//                $product->first()->taxons()->detach($taxon);
//            }

            //Remove from delivery prices table
            DeliveryPrice::where('delivery_price_id', $product_id)->delete();

            //Delete product
            $product->delete();
            return response()->json(['message' => $name .' Deleted', 'status' => 200], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to Delete ' . $e->getMessage(), 'status' => 400], 400);
        }
    }

    public function getProductsData()
    {

        $products = \App\Product::all();

        return Datatables::of($products)->editColumn('created_at', function ($data) {
            return $data->created_at ? with(new Carbon($data->created_at))->toDayDateTimeString() : '';
        })
            ->addColumn('image', function ($subdata) {
                if ($subdata->hasPhoto()) {
                    return "<img src=" . $subdata->firstThumb . "  width='100px'>";
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
            })->editColumn('delivery_price', function ($subdata) {

                return "&#8358;".number_format($subdata->delivery_price->amount, '0', '.', ',');
            })->editColumn('state', function ($subdata) {
                if($subdata->state == "active"){
                    return  '<span class="badge badge-success">'.$subdata->state.'</span>';
                    }else{
                    return  '<span class="badge badge-danger">'.$subdata->state.'</span>';
                }
            })
            ->editColumn('meta_description', function ($subdata) {

                return str_limit($subdata->meta_description, 30);
            })
            ->addColumn('action', function ($subdata) {
                return '      <td>
                                                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="settingcol" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fas fa-cogs"></i> </button>
                                                    <div class="dropdown-menu" aria-labelledby="settingcol" style="padding: 10px;">
         
                                                        <a style="padding:8px 5px" class="dropdown-item activate_btn" href="#" id="' . $subdata->id . '" onclick="activate(' . $subdata->id . ')">Activate <i class="fas fa-check float-right"></i></a>
                                                        <a style="padding:8px 5px" class="dropdown-item deactivate_btn" href="#" id="' . $subdata->id . '" onclick="deactivate(' . $subdata->id . ')">Deactivate <i class="fas fa-ban float-right"></i></a>
                                                        <a style="padding:8px 5px" class="dropdown-item" href="' . route('edit_product', ['id' => $subdata->id]) . '">Edit <i class="fas fa-edit float-right"></i></a>
                                                        <a style="padding:8px 5px" class="dropdown-item del_btn" href="#" id="' . $subdata->id . '" onclick="destroy(' . $subdata->id . ',' . ( ($subdata->taxons->count()) ? $subdata->taxons->first()->id : null) . ')"><span>Delete</span> <i class="fas fa-trash float-right"></i></a>
 </div></td>';
            })
            ->rawColumns(['image', 'action', 'price', 'delivery_price', 'state'])
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
        if(! \App\Product::where('id', $id)->exists() ){
            abort(404);
        }
        $product = \App\Product::where('id', $id)->first();
        $categories = Taxon::all();
        return view('pages.admin.product_edit', compact('product', 'categories'));
    }

    public function addComment($product_id, Request $request){
        $request->validate([
            'title' => 'required|max:255',
            'comment' => 'required',
        ]);
        try {
            $user = Auth::check() ? Auth::user() : User::where('firstname', 'guest');
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

    public function removePhoto(Request $request){
        $product = \App\Product::findBySlug($request->productslug)->first();
        try {
            $product->removePhoto($request->imageid, $product->id);
            return response()->json(['message' => 'Product image removed', 'status' => 200], 200);

        }catch(\Exception $e){
            return response()->json(['message' => 'Failed to remove Product image ' . $e->getMessage(), 'status' => 400], 400);
        }
    }
}
