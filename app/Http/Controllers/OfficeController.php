<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Konekt\Acl\Models\Role;
use Vanilo\Cart\Models\CartItem;
use Yajra\DataTables\DataTables;

class OfficeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
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
        return view('pages.admin.dashboard.index');
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
       return view('pages.admin.orders.index');
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
        $products = CartItem::where('cart_id', $request->cart_id)
            ->join('products', 'cart_items.product_id', 'products.id')
            ->get();
        return response()->json(['data' => $products]);

    }

}
