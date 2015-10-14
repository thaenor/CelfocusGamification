<?php namespace App\Http\Controllers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void

	public function __construct()
	{
		$this->middleware('auth');
	}
     */

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		$lastsynctime = Storage::disk('local')->get('lastsynctime.txt');
		if($lastsynctime == null){
			$lastsynctime = "waiting for first synchronization";
		}
		Blade::setContentTags('<%', '%>');        // for variables and all things Blade
		Blade::setEscapedContentTags('<%%', '%%>');   // for escaped data
		return view('home.landingPage',compact('lastsynctime'));
	}

}
