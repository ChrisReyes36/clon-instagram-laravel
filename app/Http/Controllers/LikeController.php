<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Image;
use App\Models\Like;

class LikeController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        $likes = Like::where('user_id', $user->id)->orderBy('id', 'desc')->paginate(5);

        return view('like.index', [
            'likes' => $likes
        ]);
    }

    public function like($image_id)
    {
        // Conseguir usuario identificado
        $user = Auth::user();

        // Comprobar si ya existe el like
        $exist = Like::where('user_id', $user->id)
            ->where('image_id', $image_id)
            ->count();

        if ($exist == 0) {
            // Objeto like
            $like = new Like();
            $like->user_id = $user->id;
            $like->image_id = (int) $image_id;

            // Guardar
            $like->save();

            // Contador de likes
            $counter = Like::where('image_id', $image_id)->count();

            return response()->json([
                'like' => $like,
                'message' => 'Has dado like correctamente',
                'counter' => $counter
            ]);
        } else {
            return response()->json([
                'message' => 'El like ya existe'
            ]);
        }
    }

    public function dislike($image_id)
    {
        // Conseguir usuario identificado
        $user = Auth::user();

        // Comprobar si ya existe el like
        $like = Like::where('user_id', $user->id)
            ->where('image_id', $image_id)
            ->first();

        if ($like) {
            // Borrar
            $like->delete();

            // Contador de likes
            $counter = Like::where('image_id', $image_id)->count();

            return response()->json([
                'like' => $like,
                'message' => 'Has dado dislike correctamente',
                'counter' => $counter
            ]);
        } else {
            return response()->json([
                'message' => 'El like no existe'
            ]);
        }
    }
}
