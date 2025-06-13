<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoremenuRequest;
use App\Http\Requests\UpdatemenuRequest;
use Illuminate\Http\Request;
use App\Models\menu;
use App\Models\User;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth('sanctum')->user();
        $menu = $user ? menu::where('id_user', null)->orWhere('id_user', $user->id_user)->get() : menu::where("id_user", null)->get();
        return $menu->map(function ($menu) use ($user) {
            return [
                'id_menu' => $menu->id_menu,
                'judul' => $menu->judul,
                'kategori' => $menu->kategori,
                'asal' => $menu->asal,
                'mine' => $user && $menu->id_user === $user->id_user ? "1" : "0"
            ];
        });
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function getImage($id_buku) {
        $menu = menu::find($id_buku);

        if ($menu) {
            $path = public_path($menu->imageUrl);
            return response()->file($path);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoremenuRequest $request)
    {
        $request->validate([
            "judul" => ["required", "string", "max:255"],
            "kategori" => ["required", "string", "max:255"],
            "asal" => ["required", "string", "max:255"],
            "image" => ["required", "image"],
        ]);
        
        $image = $request->image;
        $filename = 'image_' . time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('upload'), $filename);

        $menu = menu::create([
            "judul" => $request->judul,
            "kategori" => $request->kategori,
            "asal" => $request->asal,
            "imageUrl" => "upload/$filename",
            "id_user" => $request->user()->id_user
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil menambahkan menu'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(menu $menu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(menu $menu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatemenuRequest $request, menu $menu, $id_buku)
    {
        $request->validate([
            "judul" => ["required", "string", "max:255"],
            "kategori" => ["required", "string", "max:255"],
            "asal" => ["required", "string", "max:255"],
            "image" => ["image"],
        ]);

        $menu = menu::find($id_buku);

        if (!$menu) {
            return response()->json([
                'status' => 'error',
                'message' => 'Menu tidak ditemukan',
            ]);
        }

        if ($menu->id_user != $request->user()->id_user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Menu bukan milik anda',
            ]);
        }

        $image = $request->image;
        if ($image) {
            $filename = 'image_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('upload'), $filename);
            $menu->imageUrl = "upload/$filename";
        }

        $menu->judul = $request->judul;
        $menu->kategori = $request->kategori;
        $menu->asal = $request->asal;

        $menu->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Menu berhasil diupdate',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, menu $menu, $id_buku)
    {
        $menu = menu::find($id_buku);

        if (!$menu) {
            return response()->json([
                'status' => 'error',
                'message' => 'Menu tidak ditemukan',
            ]);
        }

        if ($menu->id_user != $request->user()->id_user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Menu bukan milik anda',
            ]);
        }

        $menu->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Menu berhasil dihapus',
        ]);
    }
}
