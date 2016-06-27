<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


/*
*  home
*/

Route::get('/home/{id?}/{code?}',[
	'uses'=>'HomeController@index',
	'as'=>'home',
	])->where(['id' => '[0-9]+', 'code' => '[a-z0-9]+']);

Route::get('/home/features',[
	'uses'=>'HomeController@getFeatures',
	'as'=>'features',
	'middleware'=>['auth'],


	]);

Route::get('/home/profile',[
	'uses'=>'HomeController@getProfile',
	'as'=>'profile',
	'middleware'=>['auth'],


	]);
Route::get('/home/buypoints',[
	'uses'=>'HomeController@buyPoints',
	'as'=>'buypoints',
	'middleware'=>['auth'],


	]);

Route::get('/home/congrats',[
	'uses'=>'HomeController@congrats',
	'as'=>'congrats',
	'middleware'=>['auth'],


	]);

/*Route::post('/home/facebook/share',[
	'uses'=>'HomeController@facebookShare',
	'as'=>'facebook.share',
	'middleware'=>['auth'],


	]);*/

Route::post('/home/twitter/share',[
	'uses'=>'HomeController@twitterShare',
	'as'=>'twitter.share',
	'middleware'=>['auth'],


	]);
/*
*  Link tracker
*/

Route::get('/home/linktracker/{id?}/{code?}',[
	'uses'=>'HomeController@trackLink',
	'as'=>'linktracker',


	]);
/*
*  image processing 
*/

Route::get('merged/images/{image}' , 'ImageProcessingController@mergeImage');
//Route::post('merged/images/{$image}' , 'ImageProcessingController@mergeImage');

/*
*  Auth credentials
*/

Route::get('/signup/{id?}/{code?}',[
	'uses'=>'AuthController@getSignup',
	'as'=>'sign_up',
	])->where(['id' => '[0-9]+', 'code' => '[a-z0-9]+']);

Route::post('/signup/{id?}/{code?}',[
	'uses'=>'AuthController@postSignup',
	]);

Route::get('/login',[
	'uses'=>'AuthController@getLogin',
	'as'=>'login',
	]);

Route::post('auth/login',[
	'uses'=>'AuthController@postLogin',
	'as'=>'login',
	]);

Route::post('auth/logout',[
	'uses'=>'AuthController@getLogout',
	'as'=>'logout',
	'middleware'=>['auth'],

	]);

Route::get('/home/accesspaypal','PaypalController@accessPaypal');
/* 
*  social Auth credentials
* big note 
* i have changed the CURL Factory on laravel to false
* laravel/vendor/guzzlehttp/guzzle/src/handler/curlfactory.php on line 324
*/


/* facebook  */
Route::get('/auth/facebook',[
	'uses'=>'AuthController@redirectToProvider',
	'as'=>'auth.facebook',
	]);

Route::get('/auth/facebook/callback',[
	'uses'=>'AuthController@handleProviderCallback',
	]);

/* twitter */
Route::get('auth/twitter', 'AuthController@twitterRedirectToProvider')->name('auth.twitter');
Route::get('auth/twitter/callback', 'AuthController@twitterHandleProviderCallback');

/* after sign up */
Route::get('/signupsocial/{id?}/{code?}',[
	'uses'=>'AuthController@getSignupSocial',
	'as'=>'sign_up_social',
	'middleware'=>['auth'],
	])->where(['id' => '[0-9]+', 'code' => '[a-z0-9]+']);

Route::post('/signupsocial/{id?}/{code?}',[
	'uses'=>'AuthController@postSignupSocial',
	]);


/* 
*  
*  
* Image Processing issues
* 
*/
Route::get('/home/image','ImageProcessingController@mergeImage')->middleware('auth');
/*
 * refund
*/

 Route::get('/showrefunded/{payment_id?}/{payer_id?}', 'PaypalController@postRefundedUser')->middleware('auth');
 Route::get('/refunded/logout', 'PaypalController@refundLogout')->middleware('auth');



/* 
*  
*  
* ADMIN CREDENTIALS
* 
*/




Route::group(['middleware' => ['web', 'admin']], function () {
               

        Route::get('/home/admin/{year?}','Admin@showAdmin');
    

        /* dealing with users */
        Route::get('/admin/adduser', 'Admin@addPage');
        Route::post('/admin/adduser', 'Admin@addUser');
        Route::get('/admin/showusers', 'Admin@showUser');
        Route::get('/admin/editusers/{id}', 'Admin@showEdit')->name('adminedit');
        Route::post('/admin/editusers/{id}', 'Admin@editUser');
        Route::post('/admin/editpassword/{id}', 'Admin@editPassword');
        Route::post('/admin/delete/{id}', 'Admin@deleteUser')->name('admindelete');

        /* show refunded users */
        Route::get('/admin/showrefunded', 'Admin@showRefundedUser');

        /* dealing with buldings */
       /* Route::get('/admin/addbu', 'BuController@addBu');
        Route::post('/admin/addbu', 'BuController@postBu');

        Route::get('/admin/showbu', 'BuController@showBu');
*/


        /* site setting */
        Route::get('/admin/sitesetting','SiteSettingController@index');
        Route::post('/admin/sitesetting','SiteSettingController@postSettings');

});



/*

/* datatable credentials */
/*
Route::controller('datatables', 'DatatablesController', [
    'anyData'  => 'datatables.data',
    'getIndex' => 'datatables',
]);
*/






