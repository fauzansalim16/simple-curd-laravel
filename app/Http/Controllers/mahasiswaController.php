<?php

namespace App\Http\Controllers;

use App\Models\mahasiswa;
use Illuminate\Http\Request;

class mahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * 
     * mengacu pada file tampilan yang ada dalam direktori resources/views/mahasiswa dengan nama file 'index.blade.php'.
     */
    public function index(Request $request)
    {
        $katakunci = $request->katakunci;
        $jumlahbaris = 3;
        if(isset($katakunci)){
            $data = mahasiswa::where('nim', 'like', "%$katakunci%" )->
            orWhere('nama', 'like',"%$katakunci%" )->
            orWhere('jurusan', 'like',"%$katakunci")->
            paginate($jumlahbaris);
        }else{
            $data = mahasiswa::orderBy('nim','desc')->paginate($jumlahbaris);
        }
        return view('mahasiswa.index')->with('data',$data);
        //mengirim data ke view dengan alias 'data'
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('mahasiswa.create');
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
            'nim'=> 'required|numeric|unique:mahasiswa,nim',
            'nama'=>'required',
            'jurusan'=>'required'
        ],[
            'nim.required'=> 'nim wajib diisi',
            'nim.numeric'=> 'nim wajib berbentuk angka',
            'nim.unique'=> 'nim sudah terdaftar',
            'nama.required'=>'nama wajib diisi',
            'jurusan.required'=>'jurusan wajib diisi'
        ]);
        $data= [
            'nim' => $request->nim,
            'nama' => $request->nama,
            'jurusan'=> $request->jurusan

        ];
        mahasiswa::create($data);
        return redirect()-> to('mahasiswa')->with('berhasil menambahkan data');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = mahasiswa::where('nim',$id)->first();
        return view('mahasiswa.edit')->with('data',$data);
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
            'nama'=>'required',
            'jurusan'=>'required'
        ],[
            'nama.required'=>'nama wajib diisi',
            'jurusan.required'=>'jurusan wajib diisi'
        ]);
        $data= [
            'nama' => $request->nama,
            'jurusan'=> $request->jurusan

        ];
        mahasiswa::where('nim',$id)->update($data);
        return redirect()-> to('mahasiswa')->with('berhasil mengedit data');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        mahasiswa::where('nim',$id)->delete(); 
        return redirect()-> to('mahasiswa')->with('berhasil menghapus data');
    }
}
