<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pemain;
use Validator;
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
            'nama_pemain' =>'required|unique:pemains',
            'foto' => 'required',
            'tgl_lahir' => 'required',
            'harga_pasar' => 'required',
            'posisi' => 'required',
            'negara' => 'required',
            'id_klub' => 'required',
        ]);
        if($validate->fails()){
            return response()->json([
                'success' =>false,
                'message' =>'validasi gagal',
                'errors' => $validate->errors(),
            ], 422);
        }

        try {
            $pemain = New Pemain;
            $pemain->nama_pemain = $request->nama_pemain;
            $pemain->foto = $request->foto;
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
            'nama_pemain' =>'required',
            'foto' => 'required',
            'tgl_lahir' => 'required',
            'harga_pasar' => 'required',
            'posisi' => 'required',
            'negara' => 'required',
            'id_klub' => 'required',
        ]);
        if($validate->fails()){
            return response()->json([
                'success' =>false,
                'message' =>'validasi gagal',
                'errors' => $validate->errors(),
            ], 422);
        }

        try {
            $pemain = Pemain::findOrFail($id);
            $pemain->nama_pemain = $request->nama_pemain;
            $pemain->foto = $request->foto;
            $pemain->tgl_lahir = $request->tgl_lahir;
            $pemain->harga_pasar = $request->harga_pasar;
            $pemain->posisi = $request->posisi;
            $pemain->negara = $request->negara;
            $pemain->id_klub = $request->id_klub;
            $pemain->save();
            return response()->json([
                'success' =>true,
                'message' =>'data pemain berhasil dirubah',
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

    public function destroy($id)
    {
        try{
            $pemain = Pemain::findOrFail($id);
            $pemain->delete();
            return response()->json([
                'success' =>true,
                'message' =>'Data '. $pemain->nama_pemain . 'berhasil dihapus',
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
