<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageRequest as Request;
use App\Models\Image;
use Cloudinary\Cloudinary;


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
            //Upload File to external server
            $cloudinary = new Cloudinary([
                'cloud' => [
                'cloud_name' => 'dbfs', 
                'api_key' => env('CLOUDINARY_API_KEY'), 
                'api_secret' => env('CLOUDINARY_API_SECRET')],
                'url' => [
                'secure' => true]
            ]);        
            $filePath = $request->file->store('storage/uploads');
            $fullFilePath = storage_path('app') . '/' . $filePath;
            $response = $cloudinary->uploadApi()->upload($fullFilePath);
            unlink($fullFilePath);
            return $response;
        }                                   
    }
}
