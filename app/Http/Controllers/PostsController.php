<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\post;
use DB;

class PostsController extends Controller
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
        // $posts= post::all();
        //$post=post::all();
        //$posts= post::orderBy('title','desc')->take(1)->get();
        //$posts= DB::select('select * FROM posts');
       // $posts= post::orderBy('title','desc')->get();

        $posts= post::orderBy('name','desc')->paginate(5);
        return view('posts.index')->with('posts',$posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
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
            'name'=>'required',
            'description'=>'required',
            'price'=>'required|min:1',
            'weight'=>'required|min:1',
            'cover_image'=>'image|nullable|max:3999'
        ]);

        //upload gambar
        
        if($request->hasFile('cover_image')){
            //mengambil filename dengan ekstensi
            $fileNameWithExt = $request->file('cover_image')->getClientOriginalName();
            //get filename
            $fileName = pathinfo($fileNameWithExt,PATHINFO_FILENAME);
            //get ext
            $extension=$request->file('cover_image')->getClientOriginalExtension();
            //filename to store
            $fileNameToStore=$fileName.'_'.time().'.'.$extension;
            //upload Image
            $path=$request->file('cover_image')->storeAs('public/cover_image',$fileNameToStore);
        }else{
            $fileNameToStore='noimage.jpg';
        }


        // masuk ke database
        $post=new Post;
        $post->name=$request->input('name');
        $post->description=$request->input('description');
        $post->price=$request->input('price');
        $post->weight=$request->input('weight');
        $post->cover_image=$fileNameToStore;
        $post->save();

        return redirect('/posts')->with('success','Produk ditambahkan');
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
        return view('posts.show')->with('posts',$posts);
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
        $posts=post::find($id);
        return view('posts.edit')->with('posts',$posts);
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
        
        $this->validate($request,[
            'name'=>'required',
            'description'=>'required',
            'price'=>'required|min:1',
            'weight'=>'required|min:1',
        ]);

          //upload gambar
        
          if($request->hasFile('cover_image')){
            //mengambil filename dengan ekstensi
            $fileNameWithExt = $request->file('cover_image')->getClientOriginalName();
            //get filename
            $fileName = pathinfo($fileNameWithExt,PATHINFO_FILENAME);
            //get ext
            $extension=$request->file('cover_image')->getClientOriginalExtension();
            //filename to store
            $fileNameToStore=$fileName.'_'.time().'.'.$extension;
            //upload Image
            $path=$request->file('cover_image')->storeAs('public/cover_image',$fileNameToStore);
        }
        
        // masuk ke database
        $post= post::find($id);
        $post->name=$request->input('name');
        $post->description=$request->input('description');
        $post->price=$request->input('price');
        $post->weight=$request->input('weight');
        if($request->hasFile('cover_image')){
            $post->cover_image=$fileNameToStore;
        }
        $post->save();

        return redirect('/posts')->with('success','Produk Berhasil diperbaharui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $post= Post::find($id);
        if($post->cover_image != 'noimage.jpg'){
            //hapus gambar
            Storage::delete('public/cover_image/'.$post->cover_image);
        }

        $post->delete();
        return redirect('/posts')->with('success','Produk berhasil dihapus');
    }
}
