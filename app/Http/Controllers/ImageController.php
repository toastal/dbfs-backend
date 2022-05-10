<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageRequest as Request;
use App\Models\Image;
use Imageupload;
use Illuminate\Support\Facades\Storage;

/**
 * Class ImageController
 * @package App\Http\Controllers
 */
class ImageController extends Controller
{
    /**
     * @var Image
     */
    protected $model;
    /**
     * ImageController constructor.
     * @param Image $model
     */
    public function __construct(Image $model)
    {
        $this->middleware('auth:api', []);

        $this->model = $model;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        
        if($request->hasFile('file')) {
          
            //get filename with extension
            $filenamewithextension = $request->file('file')->getClientOriginalName();
      
            //get filename without extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
      
            //get file extension
            $extension = $request->file('file')->getClientOriginalExtension();
      
            //filename to store
            $filenametostore = $filename.'_'.uniqid().'.'.$extension;
      
            //Upload File to external server
            Storage::disk('ftp')->put($filenametostore, fopen($request->file('file'), 'r+'));
      
            //Store $filenametostore in the database
        }        
        return json_encode([ 'filePath' => env('FTP_HTTP', 'http://dbfs.rf.gd/public/') . $filenametostore ]);
        
    }
}
