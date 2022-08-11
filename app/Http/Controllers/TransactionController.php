<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Transaction;
use Carbon\Carbon;
use App\Entry;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $transactions = Transaction::where('ref','like','%JV%')->orderBy('created_at', 'DESC')->paginate(15);
       return view('transactions.index', compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $offset = 5 * 60 * 60;
        $dateFormat = "d-m-Y:H:i";
        $timeNdate = gmdate($dateFormat, (time() + $offset));

        $inv = "";
        $record = Transaction::where('ref','like','%JV%')->latest()->first();
        $expNum = [];
        if ($record) {
            $expNum = explode('/', $record->ref);
        }
        $dateInfo = date_parse_from_format('d-m-Y:H:i', $timeNdate);

        if (!$record) {
            $inv = 'MZ/JV/' . $dateInfo['year'] . '/' . $dateInfo['month'] . '/1';
//        } elseif (($dateInfo['year'] - $expNum[2]) > 0) {
//            $inv = 'MZ/JV/' . $dateInfo['year'] . '/' . $dateInfo['month'] . '/1';
        } else {
            $inv = 'MZ/JV/' . $dateInfo['year'] . '/' . $dateInfo['month'] . '/' . ($expNum[4] + 1);
        }

        return view('transactions.create', compact('inv'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'ref' => 'required',
            'date_of_transaction' => 'required',
            'description' => 'required'
        ]);

        DB::transaction(function () use ($request) {

            $transaction = new Transaction([
                    'ref' => $request->get('ref'),
                    'date_of_transaction' => $request->get('date_of_transaction'),
                    'description' => $request->get('description')
            ]);

            $transaction->save();

            $count = $transaction->id;

            $entries = [];
            $account_id = $request->get('account_id');
            $debit = $request->get('debit');
            $credit = $request->get('credit');
            $num = count($debit);

            for($i=0;$i<$num;$i++){
                $entries[] = new Entry([
                    'account_id' => $account_id[$i],
                    'transaction_id' => $count,
                    'debit' => $debit[$i],
                    'credit' => $credit[$i]
                ]);
            }

            foreach ($entries as $entry) {
                $entry->save();
                }

            });

        return redirect('/transactions')->with('success', 'New Transaction entered!');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $transaction = Transaction::find($id);
        return view('transactions.show', compact('transaction'));
    }

    public function edit($id)
    {
        $transaction = Transaction::find($id);
        return view('transactions.edit', compact('transaction'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'date_of_transaction' => 'required',
        ]);

        DB::transaction(function () use ($request, $id) {
            $transaction = Transaction::find($id);
            $transaction->date_of_transaction =  $request->get('date_of_transaction');
            $transaction->save();
        });

        return redirect('/transactions')->with('success', 'Transaction updated!');
    }

    public function destroy($id)
    {

    }
}
