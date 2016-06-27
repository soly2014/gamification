<?php

namespace Learncloud\Http\Controllers;

use Illuminate\Http\Request;

use Learncloud\Http\Requests;
use Learncloud\User;
use Validator;
use Auth;
use Hash;
use DB;
//use Carbon;
use Learncloud\Paycloud;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Sale;
use PayPal\Api\Amount;
use PayPal\Api\Refund;
use Carbon\Carbon;






class Admin extends Controller
{
    

    public function showAdmin(\Learncloud\User $user , $year = 2016)
    {

          return view('admin.admin')->with('year',$year);
    
    }



        //////////////////////////////////////////////////////////////////
    public function showUser(){
        
        $users = User::all();
        
        return view('admin.table')->with('users',$users);  
        
    }
    ///////////////////////////////////////////////////////////////
    public function showEdit($id){
        
        $user = User::find($id);
        
        return view('admin.edituser')->with('user',$user);  
        
    }
    
   ////////////////////////////////////////////////////////////////////////// 
    public function editUser($id,Request $request){

        $this->validate($request, [
            'name' => 'max:255',
            'email' => 'email|max:255',
            'password' => 'confirmed|min:6',    
         ]);
       $user = User::find($id);

       if (User::where('email',$request->email)->count() > 0 && $user->email != $request->email)
        {

         return redirect()->back()->with('success', 'this email already has been token.');        

       }else{

          $user = User::find($id);
           
           $user->name = $request->name;
           $user->email = $request->email;
           $user->password = bcrypt($request->password);           
            
           $user->save();
          return redirect()->back()->with('success', 'information edited successfuly.');        
           

       }
     
   
    }
    //////////////////////////////////////////////////////////////////////////////
    public function deleteUser($id){
        
        $users = User::find($id);
        $users->delete();
        
      return redirect()->back()->with('success', 'Deleted successfuly.');        
        
    }
    
    //////////////////////////////////////////////////////////////////////////
    public function addPage(){

        return view('admin.adduser');  
        
    }
    
    //////////////////////////////////////////////////////////////////
   public function addUser(Request $request){

       $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',    
       ]);
       
       $user = new User();
       
       $user->name = $request->name;
       $user->email = $request->email;
       $user->password = bcrypt($request->password);           
        
       $user->save();
       
      return redirect()->back()->with('success', 'Deleted successfuly.');        
   } 

   /////////////////////////////////////////////////////////////////////////////

   public function editPassword($id, Request $request)
   {

       $this->validate($request, [
              'password' => 'min:6',    
         ]);
       
      $user = User::find($id);

          if (Hash::check($request->password,$user->password)) {

            $user->fill(['password'=>bcrypt($request->npass)])->save();
         
          return redirect()->back()->with('success', 'Changed Successfully.');        


          }else{
     
          return redirect()->back()->with('success', 'Old Password Error.');        


          }

   }
  

  ////////////////////////////////////////////////////////////////////////////////////////////


   

//////////////////////////////////////////////////////////////////////////////////////////////////
   
   public function showRefundedUser(User $user)
   {
     
      $users = DB::table('users')
            ->join('payclouds', 'users.id', '=', 'payclouds.user_id')
            ->select('users.*', 'payclouds.payer_id', 'payclouds.payment_id','payclouds.refunded','payclouds.payer_email')
            ->where('payclouds.refunded',1)
            ->get();



           /**/


      return view('admin.showrefund')->with('refundings',$users);
   }

    
}
