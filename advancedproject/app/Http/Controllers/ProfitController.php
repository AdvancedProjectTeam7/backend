<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profit_goal;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfitController extends Controller
{

    // add profit 
    public function addProfit(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'amount' => 'required',

        ]);
        if ($validator->fails()) {
            $respond = [
                'status' => 401,
                'message' => $validator->errors()->first(),
                'data' => null,
            ];

            return $respond;
        } else {
            $profit = new Profit_goal;
            $amount = $request->input('amount');
            $profit->amount = $amount;
            $profit->save();
            return response()->json([
                'message' => 'profit created',
                'profit' => $profit
            ]);
        }
    }
    // get all profit
    public function getAllProfit(Request $request)
    {
        $profit = Profit_goal::all();

        $profit = [
            'status' => 200,
            'message' => 'get all profit successfully',
            'data' => $profit,
        ];
        return $profit;
    }

    // get profit by id
    public function getProfit(Request $request, $id)
    {
        $profit =  Profit_goal::find($id);
        if (!$profit) {
            $profit = [
                'status' => 404,
                'message' => 'profit not found',
                'data' => null,
            ];

            return $profit;
        }

        if (($profit)) {
            $profit = [
                'status' => 200,
                'message' => 'get profit by id',
                'data' => $profit,
            ];
            return $profit;
        }
    }

    // edit profit by id
    public function editProfit(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required',

        ]);
        $profit = Profit_goal::find($id);
        if (!$profit) {
            $profit = [
                'status' => 404,
                'message' => 'profit not found',
                'data' => null,
            ];

            return $profit;
        }
        if ($validator->fails()) {
            $profit = [
                'status' => 401,
                'message' => $validator->errors()->first(),
                'data' => null,
            ];

            return $profit;
        } else {
            $profit = Profit_goal::find($id);
            $profit->amount = $request->amount;
            $profit->save();

            $profit = [
                'status' => 200,
                'message' => 'profit edited successfully',
                'data' => $profit,
            ];

            return $profit;
        }
    }

    // delete profit by id
    public function deleteProfit(Request $request, $id)
    {
        $profit = Profit_goal::find($id);

        if (($profit)) {
            $profit->delete();
            $respond = [
                'status' => 200,
                'message' => 'profit deleted successfully',
                'data' => $profit,
            ];
            return $respond;
        } else {
            $error = [
                'satus' => 404,
                'message' => 'id not found',
                'data' => $profit,
            ];
            return $error;
        }
    }
}
