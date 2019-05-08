<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Konekt\Acl\Models\Role;
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
        return redirect('office/products');
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
        )->get();
        return Datatables::of($data)->make(true);
    }

}