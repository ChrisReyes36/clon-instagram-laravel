<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function save(Request $request)
    {
        // Validar los datos recibidos
        $validate = $this->validate($request, [
            'image_id' => ['required', 'integer'],
            'content' => ['required', 'string'],
        ]);

        // Recoger los datos
        $content = $request->input('content');
        $image_id = $request->input('image_id');
        $user_id = Auth::user()->id;

        // Asignar los valores al objeto de la base de datos
        $comment = new Comment;
        $comment->content = $content;
        $comment->user_id = $user_id;
        $comment->image_id = $image_id;

        // Guardar en la base de datos
        $comment->save();

        return redirect()->route('image.detail', ['id' => $request->image_id])->with([
            'message' => 'Comentario añadido correctamente'
        ]);
    }

    public function delete($id)
    {
        // Conseguir el comentario
        $comment = Comment::find($id);

        // Comprobar si el comentario existe
        if (is_null($comment)) {
            return redirect()->route('home')->with([
                'message' => 'El comentario no existe'
            ]);
        }

        // Comprobar si el usuario autenticado es el dueño del comentario
        if ($comment->user_id == Auth::user()->id || $comment->image->user_id == Auth::user()->id) {
            // Eliminar el comentario
            $comment->delete();
        } else {
            return redirect()->route('image.detail', ['id' => $comment->image_id])->with([
                'message' => 'Comentario no ha sido eliminado'
            ]);
        }


        return redirect()->route('image.detail', ['id' => $comment->image_id])->with([
            'message' => 'Comentario eliminado correctamente'
        ]);
    }
}
