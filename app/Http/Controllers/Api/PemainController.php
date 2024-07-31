<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pemain;
use Validator;
use Storage;
use Illuminate\Http\Request;

class PemainController extends Controller
{
    public function index()
    {
        $pemain = Pemain::latest()->get();
        $res = [
            'success'=> true,
            'message'=> 'Daftar Pemain Sepak Bola',
            'data'=> $pemain,
        ];
        return response()->json($res, 200);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'nama_pemain' =>'required',
            'foto' => 'required|image|mimes:png,jpg',
            'tgl_lahir' => 'required',
            'harga_pasar' => 'required|numeric',
            'posisi' => 'required',
            'negara' => 'required',
            'id_klub' => 'required',
        ]);
        if($validate->fails()){
            return response()->json([
                'success' =>false,
                'message' =>'data tidak valid!',
                'errors' => $validate->errors(),
            ], 422);
        }

        try {
            $path = $request->file('foto')->store('public/foto'); // upload image
            $pemain = New Pemain;
            $pemain->nama_pemain = $request->nama_pemain;
            $pemain->foto = $path;
            $pemain->tgl_lahir = $request->tgl_lahir;
            $pemain->harga_pasar = $request->harga_pasar;
            $pemain->posisi = $request->posisi;
            $pemain->negara = $request->negara;
            $pemain->id_klub = $request->id_klub;
            $pemain->save();
            return response()->json([
                'success' =>true,
                'message' =>'data pemain berhasil dibuat',
                'data' => $pemain,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' =>false,
                'message' =>'terjadi kesalahan',
                'errors' => $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        try{
            $pemain = Pemain::findOrFail($id);
            return response()->json([
                'success' =>true,
                'message' =>'Detail Pemain',
                'data' => $pemain,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' =>false,
                'message' =>'data tidak ditemukan!',
                'errors' => $e->getMessage(),
            ], 404);
        }
    }
    public function update(Request $request, $id)
    {
          $validate = Validator::make($request->all(), [
            'nama_pemain' => 'required|unique:pemains',
            'foto' => 'required|image|max:2048',
            'tanggal_lahir' => 'required',
            'harga_pasar' => 'required',
            'posisi' => 'required|in:gk,df,mf,fw',
            'negara' => 'required',
            'id_klub' => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi Gagal',
                'data' => $validate->errors(),
            ], 422);
        }

        try {
            $path = $request->file('foto')->store('public/foto'); //menyimpan gambar
            $pemain = Pemain::findOrFail($id);
            $pemain->nama_pemain = $request->nama_pemain;
            $pemain->foto = $path;
            $pemain->tanggal_lahir = $request->tanggal_lahir;
            $pemain->harga_pasar = $request->harga_pasar;
            $pemain->posisi = $request->posisi;
            $pemain->negara = $request->negara;
            $pemain->id_klub = $request->id_klub;
            $pemain->save();

            return response()->json([
                'success' => true,
                'message' => 'Data Berhasil Dibuat',
                'data' => $pemain,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi Kesalahan',
                'errors' => $e->getMessage(),
            ], 500);
        }

    }
    public function destroy($id)
    {
        try{
            $pemain = Pemain::findOrFail($id);
            Storage::delete($pemain->foto);
            $pemain->delete();
            return response()->json([
                'success' => true,
                'message' => 'Data ' . $pemain->nama_klub . ' berhasil dihapus',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' =>false,
                'message' =>'data tidak ditemukan!',
                'errors' => $e->getMessage(),
            ], 404);
        }
    }

}
