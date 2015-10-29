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
		$schedule->call(function () {
	        $lastTicketId = Ticket::orderBy('id','desc')->first()->id;
	        $receivedTicketsResponse = Ticket::requestGamificationWebservice($lastTicketId);
			if($receivedTicketsResponse == null){
				Log::warning("wsdl returned null");
				return true;
			}
	        if( is_array($receivedTicketsResponse) ){
	            foreach($receivedTicketsResponse['ticket'] as $element){
		            try{
			            Ticket::insertTicket($element);
		            } catch (Exception $e) {
			            Log::warning('Caught exception recording ticket:'.$e->getMessage());
		            }
	            }
	        } else {
		        try{
			        Ticket::insertTicket($receivedTicketsResponse);
		        } catch (Exception $e) {
			        Log::warning('Caught exception recording ticket:'.$e->getMessage());
		        }
	        }
	        Storage::disk('local')->put('lastsynctime.txt', Carbon::now());
        })->hourly();

		$schedule->call(function () {
			App\Ticket::updateTicketsDev();
		})->hourly();

		/**
		 * Every month points are reset in the permanent hall of fame (this corresponds to the default group table
		 * on the first page)
		 */
		$schedule->call(function () {
			Ticket::resetPoints();
		})->monthly();

		/**
		 * Watches for any ticket with ReoPened state and sets penalties for it.
		 */
		$schedule->call(function() {
			Ticket::setTicketPenalties();
		})->everyTenMinutes();
	}

}
