<?php namespace App\Http\Controllers;

use App\Article;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\PointSettings;
use App\Reward;
use Carbon\Carbon;
use App\Ticket;
use App\User;
use App\Group;
use DateTime;
use Illuminate\Http\Request;
use PhpSpec\Exception\Exception;

class ApiController extends Controller {

    /**
     * Returns JSON with all group information
     * @return mixed
     */
    public function fetchGroupJson(){
        $groups = Group::all();
        return $groups;
    }


    /**
     * Queries the database for tickets between a start and an end date.
     * Replaces the user id with actual user full name
     * Returns the data in Json format.
     * @param $startTime
     * @param $endTime
     * @return mixed
     */
    public function fetchOpenTicketJson($startTime, $endTime){
        $this->validateInputs($startTime,$endTime);
        return $tickets = Ticket::getOpenTicketsBetween($startTime, $endTime);
    }

    public function fetchClosedTicketJson($startTime, $endTime){
        $this->validateInputs($startTime,$endTime);
        return $tickets = Ticket::getClosedTicketsBetween($startTime, $endTime);
    }

    public function fetchReOpenedTicketJson($startTime, $endTime){
        $this->validateInputs($startTime,$endTime);
        $tickets = Ticket::getReOpenedTicketsBetween($startTime, $endTime);
        return $this->filterTickets($tickets);
    }

    public function filterTickets($tickets){
        foreach($tickets as $ti){
            $user = User::findOrFail($ti->user_id);
            $ti->user_id = $user->full_name;
            $team = Group::findOrFail($ti->assignedGroup_id);
            $ti->assignedGroup_id = $team->title;
        }
        return $tickets;
    }


    /**
     * Default route with no parameters.
     * By default we assume the first and last day of February of 2015
     * Merely because those are the latest results in the test DB
     * Once deployed the interval can be changed to the last month
     */
    public function fetchOpenTicketJsonDefault(){
        $start = new Carbon('first day of this month');
	    $start->hour=0; $start->minute=0; $start->second=0;
        return $tickets = Ticket::getOpenTicketsBetween($start, Carbon::now());
    }

    public function fetchReopenedTicketJsonDefault(){
        $start = new Carbon('first day of this month');
        $tickets = Ticket::getReOpenedTicketsBetween($start,Carbon::now());
        return $this-> filterTickets($tickets);
    }

    public function fetchClosedTicketJsonDefault(){
        $start = new Carbon('first day of this month');
	    $start->hour=0; $start->minute=0; $start->second=0;
        return $tickets = Ticket::getClosedTicketsBetween($start,Carbon::now());
    }

    public function fetchArticles(){
        $articles = Article::all()->take(50);
        foreach($articles as $article){
            $user = User::find($article->author);
            $article->author = $user->full_name;
        }
        return $articles;
    }

    /**
     * A wrapper for Carbon's CreateFromFormat function. The dates are received
     * as month-day-year. We need Carbon instance's time that matches.
     * @param $date
     * @return static
     */
    public function convertTime($date){
        return $ValidDate = Carbon::createFromFormat('Y-m-d', $date);
    }

    /**
     * Function triggered by the route
     * This is a simple validation function, it tries to convert the time
     * using Carbon's time conversion. Since it's a try catch block, if there's an
     * invalid time received the exception will be triggered and an error 400 (Bad Request)
     * is triggered.
     * Lastly the dates are validated to make sure they reference a past date
     * Only and only if the dates are valid the function to fetch information to the DB
     * is called.
     * @param $start
     * @param $end
     * @return mixed
     */
    public function validateInputs($start, $end){
        try{
            $carbonStart = $this->convertTime($start);
            $carbonEnd = $this->convertTime($end);
            if($carbonStart->isFuture() || $carbonEnd->isFuture())
                abort(404,"we couldn't find the tickets you are looking for");
        } catch(Exception $e){
            abort(400,$e);
        }
    }

    public function getChallengesCount(){
        return $count = Reward::all()->count();
    }

    public function getPointSettings()
    {
        return PointSettings::all();
    }

}
