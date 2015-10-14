<?php namespace App\Console;

use App\Http\Controllers\SoapController;
use App\Ticket;
use App\Group;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use SoapClient;
use SoapParam;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel {

	/**
	 * The Artisan commands provided by your application.
	 *
	 * @var array
	 */
	protected $commands = [
		'App\Console\Commands\Inspire',
	];

	/**
	 * Define the application's command schedule.
	 *
	 * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
	 * @return void
	 */
	protected function schedule(Schedule $schedule)
	{
		/**
		 * Webservice implementation. Uses the webservice to fetch new tickets.
		 * Any errors are logged to a file in /storage/logs
		 * The webservice returns either a single ticket or an array with two or more
		 * This function handles that possibility and treats it accordingly.
		 * There are no webservices to update tickets or insert missing groups or users yet.
		 * If you want to force the webservice to run visit the url secretRoute/soap
		 *
		 * This function is executed every hour
		 */
//		$schedule->call(function () {
//	        $lastTicketId = Ticket::orderBy('id','desc')->first()->id;
//	        $receivedTicketsResponse = Ticket::requestGamificationWebservice($lastTicketId);
//			if($receivedTicketsResponse == null){
//				Log::warning("wsdl returned null");
//				return true;
//			}
//	        $count = 0;
//	        if( is_array($receivedTicketsResponse) ){
//	            foreach($receivedTicketsResponse['ticket'] as $element){
//		            try{
//			            Ticket::insertTicket($element);
//		            } catch (Exception $e) {
//			            Log::warning('Caught exception recording ticket:'.$e->getMessage());
//		            }
//		            $count++;
//	            }
//	        } else {
//		        try{
//			        Ticket::insertTicket($receivedTicketsResponse);
//		        } catch (Exception $e) {
//			        Log::warning('Caught exception recording ticket:'.$e->getMessage());
//		        }
//	            $count ++;
//	        }
//	        Storage::disk('local')->put('lastsynctime.txt', Carbon::now());
//        })->hourly();

//		$schedule->call(function () {
//			ini_set('memory_limit', '-1');
//			ini_set('max_execution_time', 0);
//			$startOfLastMonth = new Carbon('first day of last month');
//			$startOfLastMonth->hour = 0;
//			$startOfLastMonth->minute = 0;
//			$startOfLastMonth->second = 0;
//			$lastTicketId = Ticket::where('state','open', 'Work in Progress')->where('created_at','>',$startOfLastMonth)
//				->orderBy('created_at','asc')
//				->first()->id;
//			$receivedTicketsResponse = Ticket::requestGamificationWebservice($lastTicketId);
//			$count = 0;
//			if($receivedTicketsResponse != null){
//				if( is_array($receivedTicketsResponse) ){
//					foreach($receivedTicketsResponse['ticket'] as $element){
//						try{
//							Ticket::insertTicket($element);
//						} catch (Exception $e) {
//							Log::warning('Caught exception recording ticket:'.$e->getMessage());
//						}
//						$count++;
//					}
//				} else {
//					try{
//						Ticket::insertTicket($receivedTicketsResponse);
//					} catch (Exception $e) {
//						Log::warning('Caught exception recording ticket:'.$e->getMessage());
//					}
//					$count ++;
//				}
//			}else{
//				Log::warning('invalid response from webservices');
//			}
//			Storage::disk('local')->put('lastsynctime.txt', Carbon::now());
//		})->hourly();

		/**
		 * Every month points are reset in the permanent hall of fame (this corresponds to the default group table
		 * on the first page)
		 */
//		$schedule->call(function () {
//			Ticket::resetPoints();
//		})->monthly();

		/**
		 * Watches for any ticket with ReoPened state and sets penalties for it.
		 */
		//$schedule->call(function() {
		//	Ticket::setTicketPenalties();
		//})->everyTenMinutes();
	}

}
