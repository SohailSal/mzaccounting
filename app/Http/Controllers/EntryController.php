<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Entry;
use App\Account;
use App\Exports\EntryExport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class EntryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $entries = Entry::orderBy('created_at', 'DESC')->paginate(10);
        return view('entries.index',compact('entries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('entries.create');
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
            'account_id' => 'required',
            'transaction_id' => 'required',
            'debit' => 'required_without:credit',
            'credit' => 'required_without:debit'
        ]);

        if ($request->get('debit')!=Null && $request->get('credit') != Null)
        return redirect()->back()->withErrors(['Enter either Debit amount or Credit amount...not both!']);

        $entry = new Entry([
            'account_id' => $request->get('account_id'),
            'transaction_id' => $request->get('transaction_id'),
            'debit' => $request->get('debit'),
            'credit' => $request->get('credit')
        ]);

        $entry->save();
        return redirect('/entries')->with('success', 'New Entry entered!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $entry = Entry::find($id);
        return view('entries.show', compact('entry'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $entry = Entry::find($id);
        return view('entries.edit', compact('entry'));
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
        $request->validate([
            'account_id' => 'required',
            'transaction_id' => 'required',
            'debit' => 'required_without:credit',
            'credit' => 'required_without:debit'
        ]);
        $entry = Entry::find($id);
        $entry->account_id =  $request->get('account_id');
        $entry->transaction_id = $request->get('transaction_id');
        $entry->debit = $request->get('debit');
        $entry->credit = $request->get('credit');
        $entry->save();
        return redirect('/entries')->with('success', 'Entry updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $entry = Entry::find($id);
        $entry->delete();
        return redirect('/entries')->with('success', 'Entry deleted!');
    }

    public function export()
    {
        return Excel::download(new EntryExport, 'entries.xlsx');
    }

    public function getTrial()
    {
        $pdf = app('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->loadView('entries/trial');
        return $pdf->stream('trialbalance.pdf');
    }

    public function clientBal()
    {
        $pdf = app('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->loadView('entries/clientbal');
        return $pdf->stream('clientbal.pdf');
    }

    public function getLed(Request $request)
    {
        $start = $request->input('date_start');
        $end = $request->input('date_end');
        $account = $request->input('account_id');
        $entries = Entry::whereDate('created_at','>=',$start)->whereDate('created_at','<=',$end)->where('account_id','=',$account)->get();
        $previous = Entry::whereDate('created_at','<',$start)->where('account_id','=',$account)->get();
        $acc = Account::where('id','=',$account)->first();
        $period = "From ".strval($start)." to ".strval($end);
        $pdf = app('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->loadView('entries/led', compact('entries','previous','acc','period'));
        return $pdf->stream('led.pdf');
    }
}
