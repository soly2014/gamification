<?php

namespace Learncloud\Http\Controllers;

use Validator;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Contracts\Auth\Authenticatable;
use Learncloud\Http\Controllers\Controller;
use Learncloud\User;
use Learncloud\Points;
use Auth;
use Socialite;
use Learncloud\Http\Requests;
use Illuminate\Http\Request;
use DB;




class AuthController extends Controller
    {


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function getSignup($id=null,$code=null)
    {

        return view('sign_up')->with('id',$id)->with('code',$code);
    }


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function postSignup(Request $request,$id=null,$code=null)
    {
    // start of transction function    
    DB::transaction(function() use($request){
       
        $this->validate($request,[

            'name'=>'required|min:6',
            'type'=>'required|in:student,teacher',
            'email'=>'required|email|unique:users',
            'password'=> 'required|confirmed|min:6',
            'password_confirmation'=>'required',
            'photo'=>'required|image|mimes:jpeg,jpg,bmp,png',
            'phone'=>'required|regex:/^\d*(\.\d{2})?$/',

            ]);

        $name     = $request->input('name');
        $type     = $request->input('type');
        $email    = $request->input('email');
        $country  = $request->input('country');
        $phone    = $request->input('phone');
        $id       = $request->input('id');
        $code     = $request->input('code');
        $password = bcrypt($request->input('password'));
        
        $file         = $request->file('photo');
        $path         = 'images/profiles';
        $filename     = str_random(15).'.'.$file->getClientOriginalExtension();
        $file->move($path,$filename);

        $user = new User();
        $user->name          = $name;
        $user->password      = $password;
        $user->type          = $type;
        $user->country       = $country;
        $user->email         = $email;
        $user->phone         = $phone;
        $user->image_name    = $filename;
        $user->referral_code = strtolower(str_random(7));
        $user->invited_by    = $id;

        $user->save();

        // add points to the user who invited this new user
         if($type == 'teacher'){ $point_added = 2000;}else{ $point_added = 1000 ;}
    
        if (User::where('id',$id)->where('referral_code',$code)->first()) {
              
            if(Points::where('user_id',$id)->first()){
                    $add_points=Points::where('user_id',$id)->first()->points + $point_added;
                }else{
                    $add_points=$point_added;
                }

            $invited_points = Points::where('user_id',$id)->first()->invited_points;
            
            $points = Points::find($id);  
            $points->user_id         = $id;
            $points->points          = $add_points;
            $points->invited_points  = $invited_points + 1;
            $points->save();

        }

     }); /*end of transction function*/


        // add points to the new user.

        if (User::where('email',$request->input('email'))->first()) {
            
            $points = new Points;
            $points->user_id = User::where('email',$request->input('email'))->first()->id;
            $points->points  = 1000;
            $points->save();

        }



        if(!Auth::attempt($request->only(['email','password']),$request->has('remember'))){

                return redirect()->back()->with('info','Failed To Sign Up');

                }


        return redirect()->route('features');

    }
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function getLogin()
    {

        return view('login');
    }

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        public function postLogin(Request $request)
    {

        $this->validate($request,[

            'email'=>'required',
            'password'=> 'required',

            ]);

            if(!Auth::attempt($request->only(['email','password']),$request->has('remember'))){

                return redirect()->back()->with('info','Sorry, the member email and password
                                                   you entered do not match. Please try again.');

                            }

                return redirect()->route('profile');           
    }

////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function getLogout()
    {

        Auth::logout();

        return redirect()->route('home');

    }

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function redirectToProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function handleProviderCallback(Request $request)
    {


                try {

                    $user = Socialite::driver('facebook')->user();
                } catch (Exception $e) {
                    return redirect()->route('auth.facebook');
                }
                if(User::where('facebook_id', $user->getId())->first() != null){
                    $autheduser = User::where('facebook_id', $user->getId())->first();
                    Auth::loginUsingId($autheduser->id);
                    return redirect()->route('profile');
                }else{
                $users = new User();
                $users->facebook_id          = $user->getId();
                $users->name                 = $user->getName();
                $users->email                = $user->getEmail();
                $users->password             = bcrypt($user->token);
                $users->referral_code        = strtolower(str_random(7));

                $users->save();

                   if(Auth::attempt(['facebook_id' => $user->getId(), 'password' => $user->token])){
                       return redirect()->intended('/signupsocial');

                   }
                }

        

    }
              

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /*
     *
     *  twitter Auth
     *
     *
    */
/**
     * Redirect the user to the Twitter authentication page.
     *
     * @return Response
     */
    public function twitterRedirectToProvider()
    {
        return Socialite::driver('twitter')->redirect();
    }

    /**
     * Obtain the user information from Twitter.
     *
     * @return Response
     */
    public function twitterHandleProviderCallback()
    {
            try {
                $user = Socialite::driver('twitter')->user();
            } catch (Exception $e) {
                return redirect('auth/twitter');
            }

                
                if(User::where('twitter_id', $user->id)->first() != null){
                    $autheduser = User::where('twitter_id', $user->id)->first();
                    Auth::loginUsingId($autheduser->id);
                    return redirect()->route('profile');
                }else{
                $users = new User();
                $users->twitter_id           = $user->id;
                $users->name                 = $user->name;
                $users->email                = $user->email;
                $users->handle               = $user->nickname;
                $users->image_name           = $user->avatar_original;
                $users->password             = bcrypt(123456);
                $users->referral_code        = strtolower(str_random(7));

                $users->save();

                   if(Auth::attempt(['twitter_id' => $user->id, 'password' => bcrypt(123456)])){
                       return redirect()->intended('/signupsocial');

                   }
                }


    }

   

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  
    public function getSignupSocial($id=null,$code=null)
    {
        return view('sign_up_social');
    }
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function postSignupSocial(Request $request,$id=null,$code=null)
    {
        $this->validate($request,[

            'type'=>'required|in:student,teacher',
            'phone'=>'required|regex:/^\d*(\.\d{2})?$/',

            ]);
        
        Auth::user()->update([
        'type'             => $request->input('type'),
        'country'          => $request->input('country'),
        'phone'            => $request->input('phone'),
       // 'invited_by'       => $request->input('invited_by'),

            ]);
        
        if (Auth::user()->facebook_id != null  || Auth::user()->twitter_id != null) {
            
            $points = new Points;
            $points->user_id = Auth::user()->id;
            $points->points  = 1000;
            $points->save();

        }

        return redirect()->route('features');


    }
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

}
