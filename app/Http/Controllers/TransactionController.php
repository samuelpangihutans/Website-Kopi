<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\post;
use App\transaction;
use App\User;
use DB;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id=auth()->user()->id;
        $products=DB::table('transaction')->join('posts','transaction.id_produk','=','posts.id')->select('transaction.id','id_produk','jumlah','name','description','price','weight','cover_image','transaction.created_at')->where('id_user','=',$user_id)->where('status','=','0')->orderBy('created_at','asc')->paginate(3);
        return view('transaction.cart')->with('products',$products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $this->validate($request,[
            'jumlah'=>'required|min:1',
        ]);
        $transaction=new transaction;
        $transaction->jumlah=$request->input('jumlah');
        $transaction->id_user=auth()->user()->id;
        $transaction->id_produk=$request->input('id_produk');
        $transaction->save();

        return redirect('/')->with('success','Produk ditambahkan ke dalam cart');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $posts=post::find($id);
        return view('Transaction.show')->with('posts',$posts);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
        $transaction= transaction::find($id);
        $transaction->status=1;
        $transaction->save;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $transaction=transaction::find($id);
        $transaction->delete();
        return redirect('/cart')->with('success','Produk berhasil dihapus dari cart');
    }
}
