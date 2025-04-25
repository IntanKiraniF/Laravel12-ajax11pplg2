<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; 
use App\Models\Item;

class ItemController extends Controller
{
    public function index()
    {
        return view('item', [
            'title' => 'Item',
            'url_json' => url('/items/get_data'),
            'url' => url('/items'),
        ]);
    }

    public function getData()
    {
        return response()->json([
            'status' => true,
            'data' => Item::all(),
            'message' => 'data berhasil ditemukan',
        ])->header('Content-Type', 'application/json')->setStatusCode(200);
    }

    public function storeData(Request $request)
    {
        $data = $request->only(['item_name', 'status']);

        $validator = Validator::make($data, [
            'item_name' => ['required', 'unique:items', 'min:3', 'max:255'],
            'status' => ['required', 'in:1,0'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ], 422);
        }

        Item::create($data);

        return response()->json([
            'status' => true,
            'message' => 'data berhasil ditambahkan',
        ])->header('Content-Type', 'application/json')->setStatusCode(201);
    }

    public function getDataById($idItem)
    {
        $item = Item::find($idItem); 

        if (!$item) {
            return response()->json([
                'status' => false,
                'message' => 'data tidak ditemukan',
            ])->header('Content-Type', 'application/json')->setStatusCode(404);
        }

        return response()->json([
            'status' => true,
            'data' => $item,
            'message' => 'data berhasil ditemukan',
        ])->header('Content-Type', 'application/json')->setStatusCode(200);
    }

    public function updateData(Request $request, $idItem)
    {
        $item = Item::find($idItem); 

        if (!$item) {
            return response()->json([
                'status' => false,
                'message' => 'data tidak ditemukan',
            ])->header('Content-Type', 'application/json')->setStatusCode(404);
        }

        $data = $request->only(['item_name', 'status']);

        $validator = Validator::make($data, [
            'item_name' => ['required', 'min:3', 'max:255', 'unique:items,item_name,' . $item->id],
            'status' => ['required', 'in:1,0'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ], 422);
        }

        $item->update($data);

        return response()->json([
            'status' => true,
            'message' => 'data berhasil diubah',
        ])->header('Content-Type', 'application/json')->setStatusCode(200);
    }

    public function destroyData($idItem)
    {
        $item = Item::find($idItem);

        if (!$item) {
            return response()->json([
                'status' => false,
                'message' => 'data tidak ditemukan',
            ])->header('Content-Type', 'application/json')->setStatusCode(404);
        }

        $item->delete();

        return response()->json([
            'status' => true,
            'message' => 'data berhasil dihapus',
        ])->header('Content-Type', 'application/json')->setStatusCode(200);
    }
}
