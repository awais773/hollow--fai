<?php

namespace App\Http\Controllers;
use App\Models\Artical;
use App\Models\Comment;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function index()
    {
        return view ('upload');
    } 
    public function submited(Request $request){
   $this ->validate ($request, [
       'name'=> 'required',
       'photos'=> 'required'
   ]);
    
   if ($request->hasFile('photos')) {
    $allowedfileExtension = ['pdf', 'jpg', 'png', 'docx'];
    $files = $request->file('photos');
    foreach ($files as $file) {
      $picture = $file->getClientOriginalName();
      $extension = $file->getClientOriginalExtension();
      $check = in_array($extension, $allowedfileExtension);
      if ($check) {
        $artical = Artical::create($request->all());
        foreach ($request->photos as $photo) {
          $picture = $photo->store('photos');
          comment::create([
            'artical_id' => $artical->id,
            'picture' => $picture,
          ]);
        
        }
      }
    }
   }

  }
   public function getAlbum($id){
   $artical= Artical::with('comment')->find($id);
   return response()->json($artical);
    
  }



       public function getathentic($id){
       $artical= Artical::with('comment')->find($id);
       return response()->json($artical);
    
    
     }
   

}
