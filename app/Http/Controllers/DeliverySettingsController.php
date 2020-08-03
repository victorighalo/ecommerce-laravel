<?php

namespace App\Http\Controllers;

use App\DeliveryCharge;
use App\Http\Requests\NewDeliveryCostRequest;
use App\Http\Requests\UpdateDeliveryCostRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Vanilo\Cart\Facades\Cart;
class DeliverySettingsController extends Controller
{
    public function index(){
        $states = DB::table('states')->get();
        return view('pages.admin.delivery.index', compact('states'));
    }

    public function store(NewDeliveryCostRequest $request){
        try{
            DeliveryCharge::updateOrCreate($request->except('_token'));
            return response()->json(['message' => 'Cost saved']);
        }catch (\Exception $e){
            return response()->json(['message' => 'Failed to save cost', 'reason' => $e->getMessage()], 500);
        }
    }

    public function update(UpdateDeliveryCostRequest $request){
        try{
            DeliveryCharge::where('id',$request->id)->update(['cost' => $request->value]);
            return response()->json(['message' => 'Cost updated']);
        }catch (\Exception $e){
            return response()->json(['message' => 'Failed to update cost', 'reason' => $e->getMessage()], 500);
        }
    }

    public function destroy($id){
        try{
            DeliveryCharge::destroy($id);
            return response()->json(['message' => 'Cost deleted']);
        }catch (\Exception $e){
            return response()->json(['message' => 'Failed to delete cost', 'reason' => $e->getMessage()], 500);
        }
    }

    public function getDeliveryCostData(Request $request){

        $data = DeliveryCharge::join('states', 'delivery_charges.state_id', 'states.state_id')
            ->join('cities', 'delivery_charges.city_id', 'cities.city_id')
            ->get();

        return Datatables::of($data)
            ->addColumn('action', function ($data) {
                return '      <td>
                                                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="settingcol" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fas fa-cogs"></i> </button>
                                                    <div class="dropdown-menu" aria-labelledby="settingcol" style="padding: 10px;">
                                                          <a style="padding:8px 5px" class="dropdown-item"  onclick="edit(' . $data->id . ')">Edit <i class="fas fa-edit float-right"></i></a>
                                               
                                                        <a style="padding:8px 5px" class="dropdown-item del_btn" href="#" id="' . $data->id . '" onclick="destroy(' . $data->id .')"><span>Delete</span> <i class="fas fa-trash float-right"></i></a>
 </div></td>';
            })
            ->editColumn('cost', function ($data){
                return number_format($data->cost, 0,'.', ',');
            })
            ->rawColumns([ 'action'])
            ->make(true);
    }

    public function getDeliveryCost(Request $request){
        $delivery_cost = $this->calculateDelivery($request);
        if(!$delivery_cost){
            return response()->json([
                'delivery_cost' => 0,
                'total_cost' => Cart::total(),
                'extra' => $delivery_cost
            ]);
        }
        return response()->json([
            'delivery_cost' => $delivery_cost,
            'total_cost' => Cart::total() + $delivery_cost,
        ]);
    }

    private function calculateDelivery(Request $request){
        $delivery_cost = 0;
        foreach (Cart::getItems() as $item){
            $delivery_cost += $item->product->delivery_price->amount * $item->quantity;
        }
        $data = DeliveryCharge::where('state_id', $request->state_id)->where('city_id', $request->city_id);

        if($data->exists())
        {
            $delivery_cost += $data->first()->cost;
        }
        if($delivery_cost == 0){
            return null;
        }
        return $delivery_cost;
    }
}
