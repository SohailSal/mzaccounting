<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Invoice;
use App\InvoiceEntry;
use App\Transaction;
use App\Entry;
use App\Account;
use Carbon\Carbon;
use PDF;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $invoices = null;
        $search = null;
        if($request->input('search')){
            $account = null;
            $id = null;
            if(Account::where('head_of_account', 'LIKE', '%' . $request->input('search') . '%')->first()) {
                $account = Account::where('head_of_account', 'LIKE', '%' . $request->input('search') . '%')->first();
                $id = $account->id;
            }
            $invoices = Invoice::where('ref', 'LIKE', '%' . $request->input('search') . '%')->orWhere('account_id', '=', $id )->orderBy('created_at', 'DESC')->paginate(10)->appends(request()->query());
            $search = $request->input('search');
        }
        else{
            $invoices = Invoice::orderBy('created_at', 'DESC')->paginate(10)->appends(request()->query());
        }
        return view('invoices.index', compact('invoices','search'));
    }

    public function create()
    {
        $offset = 5 * 60 * 60;
        $dateFormat = "d-m-Y:H:i";
        $timeNdate = gmdate($dateFormat, (time() + $offset));

        $inv = "";
        $record = Invoice::latest()->first();
        $expNum = [];
        if ($record)
        {
            $expNum = explode('/', $record->ref);
        }
        $dateInfo = date_parse_from_format('d-m-Y:H:i', $timeNdate);

        if (!$record) {
            $inv = 'MZ/INV/' . $dateInfo['year'] . '/' . $dateInfo['month'] . '/1';
        }
//        elseif (($dateInfo['year'] - $expNum[2])>0) {
//            $inv = 'MZ/INV/' . $dateInfo['year'] . '/' . $dateInfo['month'] . '/1';
//        }
        else {
            $inv = 'MZ/INV/' . $dateInfo['year'] .'/'.$dateInfo['month'].'/'. ($expNum[4] + 1);
        }


        return view('invoices.create', compact('inv'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ref' => 'required',
            'date_of_invoice' => 'required',
            'account_id' => 'required',
            'description.*' => 'required'
        ]);

        DB::transaction(function () use ($request) {

            $invoice= new Invoice([
            'ref' => $request->get('ref'),
            'date_of_invoice' => $request->get('date_of_invoice'),
            'account_id' => $request->get('account_id')
            ]);

            $invoice->save();
            $count = $invoice->id;

            $account = Account::where('id', $request->get('account_id'))->first();
            $desc = 'Invoice to '. $account->head_of_account;

            $entries = [];
            $description = $request->get('description');
            $amount = $request->get('amount');

            $num = count($description);
            for ($i = 0; $i < $num; $i++) {
            $entries[] = new InvoiceEntry([
                'invoice_id' => $count,
                'description' => $description[$i],
            'amount' => $amount[$i]
            ]);
            }

            if(!($request->get('amountoop')=="0"))
            $entries[] = new InvoiceEntry([
                'invoice_id' => $count,
                'description' => $request->get('pocket'),
                'amount' => $request->get('amountoop')
            ]);

            if (!($request->get('amountst') == ""))
            $entries[] = new InvoiceEntry([
                'invoice_id' => $count,
                'description' => $request->get('salestax'),
                'amount' => $request->get('amountst')
            ]);

            if (!($request->get('amounttotal') == ""))
            $entries[] = new InvoiceEntry([
                'invoice_id' => $count,
                'description' => $request->get('total'),
                'amount' => $request->get('amounttotal')
            ]);

            foreach ($entries as $entry) {
                $entry->save();
            }

            $transaction = new Transaction([
                'ref' => $request->get('ref'),
                'date_of_transaction' => $request->get('date_of_invoice'),
                'description' => $desc
            ]);

            $transaction->save();

            $count = $transaction->id;

            $entry1 = new Entry([
                'account_id' => $request->get('account_id'),
                'transaction_id' => $count,
                'debit' => $request->get('amounttotal'),
                'credit' => NULL
            ]);

            $entry1->save();

            $entry2 = new Entry([
                'account_id' => $request->get('income_id'),
                'transaction_id' => $count,
                'debit' => NULL,
                'credit' => $request->get('amounttotal')
            ]);

            $entry2->save();

           });

           return redirect('/invoices')->with('success', 'New Invoice entered!');
    }

    public function show($id)
    {
        $invoice = Invoice::find($id);
        return view('invoices.show', compact('invoice'));
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
        $invoice = Invoice::find($id);
        if($invoice->paid =='0')
        {$invoice->paid='1';}
        else {
            $invoice->paid='0';
        }
        $invoice->save();

        return view('invoices.show', compact('invoice'));
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {

            $invoice = Invoice::find($id);
            $invoiceentries = InvoiceEntry::where('invoice_id',$id)->get();
            $transaction = Transaction::where('ref',$invoice->ref)->first();
            $entries = Entry::where('transaction_id',$transaction->id)->get();


                foreach ($invoiceentries as $entry) {
                    $entry->delete();
                }

                foreach ($entries as $entry) {
                    $entry->delete();
                }
                $transaction->delete();
                $invoice->delete();
            });

        return redirect('/invoices')->with('success', 'Invoice deleted!');

    }

    public function downloadPDF($id)
    {
        $invoice = Invoice::find($id);
        $pdf = app('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->loadView('invoices/invoice', compact('invoice'));
        return $pdf->stream($invoice->ref.'.pdf');
    }

    public function unpaid()
    {
//        $invoices = Invoice::where('paid','=','0')->get();
        $pdf = app('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
//        $pdf->loadView('invoices/unpaid', compact('invoices'));
        $pdf->loadView('invoices/unpaid');
        return $pdf->stream('unpaid.pdf');
    }
}
