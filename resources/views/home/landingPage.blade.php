<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <!--<meta http-equiv="refresh" content="300">-->

    <title>Celfocus Gamification</title>
    <!-- includes at head-->
    <link href="assets/css/animations.css" rel="stylesheet">
    <!-- Bootstrap jquery Styles-->
    <link href="assets/jquery-ui-1.11.4/jquery-ui.css" rel="stylesheet">
    <link href="assets/jquery-ui-1.11.4/jquery-ui.theme.css" rel="stylesheet">
    <link href="assets/bootstrap-3.3.4/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Styles-->
    <link href="assets/css/font-awesome.css" rel="stylesheet">
    <!-- Morris Chart Styles-->
    <link href="assets/css/morris-0.4.3.min.css" rel="stylesheet">
    <!-- Custom Styles-->
    <link href="assets/css/custom-styles.css" rel="stylesheet">
    <!-- Google Fonts-->
    <!--<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>-->
    <link href='assets/css/font/font.css' rel='stylesheet' type='text/css'>
    <!-- outdated browser pluggin-->
    <link href="assets/css/outdatedbrowser.min.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
<div id="outdated">
</div>

<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">
                <img alt="brand" id="logo" src="assets/logo.png" class="hatch"/>
            </a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <!--<li class="disabled"><a href="#"><i class="glyphicon glyphicon-user"></i> My stats</a></li>-->
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Backend access <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="/tickets"><i class="glyphicon glyphicon-th-list"></i> all tickets</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="/articles"><i class="glyphicon glyphicon-tasks"></i> all articles</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="/groups"><i class="glyphicon glyphicon-eye-open"></i> all teams</a></li>
                    </ul>
                </li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li>
                    <!-- time travel -->
                    <button class="btn btn-primary btn-danger btn-lg navbar-btn" type="button" data-toggle="modal" data-target="#TimeTravelModal">
                        Time travel
                    </button>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Settings <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li class="button"><a href="/auth/login">Login</a></li>
                        <li role="separator" class="divider"></li>
                        <li class="disabled"><a href="/auth/logout">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>



<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <div>
                <div>
                    <ul class="list-inline">
                        <li>
                            <h4><label id="welcome" class="text-muted"></label> Tickets between <b><label id="startTimeLabel"></label></b> and <b><label
                                            id="endTimeLabel"></label></b></h4>
                        </li>
                        <li class="pull-right hidden-xs">
                            <div class="noti-box">
                                <span class="icon-box bg-color-red set-icon">
                                <i class="glyphicon glyphicon-bell"></i>
                                </span>
                                <div class="text-box text-center">
                                    <label id="ticketNumber" class="main-text"></label>
                                </div>
                            </div>
                        </li>
                        <li class="pull-right hidden-xs">
                            <div class="noti-box">
                                <span class="icon-box bg-color-red set-icon">
                                    <i class="glyphicon glyphicon-user"></i>
                                </span>
                                <div class="text-box text-center">
                                    <label id="playersInLeague" class="main-text"></label>
                                </div>
                            </div>
                        </li>
                        <li class="pull-right hidden-xs">
                            <div class="noti-box">
                                <span class="icon-box bg-color-red set-icon">
                                    <i class="glyphicon glyphicon-cog" data-toggle="modal"
                                       data-target="#settingsPointCalc"></i>
                                </span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <ul class="nav nav-pills nav-justified" id="mainMenuNav">
                <li class="active"><a id="ticket-tab" data-toggle="tab" href="#ticketDisplayScreen">Tickets</a></li>
                <li class=""><a data-toggle="tab" href="#rewards">Rewards</a></li>
                <li class=""><a id="newsfeed-tab" data-toggle="tab" href="#newsfeed">Newsfeed</a></li>
                <li class="disabled"><a id="hofteams-tab" data-toggle="tab" href="#HoFleaderboard">Team's Hall
                        of Fame</a></li>
                <li class=""><a id="player-leaderboard-tab" data-toggle="tab" href="#Pleaderboard">Player Leaderboard</a></li>
                <li class=""><a id="team-leaderboard-tab" data-toggle="tab" href="#Tleaderboard">Team
                        Leaderboard</a></li>
                <li class=""><a id="graph-tab" data-toggle="tab" href="#Graphs">Graphs</a></li>
            </ul>
        </div>

        <div class="panel-body">
            <div class="tab-content">
                <!-- TAB CONTENT FOR open ticket list-->
                <div class="tab-pane fade active in" id="ticketDisplayScreen">
                    <nav class="col-xs-12 col-md-12 col-sm-12 col-lg-12">
                        <ul class="pager">
                            <li class="previous">
                                <a href="#">
                                    <span>&larr;</span> Previous</a>
                            </li>

                            <li class="hidden-xs">
                                <a class="pageNumber" href="#">
                                    <i class="glyphicon glyphicon-th-list"></i> Page: 1</a>
                            </li>


                            <li class="next">
                                <a href="#">Next <span>&rarr;</span></a>
                            </li>
                        </ul>
                        <!-- search bar -->
                        <div class="col-md-6 col-sm-12 col-lg-6">
                            <div class="input-group">
                                <div class="input-group">
                                    <span class="input-group-addon glyphicon glyphicon-search" id="sizing-addon1"></span>
                                    <input class="form-control" id="ticketSearchField" placeholder="Search for..."
                                           type="text">
                                </div>
                            </div>
                            <!-- /input-group -->
                        </div>
                        <!-- END search bar -->
                        <label class="text-muted">click a ticket to view in more detail.
                        The scope of data is filtered by date of creation</label>
                    </nav>



                    <div class="row col-lg-12 col-md-12">
                        <div>
                            <ul class="list-group pullUp">
                                <li class="list-group-item"> Title <span class="pull-right"> Creation date </span></li>
                            </ul>
                            <ul class="list-group pullUp" id="ticketList">
                                <!-- LIST WITH TICKETS -->
                            </ul>
                        </div>
                        <div class="col-md-2 col-lg-2 col-sm-2 pull-right">
                            <ul class="list-group">
                                <li class="list-group-item list-group-item-heading">Legend<a href="secretRoute/FranciscoSantos-oGajoDeCalcoes">.</a></li>
                                <li class="list-group-item list-group-item-danger">Red - Critical (P1)</li>
                                <li class="list-group-item list-group-item-warning">Yellow - High (P2)</li>
                                <li class="list-group-item list-group-item-info">Blue - Medium (P3) </li>
                                <li class="list-group-item list-group-item-success">Green - Low (P4)</li>
                            </ul>
                        </div>
                        <!--<div class="col-lg-7">
                        This div might be used to display more information
                        </div>-->
                    </div>

                </div>
                <!-- TAB CONTENT FOR rewards - in development-->
                <div class="tab-pane fade well center" id="rewards" ng-app="todoApp">
                    <h2>Reward</h2>
                    <div ng-controller="TodoListController as todoList">
                        <span>{{todoList.remaining()}} of {{todoList.todos.length}} remaining</span>
                        [ <a href="" ng-click="todoList.archive()">archive</a> ]
                        <ul class="unstyled">
                            <li ng-repeat="todo in todoList.todos">
                                <input type="checkbox" ng-model="todo.done">
                                <span class="done-{{todo.done}}">{{todo.text}}</span>
                            </li>
                        </ul>
                        <form ng-submit="todoList.addTodo()">
                            <input type="text" ng-model="todoList.todoText"  size="30"
                                   placeholder="add new reward here">
                            <input class="btn-primary" type="submit" value="add">
                        </form>
                    </div>
                    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.7/angular.min.js"></script>
                    <script>
    angular.module('todoApp', [])
            .controller('TodoListController', function() {
                var todoList = this;
                todoList.todos = [
                    {text:'Solve 50 tickets - win a beer', done:false},
                    {text:'Solve 3 Incidents - win a coffee', done:false}];

                todoList.addTodo = function() {
                    todoList.todos.push({text:todoList.todoText, done:false});
                    todoList.todoText = '';
                };

                todoList.remaining = function() {
                    var count = 0;
                    angular.forEach(todoList.todos, function(todo) {
                        count += todo.done ? 0 : 1;
                    });
                    return count;
                };

                todoList.archive = function() {
                    var oldTodos = todoList.todos;
                    todoList.todos = [];
                    angular.forEach(oldTodos, function(todo) {
                        if (!todo.done) todoList.todos.push(todo);
                    });
                };
            });
</script>

                </div>

                <!-- TAB CONTENT FOR newsfeed-->
                <div class="tab-pane fade" id="newsfeed">
                    <h4>Newsfeed</h4>

                    <section>
                        <div class='form-group'>
                            <div class="col-md-12 col-sm-12 col-lg-12">
                                <ul id="articleList" class="list-group">
                                </ul>
                            </div>
                            <br/>
                            <input type="text" class="form-control" id="writtenFeed"
                                   placeholder="What's on your mind...">

                        </div>
                        <button type="submit" id="postFeed" class="btn btn-danger">Post</button>

                    </section>


                </div>

                <!-- TAB CONTENT FOR Hall of Fame for teams-->
                <div class="tab-pane fade" id="HoFleaderboard">
                    <h4>Leaderboard</h4>
                    <!-- HoF leaderboard -->

                    <div class="col-md-12">
                        <!--    Context Classes  -->


                        <div class="panel panel-default">
                            <div class="panel-heading" id="leaderboard">
                                Team's Hall of Fame <br/>
                                <em class="text-muted">(the hall of fame is immune to time travel)</em>
                            </div>


                            <nav id="groupLeaderBoardNav">
                                <ul class="pager">
                                    <li class="previous">
                                        <a href="#">
                                            <span>&larr;</span>
                                            Previous</a>
                                    </li>

                                    <li class="hidden-xs">
                                        <a class="pageNumber" href="#">
                                            <i class="glyphicon glyphicon-th-list"></i> Page: 1</a>
                                    </li>

                                    <li class="next">
                                        <a href="#">Next <span>&rarr;</span></a>
                                    </li>
                                </ul>
                            </nav>


                            <div class="panel-body">
                                <div id="HoF-teamleaderboard" class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th class="hidden-xs hidden-sm">Description</th>
                                            <th>Points</th>
                                        </tr>
                                        </thead>


                                        <tbody id='grouplist'></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!--  end  Context Classes  -->
                    </div>
                    <!-- END group leaderboard -->
                </div>

                <!-- TAB CONTENT FOR player's leaderboard-->
                <div class="tab-pane fade" id="Pleaderboard">
                    <div class="panel-heading">
                        <h4>Player leaderboard</h4>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Points</th>
                            </tr>
                            </thead>

                            <tbody id='playerLeaderboard'></tbody>
                        </table>
                    </div>
                </div>

                <!-- TAB CONTENT FOR Team's leaderboard-->
                <div class="tab-pane fade" id="Tleaderboard">
                    <div class="panel-heading">
                        <h4>Team leaderboard</h4>
                    </div>
                    <div id="table-teamleaderboard" class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Points</th>
                            </tr>
                            </thead>

                            <tbody id='teamLeaderboard'></tbody>
                        </table>
                    </div>
                </div>

                <!-- TAB CONTENT FOR GRAHPS-->
                <div class="tab-content fade" id="Graphs">
                    <section>
                        <section>
                            <!-- Morris chart -->
                            <div class="col-md-6 col-sm-12 col-xs-12 ">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        Team's point score
                                    </div>


                                    <div class="panel-body">
                                        <div id="morris-bar-chart">
                                        </div>
                                        <hr/>
                                        <div id="morris-Teambar-chart">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END Morris chart -->
                        </section>

                        <!-- Morris chart -->
                        <section>
                            <div class="col-md-6 col-sm-12 col-xs-12 ">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        Tickets per status
                                    </div>
                                    <div class="panel-body">
                                        <div id="donut-example"></div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <!-- END Morris chart -->
                    </section>
                </div>

            </div>
        </div>
    </div>
</div>

<!--
<div id="notificationBox" class="col-md-5 col-sm-6 col-lg-6 col-md-offset-2 col-lg-offset-5
col-sm-offset-2"></div>
-->


<!--------------------------------------------------------------------------------------------------------------------->
<!--------------------------------------------------------------------------------------------------------------------->
<!--------------------------------------------------------------------------------------------------------------------->
<!-- Modal With settings for point calculation -->
<div class="modal fade" id="settingsPointCalc" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Point Calculation settings</h4>
            </div>
            <div class="modal-body">
                <form role="form">
                    <div class="form-group">
                        <label for="p1Critical">How many points is a P1 (Critical) ticket worth:</label>
                        <input type="number" class="form-control" id="p1PointVal" value="10" name="quantity" min="1"
                               max="100">
                    </div>
                    <div class="form-group">
                        <label for="p2High">How many points is a P2 (High) ticket worth:</label>
                        <input type="number" class="form-control" id="p2PointVal" value="8" name="quantity" min="1"
                               max="100">
                    </div>
                    <div class="form-group">
                        <label for="p3Medium">How many points is a P3 (Medium) ticket worth::</label>
                        <input type="number" class="form-control" id="p3PointVal" value="3" name="quantity" min="1"
                               max="100">
                    </div>
                    <div class="form-group">
                        <label for="p4Low">How many points is a P4 (Low) ticket worth::</label>
                        <input type="number" class="form-control" id="p4PointVal" value="1" name="quantity" min="1"
                               max="100">
                    </div>
                    <div class="form-group">
                        <label for="inc">How many points is an Incident ticket worth::</label>
                        <input type="number" class="form-control" id="incidentPointVal" value="7" name="quantity"
                               min="1"
                               max="100">
                    </div>
                    <div class="form-group">
                        <label for="problem">How many points is a problem ticket worth::</label>
                        <input type="number" class="form-control" id="problemPointVal" value="10" name="quantity" min="1"
                               max="100">
                     </div>
                    <div class="form-group">
                        <label for="serviceRequest">How many points is a service request ticket worth::</label>
                        <input type="number" class="form-control" id="serviceReqPointVal" value="5" name="quantity"
                               min="1"
                               max="100">
                    </div>
                    <button id="pointSettingSubmit" type="submit" class="btn btn-default">Submit</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- END Modal settings -->

<!-- Modal for player info -->
<div class="modal fade" id="playerInfo" tabindex="-1" role="dialog" aria-labelledby="playerModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div id="playerDetails" class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="playerModalLabel">Player details</h4>
            </div>
            <div class="modal-body">
                <!--                <table class="table">
                                  <thead>
                                    <tr>
                                      <th>Priority</th>
                                      <th>Tickets</th>
                                      <th>Points</th>
                                    </tr>
                                  </thead>
                                  <tbody id='playerlist'></tbody>
                                </table> -->
            </div>
            <div id="playerList" class="list-group col-lg-12 col-md-12 col-sm-12 col-xs-12"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for team info -->
<div class="modal fade" id="TeamInfo" tabindex="-1" role="dialog" aria-labelledby="TeamModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div id="teamDetails" class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="teamModalLabel">Team details</h4>
            </div>
            <div class="modal-body">
                <!--                <table class="table">
                                  <thead>
                                    <tr>
                                      <th>Priority</th>
                                      <th>Tickets</th>
                                      <th>Points</th>
                                    </tr>
                                  </thead>
                                  <tbody id='playerlist'></tbody>
                                </table> -->
            </div>
            <div id="teamList" class="list-group col-lg-12 col-md-12 col-sm-12 col-xs-12"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for ticket info -->
<div class="modal fade" id="ticketModal" tabindex="-1" role="dialog" aria-labelledby="ticketModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div id="ticketDetails" class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="ticketModalLabel">Ticket details</h4>
            </div>
            <div id="ticketInfo" class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- END Modal for ticket info -->

<!-- Modal for time travel panel -->
<div class="modal fade" id="TimeTravelModal" tabindex="-1" role="dialog" aria-labelledby="TimeTravelModalLabel"
aria-hidden="true">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="TimeTravelModalLabel">Time Travel</h4>
                <h5>Reload the dashboard to display data from a different time. </h5>
            </div>
            <div class="modal-body">
                    <div class="btn-group btn-group-sm" role="group">
                        <button id="setTimeWeek" type='button' class='btn btn-lg btn-default '>last week</button>
                        <button id="setTimeMonth" type='button' class='btn btn-lg btn-default '>last month</button>
                    </div>
                    <p class="text-primary">Time travel the dashboard for this interval&hellip;</p>

                    <p class="text-primary">Start Date:
                        <input type="text" id="startDatePicker">
                    </p>

                    <p class="text-primary">End Date:
                        <input type="text" id="endDatePicker">
                    </p>
                    <button id="timeTravelTrigger" type="button" class="btn btn-danger">GO!</button>
                    <div id='loader'><img src="assets/loader.gif" class="text-center"/></div>
                <label class="text-secundary text-muted">After clicking 'Go' you can close the window, we'll do the work for you in the background (just please be patient)</label>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- END Modal for time travel panel -->

<footer class="">
    <button type="button" class="btn btn-default" id="AutomationTogler">Disable Automation</button>
    <br/>
    last synchronization time: <%$lastsynctime%> <br />
    Copyright by Celfocus. Gamification page. All rights reserved.
</footer>
<!-- js includes before closing body -->
<script src="assets/js/jquery-2.1.4.min.js"></script>
<script src="assets/bootstrap-3.3.4/js/bootstrap.min.js"></script>
<!-- not needed if jquery 2 works fine <script src="assets/js/jquery-1.10.2.js"></script> -->

<!-- JQuerry currently not being used but may come in handy in the future-->
<script src="assets/jquery-ui-1.11.4/jquery-ui.js"></script>
<!-- <script src="assets/videojs/dist/video-js/video.js"></script>-->
<script src="assets/js/morris/raphael-2.1.0.min.js"></script>
<script src="assets/js/morris/morris.js"></script>
<script src="assets/js/moment.js" charset="utf-8"></script>
<script src="assets/js/toaster/jquery.toaster.js" charset="utf-8"></script>
<!-- Extra js for Object Oriented implementation -->
<script src="assets/js/custom/ajax.js" type="text/javascript"></script>
<script src="assets/js/custom/group.js" type="text/javascript"></script>
<script src="assets/js/custom/ticket.js" type="text/javascript"></script>
<script src="assets/js/custom/events.js" type="text/javascript"></script>
<script src="assets/js/custom/player.js" type="text/javascript" charset="utf-8"></script>
<script src="assets/js/custom/main.js" type="text/javascript"></script>
<script src="assets/js/outdatedbrowser.min.js"></script>
<script>
    /**
     *   OutdatedBrowser function. Displays
     *   warning message is the user is in an outdated browser
     */
    $(document).ready(function () {
        outdatedBrowser({
            bgColor: '#f25648',
            color: '#ffffff',
            lowerThan: 'transform',
            languagePath: 'assets/en.html'
        })
    })
</script>
</body>

</html>
