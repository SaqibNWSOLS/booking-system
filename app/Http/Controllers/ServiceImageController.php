<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServiceImage;
use Auth;

class ServiceImageController extends Controller
{
     public function store(Request $request)
{
    $image = $request->file('file');
    $fileInfo = $image->getClientOriginalName();
    $filename = pathinfo($fileInfo, PATHINFO_FILENAME);
    $extension = pathinfo($fileInfo, PATHINFO_EXTENSION);
    $file_name= $filename.'-'.time().'.'.$extension;
    $image->move(public_path('uploads'),$file_name);
        
    $imageUpload = new ServiceImage;
    $imageUpload->path = $file_name;
    $imageUpload->users_id = Auth::id();
    $imageUpload->save();
    return response()->json(['success'=>$file_name]);
}
   public function getUploadedImages($id)
   {
    $images = ServiceImage::where('users_id',$id)->whereNull('services_id')->get()->toArray();
    foreach($images as $image){
        $tableImages[] = $image['path'];
    }
    $storeFolder = public_path('uploads/');
    $file_path = public_path('uploads/');
    $files = scandir($storeFolder);
    foreach ( $files as $file ) {
        if ($file !='.' && $file !='..' && in_array($file,$tableImages)) {       
            $obj['name'] = $file;
            $file_path = public_path('uploads/').$file;
            $obj['size'] = filesize($file_path);          
            $obj['path'] = asset('uploads/'.$file);
            $data[] = $obj;
        }
        
    }
    //dd($data);
    return response()->json($data);
   }
   public function getPropertyImages($id){
    $images = ServiceImage::where('services_id',$id)->get()->toArray();
    foreach($images as $image){
        $tableImages[] = $image['path'];
    }
    $storeFolder = public_path('uploads/');
    $file_path = public_path('uploads/');
    $files = scandir($storeFolder);
    foreach ( $files as $file ) {
        if ($file !='.' && $file !='..' && in_array($file,$tableImages)) {       
            $obj['name'] = $file;
            $file_path = public_path('uploads/').$file;
            $obj['size'] = filesize($file_path);          
            $obj['path'] = asset('uploads/'.$file);
            $data[] = $obj;
        }
        
    }
    //dd($data);
    return response()->json($data);
   }

   public function destroy(Request $request)
{
    $filename =  $request->get('filename');
    ServiceImage::where('path',$filename)->delete();
    $path = public_path('public/uploads/').$filename;
    if (file_exists($path)) {
        unlink($path);
    }
    return response()->json(['success'=>$filename]);
}  
}
