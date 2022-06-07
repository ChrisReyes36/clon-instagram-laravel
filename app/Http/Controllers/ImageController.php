<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Image;

class ImageController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        return view('image.create');
    }

    public function save(Request $request)
    {
        // Validar los datos recibidos
        $validate = $this->validate($request, [
            'description' => ['required'],
            'image_path' => ['required', 'mimes:jpg,jpeg,png,gif'],
        ]);
        // Recoger datos
        $image_path = $request->file('image_path');
        $description = $request->input('description');


        // Asignar valores al objeto image
        $image = new Image();
        $image->user_id = Auth::user()->id;
        $image->description = $description;

        // Subir imagen
        if ($image_path) {
            $image_path_name = time() . $image_path->getClientOriginalName();
            Storage::disk('images')->put($image_path_name, File::get($image_path));
            $image->image_path = $image_path_name;
        }

        // Guardar en la BD
        $image->save();

        return redirect()->route('home')->with([
            'message' => 'La imagen se ha subido correctamente'
        ]);
    }

    public function getImage($filename)
    {
        $file = Storage::disk('images')->get($filename);
        return new Response($file, 200);
    }

    public function delete($id)
    {
        $user = Auth::user();
        $image = Image::find($id);

        if ($user && $image && $image->user_id == $user->id) {
            $image_path = $image->image_path;
            Storage::disk('images')->delete($image_path);
            $image->delete();
            return redirect()->route('home')->with([
                'message' => 'La imagen se ha borrado correctamente'
            ]);
        } else {
            return redirect()->route('home')->with([
                'message' => 'La imagen no se ha borrado'
            ]);
        }
    }

    public function edit($id)
    {
        $user = Auth::user();
        $image = Image::find($id);

        if ($user && $image && $image->user_id == $user->id) {
            return view('image.edit', [
                'image' => $image
            ]);
        } else {
            return redirect()->route('home');
        }
    }

    public function update(Request $request)
    {
        // Validar los datos recibidos
        $validate = $this->validate($request, [
            'description' => ['required'],
        ]);

        // Recoger datos
        $image_path = $request->file('image_path');
        $description = $request->input('description');
        $id = $request->input('id');

        // Asignar valores al objeto image
        $image = Image::find($id);
        $image->description = $description;

        // Eliminar imagen antigua y subir nueva
        $image_path_old = $image->image_path;
        if ($image_path) {
            Storage::disk('images')->delete($image_path_old);
            $image_path_name = time() . $image_path->getClientOriginalName();
            Storage::disk('images')->put($image_path_name, File::get($image_path));
            $image->image_path = $image_path_name;
        }

        // Guardar en la BD
        $image->update();

        return redirect()->route('image.detail', ['id' => $image->id])->with([
            'message' => 'La imagen se ha subido correctamente'
        ]);
    }
}
