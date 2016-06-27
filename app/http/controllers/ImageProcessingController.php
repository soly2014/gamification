<?php

namespace Learncloud\Http\Controllers;

use Illuminate\Http\Request;

use Learncloud\Http\Requests;
use Auth;
use Image;
use Learncloud\User;
use Learncloud\Points;

class ImageProcessingController extends Controller
{


     public  static function mergeImage($image='Bill.jpg')
    {
      
      /* add points to the user who shared the photo */
      if(Auth::user()->shared_photo != 1){

                $user = User::find(Auth::user()->id);
                $user->shared_photo = 1;
                $user->save();

                $points_added = Points::where('user_id',Auth::user()->id)->first()->points + 1000;
                $points = Points::where('user_id',Auth::user()->id)->first();
                $points->user_id    = Auth::user()->id;
                $points->points     = $points_added;
                $points->save();

            }

            /* handle file_get_contents() ssl error */
            $arrContextOptions=array(
         		 "ssl"=>array(
             				 "verify_peer"=>false,
             				 "verify_peer_name"=>false,
      	                ),
      	    	);  

            /* watermark  */
         if (Auth::user()->facebook_id != null) {
            
            $url  = 'http://graph.facebook.com/'.Auth::user()->facebook_id.'/picture';
            $data = file_get_contents($url,false, stream_context_create($arrContextOptions)); 
            }
             elseif (Auth::user()->twitter_id != null)
              {
              # code...
             }
             else 
             {
             $data = public_path('images/profiles/'.Auth::user()->image_name);
             }
           
        
        

        $data = Image::make($data)->resize(205, 200);

 		    $img  = Image::make(public_path('merged_images/'.$image))
 		 		         		->resize(1300, 700)
 		                ->insert($data,'50','140','277','60');

        
        $filename     = str_random(15).'.'.$img.'jpg';
 		    $path         = public_path('merged_images/store/'.$filename);

        $img->save($path);


        return $filename;
 
             
    }
  
}
