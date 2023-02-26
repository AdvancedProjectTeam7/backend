<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FixedTransactionController extends Controller
{
    public function getAll()
    {
        $data = FixedTransaction::where('date', '<=', now())->orderBy('date', 'desc')->get();
        foreach ($data as $each) {
            $each->category;
            $each->currency;
        }

        $respond = [
            "status" => 201,
            "message" => "Successfully get all Transactions",
            "data" => $data
        ];
        return response($respond, $respond["status"]);
    }

    public function getAllIncome()
    {
        $data = FixedTransaction::whereRelation("category", "type", 'income')->where('date', '<=', now())->orderBy('date', 'desc')->get();

        // $data = Transaction::all();
        foreach ($data as $each) {
            $each->category;
            $each->currency;
        }

        $respond = [
            "status" => 201,
            "message" => "Successfully get all Transactions",
            "data" => $data
        ];
        return response($respond, $respond["status"]);
    }

    public function getAllExpense()
    {
        $data = FixedTransaction::whereRelation("category", "type", 'expense')->where('date', '<=', now())->orderBy('date', 'desc')->get();

        // $data = Transaction::all();
        foreach ($data as $each) {
            $each->category;
            $each->currency;
        }

        $respond = [
            "status" => 201,
            "message" => "Successfully get all Transactions",
            "data" => $data
        ];
        return response($respond, $respond["status"]);
    }

    public function getByDate()
    {
        $data = FixedTransaction::where('date', '<=', now())->orderBy('date', 'desc')->get();
        foreach ($data as $each) {
            $each->category;
            $each->currency;
        }
        $respond = [
            "status" => 201,
            "message" => "Successfully get all Transactions",
            "data" => $data
        ];
        return response($respond, $respond["status"]);
    }

    public function getPaginationAll()
    {
        $data = FixedTransaction::where('date', '<=', now())->orderBy('date', 'desc')->paginate(10);

        foreach ($data as $each) {
            $each->category;
            $each->currency;
        }
        $respond = [
            "status" => 201,
            "message" => "Successfully get all Transactions",
            "data" => $data
        ];
        return response($respond, $respond["status"]);
    }

    public function getPaginationincome()
    {

        $data = FixedTransaction::whereRelation("category", "type", 'income')->where('date', '<=', now())->orderBy('date', 'desc')->paginate(10);

        foreach ($data as $each) {
            $each->category;
            $each->currency;
        }

        $respond = [
            "status" => 201,
            "message" => "Successfully get all Transactions",
            "data" => $data
        ];
        return response($respond, $respond["status"]);
    }

    public function getPaginationExpenses()
    {
        $data = FixedTransaction::whereRelation("category", "type", 'expense')->where('date', '<=', now())->orderBy('date', 'desc')->paginate(10);

        foreach ($data as $each) {
            $each->category;
            $each->currency;
        }

        $respond = [
            "status" => 201,
            "message" => "Successfully get all Transactions",
            "data" => $data
        ];
        return response($respond, $respond["status"]);
    }

    public function getLatestTransactions()
    {
        $data = FixedTransaction::where('date', '<=', now())->orderBy('date', 'desc')->paginate(5);

        foreach ($data as $each) {
            $each->category;
            $each->currency;
        }

        $respond = [
            "status" => 201,
            "message" => "Successfully get latest transactions",
            "data" => $data
        ];
        return response($respond, $respond["status"]);
    }

    public function getIncome()
    {
        $dataDollar = FixedTransaction::whereRelation("category", "type", 'income')->where('currency', '=', '$')->where('date', '<=', now())->orderBy('date', 'desc')->sum('amount');

        $dataLira = FixedTransaction::whereRelation("category", "type", 'income')->where('currency', '=', 'L.L.')->where('date', '<=', now())->orderBy('date', 'desc')->sum('amount');

        $respond = [
            "status" => 201,
            "message" => "Successfully get incomes amount",
            "data" => $dataDollar + $dataLira / 1500
        ];
        return response($respond, $respond["status"]);
    }

    public function getExpense()
    {
        $dataDollar = FixedTransaction::whereRelation("category", "type", 'expense')->where('currency', '=', '$')->where('date', '<=', now())->orderBy('date', 'desc')->sum('amount');

        $dataLira = FixedTransaction::whereRelation("category", "type", 'expense')->where('currency', '=', 'L.L.')->where('date', '<=', now())->orderBy('date', 'desc')->sum('amount');

        $respond = [
            "status" => 201,
            "message" => "Successfully get expenses amount",
            "data" => $dataDollar + $dataLira / 1500
        ];
        return response($respond, $respond["status"]);
    }

    public function getById($id)
    {
        $transaction = FixedTransaction::find($id);
        $transaction->category;
        $transaction->currency;

        if (isset($transaction)) {
            $respond = [
                "status" => 201,
                "message" => "Successfully get transaction with id " . $id,
                "data" => $transaction
            ];
        } else {
            $respond = [
                "status" => 404,
                "message" => "id " . $id . " does not exist",
                "data" => $transaction
            ];
        }

        return response($respond, $respond["status"]);
    }

    public function getMonthly(Request $request)
    {

        for ($i = 11; $i >= 0; $i--) {
            $month = date("Y-m-d", strtotime(date('Y-m-01') . " -" . $i - $request->query('range') * 12 . " months"));
            $date = Carbon::createFromFormat('Y-m-d', $month);

            $income = FixedTransaction::whereRelation("category", "type", 'income')->where('currency', '=', '$')->where('date', '<=', now())->orderBy('date', 'desc')->whereMonth('date', $date->month)
                ->whereYear('date', $date->year)
                ->sum('amount');
            $incomeLira = FixedTransaction::whereRelation("category", "type", 'income')->where('currency', '=', 'L.L.')->where('date', '<=', now())->orderBy('date', 'desc')->whereMonth('date', $date->month)
                ->whereYear('date', $date->year)
                ->sum('amount');

            $expense = FixedTransaction::whereRelation("category", "type", 'expense')->where('currency', '=', '$')->where('date', '<=', now())->orderBy('date', 'desc')->whereMonth('date', $date->month)
                ->whereYear('date', $date->year)
                ->sum('amount');
            $expenseLira = FixedTransaction::whereRelation("category", "type", 'expense')->where('currency', '=', 'L.L.')->where('date', '<=', now())->orderBy('date', 'desc')->whereMonth('date', $date->month)
                ->whereYear('date', $date->year)
                ->sum('amount');

            $incomedata[] = [
                "date" => $date->format('M Y'),
                "amount" => $income + $incomeLira / 1500,
            ];

            $expensedata[] = [
                "date" => $date->format('M Y'),
                "amount" => $expense + $expenseLira / 1500,
            ];
        }

        $respond = [
            "status" => 201,
            "message" => "Successfully records of last 12 months",
            "data" => [$incomedata, $expensedata]
        ];

        return $respond;
    }

    public function getMonthlyMobile(Request $request)
    {

        for ($i = 5; $i >= 0; $i--) {
            $month = date("Y-m-d", strtotime(date('Y-m-01') . " -" . $i - $request->query('range') * 6 . " months"));
            $date = Carbon::createFromFormat('Y-m-d', $month);

            $income = FixedTransaction::whereRelation("category", "type", 'income')->where('currency', '=', '$')->where('date', '<=', now())->orderBy('date', 'desc')->whereMonth('date', $date->month)
                ->whereYear('date', $date->year)
                ->sum('amount');
            $incomeLira = FixedTransaction::whereRelation("category", "type", 'income')->where('currency', '=', 'L.L.')->where('date', '<=', now())->orderBy('date', 'desc')->whereMonth('date', $date->month)
                ->whereYear('date', $date->year)
                ->sum('amount');

            $expense = FixedTransaction::whereRelation("category", "type", 'expense')->where('currency', '=', '$')->where('date', '<=', now())->orderBy('date', 'desc')->whereMonth('date', $date->month)
                ->whereYear('date', $date->year)
                ->sum('amount');
            $expenseLira = FixedTransaction::whereRelation("category", "type", 'expense')->where('currency', '=', 'L.L.')->where('date', '<=', now())->orderBy('date', 'desc')->whereMonth('date', $date->month)
                ->whereYear('date', $date->year)
                ->sum('amount');

            $data[] = [
                "date" => $date->format('M Y'),
                "income" => $income + $incomeLira / 1500,
                "expense" => $expense + $expenseLira / 1500,
            ];
        }

        $respond = [
            "status" => 201,
            "message" => "Successfully records of last 12 months",
            "data" => $data
        ];

        return $respond;
    }

    public function getWeekly(Request $request)
    {
        for ($i = 6; $i >= 0; $i--) {
            $day = date("Y-m-d", strtotime(date('Y-m-d') . " -" . $i - $request->query('range') * 7 . " days"));

            $date = Carbon::createFromFormat('Y-m-d', $day);

            $income = FixedFixedTransaction::whereRelation("category", "type", 'income')->where('currency', '=', '$')->where('date', '<=', now())->orderBy('date', 'desc')->whereDay('date', $date->day)->whereMonth('date', $date->month)
                ->whereYear('date', $date->year)
                ->sum('amount');
            $incomeLira = FixedFixedTransaction::whereRelation("category", "type", 'income')->where('currency', '=', 'L.L.')->where('date', '<=', now())->orderBy('date', 'desc')->whereDay('date', $date->day)->whereMonth('date', $date->month)
                ->whereYear('date', $date->year)
                ->sum('amount');


            $expense = FixedFixedTransaction::whereRelation("category", "type", 'expense')->where('currency', '=', '$')->where('date', '<=', now())->orderBy('date', 'desc')->whereDay('date', $date->day)->whereMonth('date', $date->month)
                ->whereYear('date', $date->year)
                ->sum('amount');
            $expenseLira = FixedFixedTransaction::whereRelation("category", "type", 'expense')->where('currency', '=', 'L.L.')->where('date', '<=', now())->orderBy('date', 'desc')->whereDay('date', $date->day)->whereMonth('date', $date->month)
                ->whereYear('date', $date->year)
                ->sum('amount');

            $incomedata[] = [
                "date" => $date->format('D d M Y'),
                "amount" => $income + $incomeLira / 1500,
            ];

            $expensedata[] = [
                "date" => $date->format('D d M Y'),
                "amount" => $expense + $expenseLira / 1500,
            ];
        }

        $respond = [
            "status" => 201,
            "message" => "Successfully get records of last 7 days",
            "data" => [$incomedata, $expensedata]
        ];

        return $respond;
    }
    public function getWeeklyMobile(Request $request)
    {
        for ($i = 6; $i >= 0; $i--) {
            $day = date("Y-m-d", strtotime(date('Y-m-d') . " -" . $i - $request->query('range') * 7 . " days"));

            $date = Carbon::createFromFormat('Y-m-d', $day);

            $income = FixedTransaction::whereRelation("category", "type", 'income')->where('currency', '=', '$')->where('date', '<=', now())->orderBy('date', 'desc')->whereDay('date', $date->day)->whereMonth('date', $date->month)
                ->whereYear('date', $date->year)
                ->sum('amount');
            $incomeLira = FixedTransaction::whereRelation("category", "type", 'income')->where('currency', '=', 'L.L.')->where('date', '<=', now())->orderBy('date', 'desc')->whereDay('date', $date->day)->whereMonth('date', $date->month)
                ->whereYear('date', $date->year)
                ->sum('amount');


            $expense = FixedTransaction::whereRelation("category", "type", 'expense')->where('currency', '=', '$')->where('date', '<=', now())->orderBy('date', 'desc')->whereDay('date', $date->day)->whereMonth('date', $date->month)
                ->whereYear('date', $date->year)
                ->sum('amount');
            $expenseLira = FixedTransaction::whereRelation("category", "type", 'expense')->where('currency', '=', 'L.L.')->where('date', '<=', now())->orderBy('date', 'desc')->whereDay('date', $date->day)->whereMonth('date', $date->month)
                ->whereYear('date', $date->year)
                ->sum('amount');

            $data[] = [
                "date" => $date->format('d M Y'),
                "income" => $income + $incomeLira / 1500,
                "expense" => $expense + $expenseLira / 1500,
            ];
        }

        $respond = [
            "status" => 201,
            "message" => "Successfully get records of last 7 days",
            "data" => $data
        ];

        return $respond;
    }

    public function getYearly(Request $request)
    {
        for ($i = 4; $i >= 0; $i--) {
            $day = date("Y-m-d", strtotime(date('Y-m-d') . " -" . $i - $request->query('range') * 5 . " years"));

            $date = Carbon::createFromFormat('Y-m-d', $day);

            $income = FixedTransaction::whereRelation("category", "type", 'income')->where('currency', '=', '$')->where('date', '<=', now())->orderBy('date', 'desc')->whereYear('date', $date->year)->sum('amount');
            $incomeLira = FixedTransaction::whereRelation("category", "type", 'income')->where('currency', '=', 'L.L.')->where('date', '<=', now())->orderBy('date', 'desc')->sum('amount');

            $expense = FixedTransaction::whereRelation("category", "type", 'expense')->where('currency', '=', '$')->where('date', '<=', now())->orderBy('date', 'desc')->whereYear('date', $date->year)->sum('amount');
            $expenseLira = FixedTransaction::whereRelation("category", "type", 'expense')->where('currency', '=', 'L.L.')->where('date', '<=', now())->orderBy('date', 'desc')->sum('amount');

            $incomedata[] = [
                "date" => $date->format('Y'),
                "amount" => $income + $incomeLira / 1500,
            ];

            $expensedata[] = [
                "date" => $date->format('Y'),
                "amount" => $expense + $expenseLira / 1500,
            ];
        }

        $respond = [
            "status" => 201,
            "message" => "Successfully get records of last 5 years",
            "data" => [$incomedata, $expensedata]
        ];

        return $respond;
    }

    public function getYearlyMobile(Request $request)
    {
        for ($i = 4; $i >= 0; $i--) {
            $day = date("Y-m-d", strtotime(date('Y-m-d') . " -" . $i - $request->query('range') * 5 . " years"));

            $date = Carbon::createFromFormat('Y-m-d', $day);

            $income = FixedTransaction::whereRelation("category", "type", 'income')->where('currency', '=', '$')->where('date', '<=', now())->orderBy('date', 'desc')->whereYear('date', $date->year)->sum('amount');
            $incomeLira = FixedTransaction::whereRelation("category", "type", 'income')->where('currency', '=', 'L.L.')->where('date', '<=', now())->orderBy('date', 'desc')->sum('amount');

            $expense = FixedTransaction::whereRelation("category", "type", 'expense')->where('currency', '=', '$')->where('date', '<=', now())->orderBy('date', 'desc')->whereYear('date', $date->year)->sum('amount');
            $expenseLira = FixedTransaction::whereRelation("category", "type", 'expense')->where('currency', '=', 'L.L.')->where('date', '<=', now())->orderBy('date', 'desc')->sum('amount');

            $data[] = [
                "date" => $date->format('Y'),
                "income" => $income + $incomeLira / 1500,
                "expense" => $expense + $expenseLira / 1500,
            ];
        }

        $respond = [
            "status" => 201,
            "message" => "Successfully get records of last 5 years",
            "data" => $data
        ];

        return $respond;
    }

    public function getYearCategoryRecords(Request $request)
    {
        $year = date("Y-m-d", strtotime(date('Y-m-d') . " +" . $request->query('range') . " years"));

        $date = Carbon::createFromFormat('Y-m-d', $year);


        $incomeCategories = Category::where('type', '=', 'income')->get();

        foreach ($incomeCategories as $incomeCategory) {
            $data = FixedTransaction::whereRelation("category", "name", $incomeCategory->name)->where('currency', '=', '$')->where('date', '<=', now())->orderBy('date', 'desc')->whereYear('date', $date->year)->sum('amount');
            $dataLira = FixedTransaction::whereRelation("category", "name", $incomeCategory->name)->where('currency', '=', 'L.L.')->where('date', '<=', now())->orderBy('date', 'desc')->whereYear('date', $date->year)->sum('amount');

            $incomedata[] = [
                "category" => $incomeCategory->name,
                "amount" => $data + $dataLira / 1500,
            ];
        }

        $expenseCategories = Category::where('type', '=', 'expense')->get();

        foreach ($expenseCategories as $expenseCategory) {
            $data = FixedTransaction::whereRelation("category", "name", $expenseCategory->name)->where('currency', '=', '$')->where('date', '<=', now())->orderBy('date', 'desc')->whereYear('date', $date->year)->sum('amount');
            $dataLira = FixedTransaction::whereRelation("category", "name", $expenseCategory->name)->where('currency', '=', 'L.L.')->where('date', '<=', now())->orderBy('date', 'desc')->whereYear('date', $date->year)->sum('amount');
            $expensedata[] = [
                "category" => $expenseCategory->name,
                "amount" => $data + $dataLira / 1500,
            ];
        }

        $respond = [
            "status" => 201,
            "message" => "Successfully get records of category",
            "date" => $date->year,
            "data" => [$incomedata, $expensedata]
        ];

        return $respond;
    }

    public function getMonthCategoryRecords(Request $request)
    {
        $year = date("Y-m-d", strtotime(date('Y-m-d') . " +" . $request->query('range') . " months"));

        $date = Carbon::createFromFormat('Y-m-d', $year);


        $incomeCategories = Category::where('type', '=', 'income')->get();

        foreach ($incomeCategories as $incomeCategory) {
            $data = FixedTransaction::whereRelation("category", "name", $incomeCategory->name)->where('currency', '=', '$')->where('date', '<=', now())->orderBy('date', 'desc')->whereMonth('date', $date->month)->whereYear('date', $date->year)->sum('amount');
            $dataLira = FixedTransaction::whereRelation("category", "name", $incomeCategory->name)->where('currency', '=', 'L.L.')->where('date', '<=', now())->orderBy('date', 'desc')->whereMonth('date', $date->month)->whereYear('date', $date->year)->sum('amount');

            $incomedata[] = [
                "category" => $incomeCategory->name,
                "amount" => $data + $dataLira / 1500,
            ];
        }

        $expenseCategories = Category::where('type', '=', 'expense')->get();

        foreach ($expenseCategories as $expenseCategory) {
            $data = FixedTransaction::whereRelation("category", "name", $expenseCategory->name)->where('currency', '=', '$')->where('date', '<=', now())->orderBy('date', 'desc')->whereMonth('date', $date->month)->whereYear('date', $date->year)->sum('amount');
            $dataLira = FixedTransaction::whereRelation("category", "name", $expenseCategory->name)->where('currency', '=', 'L.L.')->where('date', '<=', now())->orderBy('date', 'desc')->whereMonth('date', $date->month)->whereYear('date', $date->year)->sum('amount');
            $expensedata[] = [
                "category" => $expenseCategory->name,
                "amount" => $data + $dataLira / 1500,
            ];
        }

        $respond = [
            "status" => 201,
            "message" => "Successfully get records of category",
            "date" => $date->format('M Y'),
            "data" => [$incomedata, $expensedata]
        ];

        return $respond;
    }

    public function getDayCategoryRecords(Request $request)
    {
        $year = date("Y-m-d", strtotime(date('Y-m-d') . " +" . $request->query('range') . " days"));

        $date = Carbon::createFromFormat('Y-m-d', $year);


        $incomeCategories = Category::where('type', '=', 'income')->get();

        foreach ($incomeCategories as $incomeCategory) {
            $data = FixedTransaction::whereRelation("category", "name", $incomeCategory->name)->where('currency', '=', '$')->where('date', '<=', now())->orderBy('date', 'desc')->whereDay('date', $date->day)->whereMonth('date', $date->month)->whereYear('date', $date->year)->sum('amount');
            $dataLira = FixedTransaction::whereRelation("category", "name", $incomeCategory->name)->where('currency', '=', 'L.L.')->where('date', '<=', now())->orderBy('date', 'desc')->whereDay('date', $date->day)->whereMonth('date', $date->month)->whereYear('date', $date->year)->sum('amount');
            $incomedata[] = [
                "category" => $incomeCategory->name,
                "amount" => $data + $dataLira / 1500,
            ];
        }

        $expenseCategories = Category::where('type', '=', 'expense')->get();

        foreach ($expenseCategories as $expenseCategory) {
            $data = FixedTransaction::whereRelation("category", "name", $expenseCategory->name)->where('currency', '=', '$')->where('date', '<=', now())->orderBy('date', 'desc')->whereDay('date', $date->day)->whereMonth('date', $date->month)->whereYear('date', $date->year)->sum('amount');
            $dataLira = FixedTransaction::whereRelation("category", "name", $expenseCategory->name)->where('currency', '=', 'L.L.')->where('date', '<=', now())->orderBy('date', 'desc')->whereDay('date', $date->day)->whereMonth('date', $date->month)->whereYear('date', $date->year)->sum('amount');
            $expensedata[] = [
                "category" => $expenseCategory->name,
                "amount" => $data + $dataLira / 1500,
            ];
        }

        $respond = [
            "status" => 201,
            "message" => "Successfully get records of category",
            "date" => $date->format('D d M Y'),
            "data" => [$incomedata, $expensedata]
        ];

        return $respond;
    }

    public function createFixed(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => "required|string",
            'description' => "required|string",
            'category_id' => "required|numeric|min:1",
            'amount' => "required|numeric|min:1",
            'currency_id' =>  "required|numeric|min:1",
            'date' => 'required|date|before:tomorrow',
            'type' => 'required|in:income,expense'
        ]);

        if ($validator->fails()) {
            $respond = [
                "status" => 401,
                "message" => $validator->errors()->first(),
                "data" => null
            ];
        } else {
            $transaction = new FixedTransaction;
            $transaction->title = $request->title;
            $transaction->description = $request->description;
            $transaction->category_id = $request->category_id;
            $transaction->amount = $request->amount;
            $transaction->currency_id = $request->currency_id;
            $transaction->date = $request->date;
            $transaction->type = $request->type;
            $transaction->save();

            $respond = [
                "status" => 201,
                "message" => "successfully added",
                "data" => $transaction
            ];
        }
        return response($respond);
    }

    public function updateFixed(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'title' => "string",
            'description' => "string",
            'category_id' => "numeric|min:1",
            'amount' => "numeric|min:1",
            'currency_id' =>  "numeric|min:1",
            'date' => 'date|before:tomorrow',
            'type' => "string"
        ]);

        if ($validator->fails()) {
            $respond = [
                "status" => 401,
                "message" => $validator->errors()->first(),
                "data" => null
            ];
        } else {
            $transaction = FixedTransaction::find($id);
            if (isset($transaction)) {

                $transaction->title = $request->title ?? $transaction->title;
                $transaction->description = $request->description ?? $transaction->description;
                $transaction->category_id = $request->category_id ?? $transaction->category_id;
                $transaction->amount = $request->amount ?? $transaction->amount;
                $transaction->currency_id = $request->currency_id ?? $transaction->currency_id;
                $transaction->date = $request->date ?? $transaction->date;
                $transaction->type = $request->type ?? $transaction->type;
                $transaction->save();

                $respond = [
                    "status" => 201,
                    "message" => "successfully updated",
                    "data" => $transaction
                ];
            } else {
                $respond = [
                    "status" => 404,
                    "message" => "id " . $id . " does not exist",
                    "data" => $transaction
                ];
            }
        }

        return response($respond);
    }

    public function delete($id)
    {
        $transaction = FixedTransaction::find($id);
        if (isset($transaction)) {
            FixedTransaction::find($id)->delete();
            $transaction = FixedTransaction::all();
            $respond = [
                "status" => 201,
                "message" => "Successfully deleted",
                "data" => $transaction
            ];
        } else {
            $respond = [
                "status" => 404,
                "message" => "id " . $id . " does not exist",
                "data" => $transaction
            ];
        }
        
        return response($respond, $respond["status"]);
    }

}
