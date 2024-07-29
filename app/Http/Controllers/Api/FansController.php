<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Fan;
use Validator;
use Illuminate\Http\Request;

class FansController extends Controller
{
    public function index()
    {
        $fans = Fan::latest()->get();
        $res = [
            'success'=> true,
            'message'=> 'Daftar Fans Sepak Bola',
            'data'=> $fans,
        ];
        return response()->json($res, 200);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'nama_fan' =>'required|unique:fans',
           
        ]);
        if($validate->fails()){
            return response()->json([
                'success' =>false,
                'message' =>'validasi gagal',
                'errors' => $validate->errors(),
            ], 422);
        }

        try {
            $fans = New Fan;
            $fans->nama_fan = $request->nama_fan;
            $fans->save();
            return response()->json([
                'success' =>true,
                'message' =>'data Fans berhasil dibuat',
                'data' => $fans,
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
            $fans = Fan::findOrFail($id);
            return response()->json([
                'success' =>true,
                'message' =>'Detail Fans',
                'data' => $fans,
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
            'nama_fan' =>'required',    
        ]);
        if($validate->fails()){
            return response()->json([
                'success' =>false,
                'message' =>'validasi gagal',
                'errors' => $validate->errors(),
            ], 422);
        }

        try {
            $fans = Fan::findOrFail($id);
            $fans->nama_fan = $request->nama_fan;
            $fans->save();
            return response()->json([
                'success' =>true,
                'message' =>'data fans berhasil dirubah',
                'data' => $fans,
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
            $fans = Fan::findOrFail($id);
            $fans->delete();
            return response()->json([
                'success' =>true,
                'message' =>'Data '. $fans->nama_fan . 'berhasil dihapus',
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
