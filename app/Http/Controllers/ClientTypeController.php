<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ClientType;
use PDF;

class ClientTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clienttypes = ClientType::all();
        return view('clienttypes.index', compact('clienttypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('clienttypes.create');
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
            'type_of_client' => 'required',
        ]);

        $clienttype = new ClientType([
            'type_of_client' => $request->get('type_of_client'),
        ]);

        $clienttype->save();
        return redirect('/clienttypes')->with('success', 'New Type of Client entered!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $clienttype = ClientType::find($id);
        return view('clienttypes.show', compact('clienttype'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $clienttype = ClientType::find($id);
        return view('clienttypes.edit', compact('clienttype'));
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
            'type_of_client' => 'required',
        ]);
        $clienttype = ClientType::find($id);
        $clienttype->type_of_client =  $request->get('type_of_client');
        $clienttype->save();
        return redirect('/clienttypes')->with('success', 'Type updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $clienttype = ClientType::find($id);
        $clienttype->delete();
        return redirect('/clienttypes')->with('success', 'Type deleted!');
    }

}
