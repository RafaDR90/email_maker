<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function store(Request $request)
    {
        $request->validate([
            'data' => 'required',
            'filename' => 'required|string'
        ]);

        try {
            $template = new Template();
            $template->user_id = $request->user()->id;
            $template->data = $request->data;
            $template->img_name = $request->filename;
            $template->save();

            return response()->json([
                'message' => 'Template created successfully',
                'template' => $template
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error creating template',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function uploadSvg(Request $request)
    {
        // Comprueba si la imagen ha sido subida
        if ($request->hasFile('image')) {

            // Obtiene la imagen
            $image = $request->file('image');
            $userId = $request->user()->id;

            // Define el nombre del archivo
            $filename = $userId . ';' . $image->getClientOriginalName() . '.png';

            //comprueba si el archivo ya existe
            if (Storage::disk('public')->exists('images/' . $filename)) {
                return response()->json([
                    'message' => 'El archivo ya existe'
                ], 409);
            }

            // Guarda la imagen en el disco 'public'
            $path = $image->storeAs('images', $filename, 'public');

            // Devuelve una respuesta JSON con la ruta de la imagen
            return response()->json([
                'message' => 'Imagen subida con éxito',
                'filename' => $filename,
                'path' => $path
            ], 200);
        } else {
            // Devuelve una respuesta JSON con un mensaje de error
            return response()->json([
                'message' => 'No se ha subido ninguna imagen'
            ], 400);
        }
    }

    public function getTemplates(Request $request)
    {
        $templates = Template::where('user_id', $request->user()->id)->get();
        return response()->json($templates);
    }


    public function deleteTemplate(Request $request)
    {
        $request->validate([
            'id' => 'required|integer'
        ]);

        $template = Template::find($request->id);
        $imagen= $template->img_name;
        $path = 'images/' . $imagen;
        


        if ($template && $template->user_id == $request->user()->id && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
            $template->delete();

            return response()->json([
                'message' => 'Template deleted successfully'
            ]);
        } else {
            return response()->json([
                'message' => 'Template not found'
            ], 404);
        }
    }
}
