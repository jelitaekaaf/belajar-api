<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Klub;
use Validator;
use Illuminate\Http\Request;

class KlubController extends Controller
{
    public function index()
    {
        $klub = Klub::latest()->get();
        $res = [
            'success'=> true,
            'message'=> 'Daftar Klub Sepak Bola',
            'data'=> $klub,
        ];
        return response()->json($res, 200);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'nama_klub' =>'required|unique:klubs',
            'logo' => 'required',
            'id_liga' => 'required',
        ]);
        if($validate->fails()){
            return response()->json([
                'success' =>false,
                'message' =>'validasi gagal',
                'errors' => $validate->errors(),
            ], 422);
        }

        try {
            $klub = New Klub;
            $klub->nama_klub = $request->nama_klub;
            $klub->logo = $request->logo;
            $klub->id_liga = $request->id_liga;
            $klub->save();
            return response()->json([
                'success' =>true,
                'message' =>'data klub berhasil dibuat',
                'data' => $klub,
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
            $klub = Klub::findOrFail($id);
            return response()->json([
                'success' =>true,
                'message' =>'Detail Klub',
                'data' => $klub,
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
            'nama_klub' =>'required',
            'logo' => 'required',
            'id_liga' => 'required',
        ]);
        if($validate->fails()){
            return response()->json([
                'success' =>false,
                'message' =>'validasi gagal',
                'errors' => $validate->errors(),
            ], 422);
        }

        try {
            $klub = Klub::findOrFail($id);
            $klub->nama_klub = $request->nama_klub;
            $klub->logo = $request->logo;
            $klub->id_liga = $request->id_liga;
            $klub->save();
            return response()->json([
                'success' =>true,
                'message' =>'data klub berhasil dirubah',
                'data' => $klub,
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
            $klub = Klub::findOrFail($id);
            $klub->delete();
            return response()->json([
                'success' =>true,
                'message' =>'Data '. $klub->nama_klub .  'berhasil dihapus',
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
