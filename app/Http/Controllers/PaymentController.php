<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Payment;
use App\Transaction;
use App\Entry;
use App\Account;
use App\Post;
use Carbon\Carbon;
use PDF;


class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments = Payment::orderBy('created_at', 'DESC')->paginate(10);
        return view('payments.index', compact('payments'));
    }

    public function indexx()
    {
        $payments = Payment::orderBy('created_at', 'DESC')->paginate(10);
        return view('payments.indexx', compact('payments'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $payment = Payment::find($id);
        return view('payments.show', compact('payment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::transaction(function () use ($id) {

            $payment = Payment::find($id);
            $transaction = Transaction::where('ref',$payment->ref)->first();
            $entries = Entry::where('transaction_id',$transaction->id)->get();

                foreach ($entries as $entry) {
                    $entry->delete();
                }
                $transaction->delete();
                $payment->delete();
            });

        return redirect('/erasePayment')->with('success', 'Payment deleted!');

    }


    public function getPayments(Request $request)
    {
        //        $start = $request->input('start');
        //      $end = $request->input('end');
        //    $client = $request->input('client');
        $payments = Payment::all();
        $pdf = app('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->loadView('payments/detail', compact('payments'))->setPaper('a4', 'landscape');
        return $pdf->stream('payments.pdf');
    }

    public function getPV($id)
    {
        $payment = Payment::find($id);
        $pdf = app('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->loadView('payments/pv', compact('payment'));
        return $pdf->stream($payment->ref.'.pdf');
    }

        public function getPaymentsRange(Request $request)
    {

        $start = $request->input('date_start');
        $end = $request->input('date_end');
//        $payments = Payment::whereDate('created_at','>=',$start)->whereDate('created_at','<=',$end)->get();
//        dd($payments);

        $payments = Payment::all()
                ->map(function ($item){
                    return [
                        'ref' => $item->ref,
                        'date_of_payment' => Carbon::parse($item->date_of_payment)->toDateString(),
                        'head_of_account' => $item->account->head_of_account,
                        'description' => $item->description,
                        'payee' => $item->payee,
                        'cheque' => $item->cheque,
                        'amount' => $item->amount,
                    ];
                })->where('date_of_payment','>=',$start)
                  ->where('date_of_payment','<=',$end);


        $period = "From ".strval($start)." to ".strval($end);
        $pdf = app('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->loadView('payments/detailrange', compact('payments','period'))->setPaper('a4', 'landscape');
        return $pdf->stream('paymentsrange.pdf');

    }

    public function getPaymentsn(Request $request)
    {
            $fmt = new \NumberFormatter( 'en_GB', \NumberFormatter::CURRENCY );
            $fmt->setAttribute(\NumberFormatter::MAX_FRACTION_DIGITS, 0);
            $fmt->setSymbol(\NumberFormatter::CURRENCY_SYMBOL, '');
//dd($fmt);
            $tZone = new \DateTimeZone("Asia/Karachi");
            $dt = \Carbon\Carbon::now($tZone)->format('M d, Y - h:m a');
//dd($dt);
            $total = 0;

            $payments = Payment::all();
        foreach ($payments as $item) {
            $total = $total + $item->amount;
        }
//dd($total);

            $paymentsn = Payment::all()->map(function($payment){
            return [
                'ref' => $payment->ref,
                'date_of_payment' => $payment->date_of_payment,
                'head_of_account' => $payment->account->head_of_account,
                'description' => $payment->description,
                'payee' => $payment->payee,
                'cheque' => $payment->cheque,
  //              'amount' => str_replace(['Rs.','.00'],'',$fmt->formatCurrency($payment->amount,'Rs.')),
                'amount' => $payment->amount,
                ];
            });

 dd($paymentsn); 
//            $total = str_replace(['Rs.','.00'],'',$fmt->formatCurrency($total,'Rs.'));

        $pdf = app('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->loadView('payments/detailn', compact('paymentsn','dt','total'))->setPaper('a4', 'landscape');
        return $pdf->stream('payments.pdf');
    }

    public function postPV($id)
    {
        $request = Post::find($id);

        DB::transaction(function () use ($request) {

            $payment = new Payment([
                'ref' => $request->ref,
                'date_of_payment' => $request->date_of_payment,
                'account_id' => $request->account_id,
                'description' => $request->description,
                'mode' => $request->mode,
                'cheque' => $request->cheque,
                'payee' => $request->payee,
                'amount' => $request->amount,
            ]);
            $payment->save();

            $transaction = new Transaction([
                'ref' => $request->ref,
                'date_of_transaction' => $request->date_of_payment,
                'description' => $request->description
            ]);

            $transaction->save();
            $count = $transaction->id;

            $entry = [];

            $entry[] = new Entry([
                'account_id' => $request->account_id,
                'transaction_id' => $count,
                'debit' => $request->amount,
                'credit' => NULL
            ]);

            if($request->mode=='2'){
            $entry[] = new Entry([
                'account_id' => '5',
                'transaction_id' => $count,
                'debit' => NULL,
                'credit' => $request->amount
            ]);
            }
            else{
            $entry[] = new Entry([
                'account_id' => '9',
                'transaction_id' => $count,
                'debit' => NULL,
                'credit' => $request->amount
            ]);
            }

                foreach ($entry as $item) {
                    $item->save();
                }

            $request->posted = '1';
            $request->save();
            });
        return redirect('/posts')->with('success', 'The Payment posted!');
    }

}
