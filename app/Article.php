<?php namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Article
 * @package App
 *
 * This class was created for a functionality (newsfeed) that was later abandoned.
 * Automated messages were generated to the newsfeed notifying of level ups and relevant information
 * This was removed to increase performance, as this was called when tickets were being imported and
 * having their points calculated
 */
class Article extends Model {

    public function user()
    {
        return $this->belongsTo('User');
    }

    public function postAutomatedMessageSuccess($user_id, $team, $points)
    {
        $art = new Article();
        $art->author = $user_id;
        $art->title = 'Auto: Points';
        $art->body = 'My team '. $team .' earned '.$points.'!';
        $art->save();
    }

    public function postAutomatedMessageDamage($user_id, $team)
    {
        $art = new Article();
        $art->author = $user_id;
        $art->title = 'Auto: Damage';
        $art->body = 'me and my team ('.$team.') lost 10 HP (team lost 10 points) for cancelling  a ticket :-(';
        $art->save();
    }

    public function postAutomatedMessageLevelUp($user_id, $level){
        $art = new Article();
        $art->author = $user_id;
        $art->title = 'Auto: Lvl UP!';
        $art->body = 'I leveled up I am now level '.$level.'!';
        $art->save();
    }

    public function postAutomatedMessageDead($user_name){
        $art = new Article();
        $art->author = 1; //this is supposed to be the auto bot that posts the message
        $art->title = 'Auto: DED!';
        $art->body = 'Im sorry '. $user_name .' ! you ded!';
        $art->save();
    }
}
