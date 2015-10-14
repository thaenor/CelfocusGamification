<?php namespace App\Http\Controllers;

use App\Group;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Ticket;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Psy\Exception\Exception;
use SoapClient;
use Illuminate\Http\Request;
use SoapHeader;
use SoapParam;


class SoapController extends Controller {

	public function index()
	{
		$lastTicketId = Ticket::orderBy('id','desc')->first()->id;
		$receivedTicketsResponse = Ticket::requestGamificationWebservice($lastTicketId);
		if($receivedTicketsResponse == null){
			return "wsdl returned null";
		}
		$count = 0;
		if( is_array($receivedTicketsResponse) ){
			foreach($receivedTicketsResponse['ticket'] as $element){
				try{
					Ticket::insertTicket($element);
				} catch (Exception $e) {
					Log::warning('Caught exception recording ticket:'.$e->getMessage());
				}
				$count++;
			}
		} else {
			try{
				Ticket::insertTicket($receivedTicketsResponse);
			} catch (Exception $e) {
				Log::warning('Caught exception recording ticket:'.$e->getMessage());
			}
			$count ++;
		}
		//echo 'Webservice data transfer complete, total data received '.$count;
		Storage::disk('local')->put('lastsynctime.txt', Carbon::now());
        echo 'Webservice data transfer complete, total data received '.$count;
	}

//	public function update()
//	{
//		ini_set('memory_limit', '-1');
//		ini_set('max_execution_time', 0);
//		$startOfLastMonth = new Carbon('first day of last month');
//		$startOfLastMonth->hour = 0;
//		$startOfLastMonth->minute = 0;
//		$startOfLastMonth->second = 0;
//		$lastTicketId = Ticket::where('state','open', 'Work in Progress')->where('created_at','>',$startOfLastMonth)
//			->orderBy('created_at','asc')
//			->first()->id;
//		$receivedTicketsResponse = Ticket::requestGamificationWebservice($lastTicketId);
//		$count = 0;
//		if($receivedTicketsResponse != null){
//			if( is_array($receivedTicketsResponse) ){
//				foreach($receivedTicketsResponse['ticket'] as $element){
//					try{
//						Ticket::insertTicket($element);
//					} catch (Exception $e) {
//						Log::warning('Caught exception recording ticket:'.$e->getMessage());
//					}
//					$count++;
//				}
//			} else {
//				try{
//					Ticket::insertTicket($receivedTicketsResponse);
//				} catch (Exception $e) {
//					Log::warning('Caught exception recording ticket:'.$e->getMessage());
//				}
//				$count ++;
//			}
//		}else{
//			echo 'webservices returned null';
//		}
//		Storage::disk('local')->put('lastsynctime.txt', Carbon::now());
//		echo 'Webservice data update complete, total data received '.$count;
//    }
}
