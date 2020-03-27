<?php

namespace App\Http\Controllers;

use App\Lib\FileUpload;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class UploadController extends Controller
{
    public function imageUpload(Request $request)
    {
        $this->validate($request, [
            'imagen' => 'required|image:png,jpg|dimensions:min_width=150,max_width=2000,max_height=2000',
            'private' => 'required|boolean',
        ], [
            'dimensions' => 'La dimensión mínima de una imagen debe de ser de 200x200 px y máximo 2000x2000 px',
        ]);

        $result = $this->imageStorage($request->file('imagen'), $request->input('private'));

        return response()->json($result, 201);
    }

    public function fileUpload(Request $request)
    {
        $input = $this->validate($request, [
            'file' => 'required|mimes:pdf',
            'private' => 'required|boolean',
        ]);

        $response = $this->fileStorage($request->file('file'), $input['private']);

        return response()->json($response, 201);
    }

    public function universalUpload(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|file|mimes:pdf,png,jpeg',
            'private' => 'required|boolean',
        ]);

        $file = $request->file('file');
        $mime = $file->getMimeType();

        if ($mime == 'image/png' || $mime == 'image/jpeg') {
            $result = $this->imageStorage($file, $request->input('private'));
        } else {
            $result = $this->fileStorage($file, $request->input('private'));
        }

        return response()->json($result, 201);
    }

    public function getPrivateFile($fileName)
    {
        $pathToFile = storage_path('storage/files/'.$fileName);

        return response()->file($pathToFile);
    }

    protected function fileStorage($file, $visibility = false)
    {
        $name = Uuid::uuid4()->toString().'.'.$file->getClientOriginalExtension();

        $path = $visibility ? 'storage_path' : 'public_path';

        $file->move($path('storage/files'), $name);

        $response = [];

        if (! $visibility) {
            $response['url'] = asset('storage/files/'.$name);
        } else {
            $response['url'] = route('file.private', $name);
        }

        return $response;
    }

    protected function imageStorage($file, $visibility = false)
    {
        $upload = new FileUpload($file, 'storage/files/');

        $upload->uploadImageSave($visibility);

        return $upload->getFileUploaded();
    }
}
