<?php namespace App;

use DateTime;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use kintParser;
use SoapClient;
use SoapParam;

class Ticket extends Model
{


    public static function updateTicketsDev()
    {
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 0);
        $lastId = Storage::disk('local')->get('lastid.txt');
        $query = "
SELECT th.id AS history_id,
    th.ticket_id,
    tp.name AS priority,
    ts.name AS state,
    tt.name AS ticket_type,
    owner_id AS player_id,
    g.id AS team_id,
    th.change_time,
    t.percentage AS percentage,
    dynamicval.value_text AS externalid
    FROM ticket_history th
    LEFT JOIN ticket_priority tp ON tp.id = th.priority_id
    LEFT JOIN ticket_state ts ON ts.id = th.state_id
    LEFT JOIN queue ON queue.id = th.queue_id
    LEFT JOIN ticket_type tt ON tt.id = th.type_id
    INNER JOIN groups g ON g.id = queue.group_id
    LEFT JOIN ticket t ON t.id = th.ticket_id
    LEFT JOIN (
SELECT a.object_id, a.value_text from dynamic_field_value a inner join
(
SELECT object_id, max(id) id
FROM  dynamic_field_value
WHERE field_id in (16,17)
group by object_id
) b on a.id=b.id
    ) dynamicval ON th.ticket_id = dynamicval.object_id
    WHERE th.id >= $lastId
    ORDER BY th.id ASC;
    ";
        $dbconn = pg_connect("host=10.200.10.54 port=5432 dbname=otrs user=otrsro password=otrs-ro123.")or die('Could not connect: ' . pg_last_error());
        $result = pg_query($query) or die('Query failed: ' . pg_last_error());
        if (pg_fetch_result($result, 0) === false) {
            Log::warning('Nothing to sync.');
            return false;
        }
        $data = (array_values(pg_fetch_all($result)));
        foreach ($data as $ticket) {
            Ticket::insertTicket($ticket);
        }
        $query = "select id from ticket_history order by id desc limit 1";
        $result = pg_query($query) or die('Query failed: ' . pg_last_error());
        $updatedID = pg_fetch_result($result, 0, 0);
        Storage::disk('local')->put('lastid.txt', $updatedID);
        return true;
    }


    /**
     * Get all tickets with resolved status between a starting and an ending point
     * @param $start
     * @param $end
     * @return mixed
     */
    public static function getClosedTicketsBetween($start, $end)
    {
        $rowData = DB::select(DB::raw("
            select * from (
            SELECT
            tickets.id, tickets.title, tickets.state, tickets.type, tickets.priority, tickets.sla, users.full_name AS user_id, groups.title AS assignedGroup_id, tickets.points, tickets.percentage, tickets.created_at, tickets.updated_at, tickets.external_id
            FROM tickets
            INNER JOIN users ON users.id = user_id
            INNER JOIN groups ON groups.id = assignedGroup_id
            WHERE tickets.created_at > '$start' AND tickets.created_at < '$end'
            ) as t
            WHERE state = 'closed' OR state = 'Resolved'
        "));
        $blacklist = user_blacklist::all();
        foreach ($blacklist as $blacklistedUser) {
            foreach ($rowData as $key => $value) {
                if ($blacklistedUser->username == $value->user_id) {
                    unset($rowData[$key]);
                }
            }
        }
        $rowData = array_values($rowData);
        return $rowData;
    }
    /*
     * WARNING - INFORMATION:
     * This is a backup query to include both created_at and updated_at fields. This will make more tickets appear in
     *  the
     * dashboard. It will filter creation and "last update" dates
     * Add this
     * OR tickets.updated_at > '$start' AND tickets.updated_at < '$end'
     * right after the line that says
     * WHERE tickets.created_at > '$start' AND tickets.created_at < '$end'
     * */

    /**
     * Get all tickets with open status between a starting and an ending point
     * @param $start
     * @param $end
     * @return mixed
     */
    public static function getOpenTicketsBetween($start, $end)
    {
        return DB::select(DB::raw("
            select * from (
            SELECT
            tickets.id, tickets.tn, tickets.escalation_solution_time, tickets.title, tickets.state, tickets.type, tickets.priority, tickets.sla, tickets.sla_time, users.full_name AS user_id, groups.title AS assignedGroup_id, tickets.points, tickets.percentage, tickets.created_at, tickets.updated_at, tickets.external_id
            FROM tickets
            INNER JOIN users ON users.id = user_id
            INNER JOIN groups ON groups.id = assignedGroup_id
            WHERE tickets.created_at > '$start' AND tickets.created_at < '$end'
            ) as t
            WHERE state = 'open' OR state = 'Work in Progress' OR state = 'Solution Rejected'
        "));
    }

    public static function getAllOpenTickets()
    {
        return Ticket::where('state', '=', 'open')->get();
    }

    /*
     * WARNING - INFORMATION:
     * This is a backup query to include both created_at and updated_at fields. This will make more tickets appear in
     *  the
     * dashboard. It will filter creation and "last update" dates
     * Add this
     * OR tickets.updated_at > '$start' AND tickets.updated_at < '$end'
     * right after the line that says
     * WHERE tickets.created_at > '$start' AND tickets.created_at < '$end'
     * */

    public static function getAllTicketsBetween($start, $end)
    {
        return Ticket::whereBetween('created_at', [$start, $end]);
    }

    public static function setTicketPenalties()
    {
        $player = new User();
        $team = new Group();
        $carbon = new DateTime('first day of this month');
        $tickets = Ticket::getReOpenedTicketsBetween($carbon, Carbon::now());
        if ($tickets) {
            foreach ($tickets as $t) {
                $player->updateUser($t->user_id, (-10));
                $team->updateTeam($t->assignedGroup_id, $t->points);
            }
        } else {
            exit(1);
        }
    }
    /*WARNING - INFORMATION: Replace the following line if you want to include the "last update" dates in the dashboard
    results
     * return Ticket::whereBetween('created_at', [$start, $end])
     *->orWhereBetween('updated_at',[$start,$end])->get();
     * */

    /**
     * Get all tickets with reopened status between a starting and an ending point
     * @param $start
     * @param $end
     * @return mixed
     */
    public static function getReOpenedTicketsBetween($start, $end)
    {
        return Ticket::whereBetween('created_at', [$start, $end])
            ->orWhereBetween('updated_at', [$start, $end])
            ->where('state', 'ReOpened')
            ->get();
    }

    public static function insertTicket($element)
    {
        if(!is_object($element)){
            return false;
        }
        $ticket = Ticket::find($element->id);
        if (!$ticket) {
            $ticket = new Ticket();
        }
        $ticket->id = $element->id;
        $ticket->title = $element->title;
        $ticket->type = $element->type_of_ticket;
        $ticket->priority = $element->priority_id;
        $ticket->state = $element->ticket_state;
        $ticket->sla = $element->sla_name;
        $ticket->sla_time = $element->solution_time;
        $ticket->percentage = $element->percentage;
        $ticket->created_at = $element->cretime;
        $ticket->updated_at = $element->chgtime;
        $ticket->user_id = $element->user_id;
        $ticket->external_id = $element->remedy_id;
        //tries to locate the user. If it does not exist, the data is imported
        $user = User::find($element->user_id);
        if (!$user) {
            $recoveredUsername = Ticket::requestGetTicketWSDL($element->id);
            if ($recoveredUsername != null) {
                $user = new User();
                $user->id = $element->user_id;
                $user->full_name = $recoveredUsername['user'];
                $user->email = $recoveredUsername['user'] . "@novabase.com";
                $user->league_id = 1;
                $user->password = bcrypt('password');
                $user->points = 0;
                $user->health_points = 100;
                $user->experience = 0;
                $user->level = 1;
                $user->save();
                Log::warning('user imported ' . $recoveredUsername['user']);
                //attempt to fall back to DEV server and retrieve data
                /*try{
                    Ticket::fallbackUserImport($element->user_id);
                } catch(exception $e){
                    return true;
                    throw new Exception('error inserting ticket, unknown user id '.$element->user_id);
                }*/
            }
        }
        $ticket->assignedGroup_id = $element->group_id;
        //tries to locate the group. If it does not exist, the data should be imported (pending wsdl server development)
        $group = Group::find($element->group_id);
        if (!$group) {
            if ($recoveredUsername != null) {
                Log::warning('We received an unknown user with id- ' . $element->user_id);
                $group = new Group();
                $group->id = $element->group_id;
                $group->title = $recoveredUsername["team"];
                $group->points = 0;
                $group->save();
                Log::warning('group imported ' . $recoveredUsername['team']);
                //attempt to fall back to DEV server and retrieve data
                /*try{
                    Ticket::fallbackGroupImport($element->group_id);
                } catch(exception $e){
                    return true;
                    throw new Exception('error inserting ticket, unknown user id '.$element->user_id);
                }   */
            }
        }
        $ticket->save();
        $ticket->updateTicketPoints($ticket);
    }

    public static function requestGetTicketWSDL($ticketId)
    {
        $client = new SoapClient(NULL,
            ['location' => 'http://193.236.121.122/otrs/nph-genericinterface.pl/Webservice/GenericTicketConnector?wsdl',
                'uri' => "http://193.236.121.122/otrs/nph-genericinterface.pl/Webservice/GenericTicketConnector?wsdl"]);
        //making soap call to SessionCreate, this returns the session for future calls
        $sessionKey = $client->__soapCall("SessionCreate", array(
            new SoapParam("gameon", "UserLogin"),
            new SoapParam("Celfocus2015", "Password")
        ));
        if ($sessionKey == null) {
            //session key is missing sending to signify error
            echo("invalid response from the gamification webservices couldnt request session ID");
        }
        $ticketGet = $client->__soapCall("TicketGet", array(
            new SoapParam($sessionKey, "SessionID"),
            new SoapParam($ticketId, "TicketID")
        ));
        $result["user"] = $ticketGet->Owner;
        $result["team"] = $ticketGet->Service;
        return $result;
    }

    public function updateTicketPoints($ticket)
    {
        switch ($ticket->priority) {
            case "1 Critical":
                $points = 10;
                break;
            case "2 High":
                $points = 8;
                break;
            case "3 Medium":
                $points = 3;
                break;
            case "4 Low":
                $points = 1;
                break;
            default:
                $points = 0;
        }

        switch ($ticket->type) {
            case "Incident":
                $points += 7;
                break;
            case "Service Request":
                $points += 5;
                break;
            case "Problem":
                $points += 10;
                break;
            default:
                $points += 0;
        }

        if ($ticket->percentage > 40) {
            if ($ticket->percentage < 100) {
                $points = $points * ($ticket->percentage / 100);
                $points = ceil($points);
            } else if ($ticket->percentage > 100) {
                $points = $points - ($points * ($ticket->percentage / 100));
                $points = floor($points);
            }
        }
        $ticket->points = $points;
        if ($ticket->state == "closed") {
            //$this->updateScorePoints($ticket->user_id, $ticket->assignedGroup_id, $points);
        } else if ($ticket->state == "ReOpen") {
            //$this->setTicketPenalties();
        }
        $ticket->save();
    }

    public static function resetPoints()
    {
        $allGroups = Group::all();
        foreach ($allGroups as $group) {
            $group->points = 0;
            $group->save();
        }
        $allUsers = User::all();
        foreach ($allUsers as $user) {
            $user->points = 0;
            $user->save();
        }
    }

    public static function requestGamificationWebservice($thresholdID)
    {
        $returnValue = null;
        //declaring SOAP client
        try {
            $client = new SoapClient(NULL,
                ['location' => 'http://193.236.121.122/otrs/nph-genericinterface.pl/Webservice/GenericTicketConnector?wsdl',
                    'uri' => "http://193.236.121.122/otrs/nph-genericinterface.pl/Webservice/GenericTicketConnector?wsdl"]);
            //making soap call to SessionCreate, this returns the session for future calls
            $sessionKey = $client->__soapCall("SessionCreate", array(
                new SoapParam("gameon", "UserLogin"),
                new SoapParam("Celfocus2015", "Password")
            ));
            if ($sessionKey == null) {
                //session key is missing sending to signify error
                Log::warning("invalid response from the gamification webservices couldnt request session ID");
                return null;
            }
            //making soap call to get new tickets
            $client2 = new SoapClient(NULL,
                ['location' => 'http://193.236.121.122/otrs/nph-genericinterface.pl/Webservice/Gamification?wsdl',
                    'uri' => "http://193.236.121.122/otrs/nph-genericinterface.pl/Webservice/Gamification?wsdl"]);

            $receivedTicketsResponse = $client2->__soapCall("GamificationRanking", array(
                new SoapParam($sessionKey, "SessionID"),
                new SoapParam($thresholdID, "TicketTresholdID")
            ));

            return $receivedTicketsResponse;
        } catch (exception $e) {
            Log::warning("Connection to OTRS WSDL failed.");
        }
    }

    /**
     * This is the start of the point calculation method.
     * The models will be reviewed as points are distributed
     * @return string
     */
    public function updateScorePoints($player_id, $team_id, $points)
    {
        //player and team have already been created if they didn't exist so we know for sure they're there
        User::find($player_id)->updateUser($points);
        Group::find($team_id)->updateTeam($points);
    }

    /*public static function fallbackUserImport($id)
    {
        $dbconn = pg_connect("host=10.200.10.54 port=5432 dbname=otrs user=otrsro password=otrs-ro123.");
        //$dbconn = pg_connect("host=localhost port=5432 dbname=postgres user=otrspg password=root")
        //or die('Could not connect: ' . pg_last_error());
        if($dbconn == false){
            throw new Exception('OTRS DEV server is down');
        }
        try{
            $query = "SELECT u.id, u.login, u.first_name, u.last_name, u.title FROM users u WHERE u.id=$id";
            $result = pg_query($query) or die('Query failed: ' . pg_last_error());
            $resultData = pg_fetch_object($result);
            if($resultData == false){
                return;
            }
            $resultData = json_decode(json_encode($resultData), FALSE);
            $user = new User();
            $user->id = $resultData->id;
            $user->name = $resultData->login;
            $user->email= $resultData->login . "@novabase.com";
            $user->league_id = 1;
            $user->password = bcrypt('password');
            if($resultData->title){ $user->title = $resultData->title; }
            else { $user->title = "novice"; }
            $user->full_name = $resultData->first_name . " " . $resultData->last_name;
            $user->points = 0;
            $user->health_points = 100;
            $user->experience = 0;
            $user->level = 1;
            $user->save();
        }catch(exception $e){
            Log::warning("Connection to OTRS DEV server failed, make sure server(10.200.10.54) is up.");
        }
    }*/

    /*public static function fallbackGroupImport($id)
    {

            $dbconn = pg_connect("host=10.200.10.54 port=5432 dbname=otrs user=otrsro password=otrs-ro123.");
            //$dbconn = pg_connect("host=localhost port=5432 dbname=postgres user=otrspg password=root")
            //or die('Could not connect: ' . pg_last_error());
            if($dbconn == false){
                throw new Exception('OTRS DEV server is down');
            }
        try{
            $query = "SELECT id ,name, comments  FROM groups WHERE id=$id";
            $result = pg_query($query) or die('Query failed: ' . pg_last_error());
            $resultData = pg_fetch_object($result);
            if($resultData == false){
                return;
            }
            $resultData = json_decode(json_encode($resultData), FALSE);
            $group = new Group();
            $group->id = $resultData->id;
            $group->title = $resultData->name;
            $group->variant_name = $resultData->comments;
            $group->points = 0;
            $group->save();
        }catch(exception $e){
            Log::warning("Connection to OTRS DEV server failed, make sure server(10.200.10.54) is up.");
        }
    }*/
}
