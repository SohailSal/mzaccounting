<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Client;
use App\Account;
use App\Type;
use App\ClientType;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
//        $clients = Client::orderBy('accounts.head_of_account')->paginate(10);
        $clients = null;
        $search = null;
        if($request->input('search')){
        $clients = DB::table('accounts')
            ->join('clients', 'accounts.id', '=', 'clients.account_id')
            ->select(DB::raw("clients.*"), "accounts.head_of_account as head_of_account", "accounts.id as ac_id")
            ->where('accounts.head_of_account', 'LIKE', '%' . $request->input('search') . '%')
            ->orderBy('accounts.head_of_account')
            ->paginate(10)
            ->appends(request()->query());
        $search = $request->input('search');
        }
        else{
        $clients = DB::table('accounts')
            ->join('clients', 'accounts.id', '=', 'clients.account_id')
            ->select(DB::raw("clients.*"), "accounts.head_of_account as head_of_account", "accounts.id as ac_id")
            ->orderBy('accounts.head_of_account')
            ->paginate(10)
            ->appends(request()->query());
        }

        $types = ClientType::all();
        return view('clients.index', compact('clients','types','search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('clients.create');
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
            'name_of_client' => 'required|unique:accounts,head_of_account',
            'clienttype_id' => 'required',
        ]);

        DB::transaction(function () use ($request) {

        $account = new Account([
            'head_of_account' => $request->get('name_of_client'),
            'type_id' => '6'
        ]);

        $account->save();
        $count = $account->id;

        $client = new Client([
            'clienttype_id' => $request->get('clienttype_id'),
            'account_id' => $count,
            'address' => $request->get('address'),
            'phone' => $request->get('phone'),
            'email' => $request->get('email'),
            'person' => $request->get('person'),
            'tax' => $request->get('tax'),
            'registration' => $request->get('registration'),
            'incorporation' => $request->get('incorporation'),
        ]);

        $client->save();

        });

        return redirect('/clients')->with('success', 'New Client added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = Client::find($id);
        $type = ClientType::find($client->clienttype_id);
        return view('clients.show', compact('client','type'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $client = Client::find($id);
        return view('clients.edit', compact('client'));
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
            'name_of_client' => 'required',
            'clienttype_id' => 'required',
        ]);

        $client = Client::find($id);

        $client->clienttype_id = $request->get('clienttype_id');;
        $client->address = $request->get('address');
        $client->phone = $request->get('phone');
        $client->email = $request->get('email');
        $client->person = $request->get('person');
        $client->tax = $request->get('tax');
        $client->registration = $request->get('registration');
        $client->incorporation = $request->get('incorporation');

        $acc_id = $client->account_id;
        $account = Account::find($acc_id);
        $account->head_of_account = $request->get('name_of_client');

        DB::transaction(function () use ($client, $account) {
            $client->save();
            $account->save();
        });


        return redirect('/clients')->with('success', 'Client\'s details updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client = Client::find($id);
        $acc_id = $client->account_id;
        $account = Account::find($acc_id);
        DB::transaction(function () use ($client, $account) {
            $client->delete();
            $account->delete();
        });
        return redirect('/clients')->with('success', 'Client deleted!');
    }

    public function envelop($id)
    {
        $client = Client::find($id);
        $pdf = app('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $customPaper = array(0, 0, 684, 297);
        $pdf->setPaper($customPaper);
        $pdf->loadView('clients/envelop', compact('client'));
        return $pdf->stream($client->id . '.pdf');
    }

}
