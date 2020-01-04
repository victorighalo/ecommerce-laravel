<?php

namespace App\Http\Controllers;


use App\CartItemVariant;
use App\OrderItemVariant;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Konekt\Acl\Models\Role;

use Vanilo\Order\Models\OrderItem;
use Yajra\DataTables\DataTables;

class OfficeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        SEOMeta::setTitle('Office | '.config('app.name', ''), false);

    }

    public function office()
    {
//        $user = User::create([
//            'firstname' => 'Victor',
//            'lastname' => 'Ighalo',
//            'email' => 'victorghalo@gmail.com',
//            'password' => Hash::make('123456'),
//        ]);
//        Role::create(['name' => 'admin']);
//        $user = User::find(1)->first();
//        $user->assignRole('admin');
        return redirect('office/dashboard');
    }

    public function dashboard(){
        $data = \App\Transactions::complete()->delivery()->latest()->take(15)->get();
        return view('pages.admin.dashboard.index', compact('data'));
    }

    public function transactions(){
        $data = \App\Transactions::complete()->delivery()->latest()->paginate(20);
        return view('pages.admin.transactions.index', compact('data'));
    }

    public function getStoreStats(){
        $total_products = \App\Product::active()->count();
        $total_transactions = \App\Transactions::where('status', '=', 'pending')->count();
        return response()->json([
            'total_products' => $total_products,
            'total_transactions' => $total_transactions,
        ]);
    }

    public function orders(){
//        $data = \App\Transactions::complete()->delivery()->pending()->join('order_items', function ($join){
//            $join->on('transactions.order_id', '=', 'order_items.order_id');
//        }
//        )
        $data = \App\Transactions::
            join('states', 'transactions.state_id', 'states.state_id')
            ->join('cities', 'transactions.city_id', 'cities.city_id')
            ->orderBy('created_at', 'DESC')
            ->paginate(20);
       return view('pages.admin.orders.index', compact('data'));
    }

    public function ordersData(){
        $data = \App\Transactions::join('cart_items', function ($join){
          $join->on('transactions.cart_id', '=', 'cart_items.cart_id');
        }
        )->join('states', 'transactions.state_id', 'states.state_id')
        ->join('cities', 'transactions.city_id', 'cities.city_id')
            ->get();

        return Datatables::of($data)
            ->editColumn('amount', function ($item){
            return number_format($item->price, 0,'.', ',');
        })->addColumn('action', function ($item){
            return "<button class='btn btn-md btn-link view_products' data-cart_id=".$item->cart_id.">Products</button>";
        })
            ->make(true);
    }


    public function ordersProducts(Request $request){
        $products = [];
        $orders = OrderItem::where('order_id', $request->input('order_id'))->select('id','product_id','price','name','delivery_price')->get();

        foreach ($orders as $order) {
            $data = \App\Product::where('id', $order->product_id)->get();

            foreach ($data as $product) {
                $products[] = (object)[
                    'price' => $order->price,
                    'pid' => $product->id,
                    'oid' => $request->input('order_id'),
                    'name' => $order->name,
                    'delivery_price' => $order->delivery_price ? $order->delivery_price : 0,
                    'properties' => isset($product->propertyValues) ? $this->getProperties($product->propertyValues) : null,
                    'category' => $product->taxons->first()->name,
                    'description' => $product->meta_description,
                    'overview' => $product->description,
                    'variants' => $this->getVariants($product->id,$request->input('order_id')),
                    'images' => $product->hasPhoto() ? $product->photos : null
                ];
            }
        }

        return response()->json(['data' => $products]);

    }

    private function getProperties($props){
        $data = [];
        foreach ($props as $prop){
            $data[] = [
                'name' => $prop->property->name,
                'value' => $prop->value,
            ];
        }
        return $data;
    }

    private function getVariants($product_id,$order_id){
        return OrderItemVariant::where('product_id',$product_id)->where('order_id', $order_id)
            ->select('option_name', 'option_value_name')
            ->get()->toArray();
    }

    private function calculateDelivery($state_id, $city_id){
        $delivery_cost = 0;

        $data = \App\DeliveryCharge::where('state_id', $state_id)->where('city_id', $city_id);

        if($data->exists())
        {
            $delivery_cost += $data->first()->cost;
        }
        return $delivery_cost;
    }

}
