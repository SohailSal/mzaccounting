<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Payment;
use App\Transaction;
use App\Entry;
use App\Account;
use App\Post;
use PDF;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('created_at', 'ASC')->where('posted','0')->paginate(10);
        return view('posts.index', compact('posts'));
    }

    public function indexx()
    {
        $posts = Post::orderBy('created_at', 'ASC')->where('posted','0')->paginate(10);
        return view('posts.indexx', compact('posts'));
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
        $record = Post::latest()->first();
        if(!$record){
        $record = Payment::latest()->first();
        }
        $expNum = [];
        if ($record) {
            $expNum = explode('/', $record->ref);
        }
        $dateInfo = date_parse_from_format('d-m-Y:H:i', $timeNdate);

        if (!$record) {
            $inv = 'MZ/PV/' . $dateInfo['year'] . '/' . $dateInfo['month'] . '/1';
//        } elseif (($dateInfo['year'] - $expNum[2]) > 0) {
//            $inv = 'MZ/PV/' . $dateInfo['year'] . '/' . $dateInfo['month'] . '/1';
        } else {
            $inv = 'MZ/PV/' . $dateInfo['year'] . '/' . $dateInfo['month'] . '/' . ($expNum[4] + 1);
        }

        return view('posts.create', compact('inv'));
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
            'date_of_payment' => 'required',
            'account_id' => 'required',
            'description' => 'required',
            'mode' => 'required',
            'amount' => 'required'
        ]);

        DB::transaction(function () use ($request) {

            $post = new Post([
                'ref' => $request->get('ref'),
                'date_of_payment' => $request->get('date_of_payment'),
                'account_id' => $request->get('account_id'),
                'description' => $request->get('description'),
                'mode' => $request->get('mode'),
                'cheque' => $request->get('cheque'),
                'payee' => $request->get('payee'),
                'amount' => $request->get('amount'),
            ]);
            $post->save();
        });

        return redirect('/posts')->with('success', 'New Unposted Payment recorded!');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        return view('posts.show', compact('post'));
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
            $post = Post::find($id);
            $post->delete();
            });

            return redirect('/erasePost')->with('success', 'Unposted entry deleted!');
    }

    public function getUPV($id)
    {
        $post = Post::find($id);
        $pdf = app('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->loadView('posts/upv', compact('post'));
        return $pdf->stream($post->ref.'.pdf');
    }

}
