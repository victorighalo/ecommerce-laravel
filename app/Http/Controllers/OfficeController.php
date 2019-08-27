<?php

namespace App\Http\Controllers;


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
        $data = \App\Transactions::take(15)->get();
        return view('pages.admin.dashboard.index', compact('data'));
    }

    public function transactions(){
        $data = \App\Transactions::paginate(20);
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
        $data = \App\Transactions::join('order_items', function ($join){
            $join->on('transactions.order_id', '=', 'order_items.order_id');
        }
        )->join('states', 'transactions.state_id', 'states.state_id')
            ->join('cities', 'transactions.city_id', 'cities.city_id')
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
        $products = OrderItem::where('order_id', $request->input('order_id'))
            ->join('products', 'order_items.product_id', 'products.id')
            ->get();

        return response()->json(['data' => $products]);

    }

}
