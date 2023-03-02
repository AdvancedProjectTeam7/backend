<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Currency;
class CurrencyController extends Controller
{
    // add currency
    public function addCurrency(Request $request)
    {

        $validator = Validator::make($request->all(), [

            'name' => 'required',
            'rate' => 'required',
        ]);

        if ($validator->fails()) {
            $currency = [
                'status' => 401,
                'message' => $validator->errors(),
                'data' => null,
            ];

            return $currency;
        } else {
            $currency = new currency;
            $currency->name = $request->name;
            $currency->rate = $request->rate;
            $currency->save();
            $respond = [
                'status' => 200,
                'message' => 'currency added successfully',
                'data' => $currency,
            ];
            return $respond;
        }
    }
    // get all
    public function getAllcurrency(Request $request)
    {
        $Currencies = currency::all();
        $currency = [
            'status' => 200,
            'message' => 'get all Currencies successfully',
            'data' => $Currencies,
        ];
        return $currency;
    }

    // get currency by id
    public function getcurrency(Request $request, $id)
    {
        $currency =  currency::find($id);
        if (!$currency) {
            $respond = [
                'status' => 404,
                'message' => 'currency not found',
                'data' => null,
            ];

            return $respond;
        }
        if (($currency)) {
            $respond = [
                'status' => 200,
                'message' => 'get currency by id',
                'data' => $currency,
            ];
            return $respond;
        }
    }

    // get currency by name
    public function getByName($name)
{
    $currency = currency::where('name', 'like', '%' . $name . '%')->orwhere('rate', 'like', '%' . $name . '%')->get();
    if (!$currency->isEmpty() && $currency[0]->name == $name)    {
        $currency = [
            'status' => 200,
            'message' => 'getting currency by name',
            'data' => $currency,
        ];
        return $currency;
    } else {
        $error = [
            'status' => 404,
            'message' => 'no currency with this name',
            'data' => null,
        ];
        return $error;
    }
}

    // edit currency by id
    public function editCurrency(Request $request, $id)
    {
        $validator = Validator::make($request->only('name', 'rate'), [
            'name' => 'required',
            'rate' => 'required',
        ]);
        $currency = currency::find($id);
        if (!$currency) {
            $respond = [
                'status' => 404,
                'message' => 'currency not found',
                'data' => null,
            ];

            return $respond;
        }
        if ($validator->fails()) {
            $respond = [
                'status' => 401,
                'message' => $validator->errors()->first(),
                'data' => null,
            ];

            return $respond;
        } else {
            $currency = currency::find($id);
            $currency->name = $request->input("name");
            $currency->rate = $request->input("rate");
            $currency->update();

            $currency = [
                'status' => 200,
                'message' => 'currency edited successfully',
                'data' => $currency,
            ];

            return $currency;
        }
    }



    // delete currency by id
    public function deletecurrency(Request $request, $id)
    {
        $currency = currency::find($id);

        if (($currency)) {
            $currency->delete();
            $respond = [
                'status' => 200,
                'message' => 'currency deleted successfully',
                'data' => $currency,
            ];
            return $respond;
        } else {
            $error = [
                'satus' => 404,
                'message' => 'id not found',
                'data' => $currency,
            ];
            return $error;
        }
    }
}
