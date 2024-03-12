<?php
namespace App\Traits;


trait Image

{

function saveimage($image,$name,$folder){

    $ext = $image->getClientOriginalExtension();
    $imageName = $name . time() .rand(100,100000) . "." . $ext;
    $path = $folder;
    $image-> move ($path,$imageName);


  return $imageName;
}
function updateimage($image,$name,$folder){

    if($request->hasFile($image)){

    $ext = $image->getClientOriginalExtension();
    $imageName = $name . time() .rand(100,100000) . "." . $ext;
    $path = $folder;
    $remove =public_path($folder . $name->image);
    if(file_exists($remove)){
      unlink($remove);
    }

    $image-> move ($path,$imageName);


  return $imageName;
}


}



?>
