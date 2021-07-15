<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Receipt;
use App\Transaction;
use App\Entry;
use App\InvoiceEntry;
use App\Account;
use App\Invoice;
use Carbon\Carbon;
use PDF;

class ReceiptController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $receipts = Receipt::orderBy('created_at', 'DESC')->paginate(10);
        return view('receipts.index', compact('receipts'));
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
        $record = Receipt::latest()->first();
        $expNum = [];
        if ($record)
        {
            $expNum = explode('/', $record->ref);
        }
        $dateInfo = date_parse_from_format('d-m-Y:H:i', $timeNdate);

        if (!$record) {
            $inv = 'MZ/RV/' . $dateInfo['year'] . '/' . $dateInfo['month'] . '/1';
//        } elseif (($dateInfo['year'] - $expNum[2]) > 0) {
//            $inv = 'MZ/RV/' . $dateInfo['year'] . '/' . $dateInfo['month'] . '/1';
        } else {
            $inv = 'MZ/RV/' . $dateInfo['year'] . '/' . $dateInfo['month'] . '/' . ($expNum[4] + 1);
        }

        return view('receipts.create', compact('inv'));
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
            'date_of_receipt' => 'required',
            'invoice_id' => 'required',
            'account_id' => 'required',
            'description' => 'required',
            'amount' => 'required'
        ]);
        DB::transaction(function () use ($request) {

            $receipt = new Receipt([
                'ref' => $request->get('ref'),
                'date_of_receipt' => $request->get('date_of_receipt'),
                'invoice_id' => $request->get('invoice_id'),
                'account_id' => $request->get('account_id'),
                'description' => $request->get('description'),
                'amount' => $request->get('amount'),
                'itax' => $request->get('itax'),
                'stax' => $request->get('stax'),
            ]);
            $receipt->save();

            $transaction = new Transaction([
                'ref' => $request->get('ref'),
                'date_of_transaction' => $request->get('date_of_receipt'),
                'description' => $request->get('description')
            ]);

            $transaction->save();
            $count = $transaction->id;

            $entry = [];
            $entry[] = new Entry([
                'account_id' => '5',
                'transaction_id' => $count,
                'debit' => $request->get('amount'),
                'credit' => NULL
            ]);

            $entry[] = new Entry([
                'account_id' => $request->get('account_id'),
                'transaction_id' => $count,
                'debit' => NULL,
                'credit' => $request->get('gross')
            ]);

            if (!($request->get('itax') == "0"))
            $entry[] = new Entry([
                'account_id' => '26',
                'transaction_id' => $count,
                'debit' => $request->get('itax'),
                'credit' => NULL
            ]);

            if (!($request->get('stax') == "0"))
            $entry[] = new Entry([
                'account_id' => '27',
                'transaction_id' => $count,
                'debit' => $request->get('stax'),
                'credit' => NULL
            ]);

            foreach ($entry as $item) {
                $item->save();
            }

            $invoice = Invoice::find($request->get('invoice_id'));
            $invoice->paid = '1';
            $invoice->save();

            });

        return redirect('/receipts')->with('success', 'New Receipt entered!');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $receipt = Receipt::find($id);
        return view('receipts.show', compact('receipt'));
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
    }

    public function findInvoices($id)
    {
        /*    $invoices = Invoice::where('account_id', $id)->get();
  *    $invoices =   DB::select('select invoices.ref, invoices.date_of_invoice from invoices where invoices.account_id = ?', [$id]);
*/
        $invoices = DB::table('invoices')
            ->join('invoice_entries', 'invoices.id', '=', 'invoice_entries.invoice_id')
            ->where('invoices.account_id', '=', $id)
            ->where('invoices.paid', '=', '0')
            ->select('invoices.*', 'invoice_entries.amount')
            ->where('invoice_entries.description','=','Total')
            ->get();

      return response()->json($invoices);

    }

    public function getReceipts(Request $request)
    {
        //        $start = $request->input('start');
        //      $end = $request->input('end');
        //    $client = $request->input('client');
        $receipts = Receipt::all();
        $pdf = app('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->loadView('receipts/detail', compact('receipts'));
        return $pdf->stream('receipts.pdf');
    }

    public function getReceiptsRange(Request $request)
    {

        $start = $request->input('date_start');
        $end = $request->input('date_end');
//        $receipts = Receipt::whereDate('created_at','>=',$start)->whereDate('created_at','<=',$end)->get();

        $receipts = Receipt::all()
                ->map(function ($item){
                    return [
                        'ref' => $item->ref,
                        'date_of_receipt' => Carbon::parse($item->date_of_receipt)->toDateString(),
                        'head_of_account' => $item->account->head_of_account,
                        'amount' => $item->amount,
                        'itax' => $item->itam,
                        'stax' => $item->stax,
                    ];
                })->where('date_of_receipt','>=',$start)
                  ->where('date_of_receipt','<=',$end);

        $period = "From ".strval($start)." to ".strval($end);
        $pdf = app('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->loadView('receipts/detailrange', compact('receipts','period'));
        return $pdf->stream('receiptsrange.pdf');

    }

}
