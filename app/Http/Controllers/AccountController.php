<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Transaction;
use App\Entry;
use App\Account;
use PDF;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accounts = Account::orderBy('head_of_account')->paginate(10);
        return view('accounts.index', compact('accounts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('accounts.create');
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
            'head_of_account' => 'required|unique:accounts,head_of_account',
            'type_id' => 'required',
        ]);

        $account = new Account([
            'head_of_account' => $request->get('head_of_account'),
            'type_id' => $request->get('type_id')
        ]);

        $account->save();
        return redirect('/accounts')->with('success', 'New Head of Account entered!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $account = Account::find($id);
        return view('accounts.show', compact('account'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $account = Account::find($id);
        return view('accounts.edit', compact('account'));
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
            'head_of_account' => 'required',
            'type_id' => 'required',
        ]);
        $account = Account::find($id);
        $account->head_of_account =  $request->get('head_of_account');
        $account->type_id = $request->get('type_id');
        $account->save();
        return redirect('/accounts')->with('success', 'Head of Account updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $account = Account::find($id);
        $account->delete();
        return redirect('/accounts')->with('success', 'Head of Account deleted!');
    }


    public function getLedger2($id)
    {
        $account = Account::find($id);
        $pdf = app('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->loadView('accounts/account', compact('account'));
        return $pdf->stream($account->head_of_account . '.pdf');
    }
}
