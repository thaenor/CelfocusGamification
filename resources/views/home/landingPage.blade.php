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
    <div class="container-fluid pull-right">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <a class="navbar-brand dropdown-menu-right" href="#">
                <img class="pull-right" alt="brand" id="logo" src="assets/logo.png"/>
            </a>
            <!--<button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>-->

        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
</nav>


<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <h2 class="redMe">Game of tickets</h2>
    <div>
        <div>
            <h4>
                <label id="welcome"></label> Tickets between <b><label id="startTimeLabel" class="well well-sm"></label></b> and <b><label id="endTimeLabel" class="well well-sm"></label></b>
                <!-- time travel -->
                <button class="btn btn-primary btn-sm Mybtn-danger" type="button" data-toggle="modal" data-target="#TimeTravelModal">Adjust dates</button>
            </h4>
        </div>
    </div>

    <!-- top 3 leaderboard -->
    <div>
        <div class="">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
              <div class="col-md-offset-2 col-xs-12 col-sm-8 col-md-8 col-lg-8">
                <ul class="list-inline">
                  <li id="topPlayer1" class="lead col-md-4 text-center"></li>
                  <li id="topPlayer2" class="lead col-md-4 text-center"></li>
                  <li id="topPlayer3" class="lead col-md-4 text-center"></li>
                </ul>
              </div>
              <div class="col-md-offset-2 col-xs-12 col-sm-8 col-md-8 col-lg-8">
                  <img src="assets\podium.jpg" alt="..." class="img-responsive"/>
              </div>
            </div>
        </div>
    </div>
    <!-- end top 3 leaderboard -->

    <div class="tabbable">

        <!-- Nav tabs -->
        <div class="col-md-1 col-xs-6 well well-sm">
            <ul class="nav nav-pills nav-stacked" role="tablist">
                <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab" id="tab1" class="redMe">Top
                        Ranks</a></li>
                <li role="presentation"><a href="#profile" aria-controls="profile" role="tab"
                                           data-toggle="tab" id="tab2" class="redMe">Challenges</a></li>
                <li role="presentation"><a href="#messages" aria-controls="messages" role="tab"
                                           data-toggle="tab" id="tab3" class="redMe">Newsfeed</a></li>
                <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab" id="tab4" class="redMe">Open
                        Tickets</a></li>
            </ul>
        </div>
        <!-- Tab panes -->
        <div class="tab-content col-md-11">
            <div role="tabpanel" class="tab-pane active" id="home">

                <!--------------------------------------------------------------------------------------------->
                <div class="">
                    <div class="col-md-4 col-lg-5">

                        <!-- player ranking -->
                        <h4 class="redMe text-center" >Top 10 - Player ranking</h4>

                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Ranking</th>
                                    <th>Name</th>
                                    <th>Points</th>
                                </tr>
                                </thead>
                                <tbody id='playerLeaderboard'></tbody>
                            </table>
                        </div>
                        <!-- player ranking -->
                    </div>

                    <div class="col-md-offset-1 col-md-4 col-lg-5">

                        <!-- team ranking -->
                        <div id="table-teamleaderboard" class="table-responsive">
                            <h4 class="redMe text-center">Top 10 - Team ranking</h4>

                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Ranking</th>
                                        <th>Name</th>
                                        <th>Points</th>
                                    </tr>
                                    </thead>
                                    <tbody id='teamLeaderboard'></tbody>
                                </table>
                            </div>
                        </div>
                        <!-- team ranking -->

                    </div>
                </div>

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                    <!-- Morris chart -->
                    <div class="col-md-6 col-sm-12 col-xs-12 ">
                        <div class="panel panel-default">
                            <div class="panel-heading ">
                                <label class="redMe text-center">Tickets per status</label>
                            </div>
                            <div class="panel-body">
                                <div id="morris-donut-chart"></div>
                            </div>
                        </div>
                    </div>
                    <!-- END Morris chart -->


                    <!-- Morris chart -->
                    <section>
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="panel panel-default">
                                <div class="panel-heading ">
                                    <label class="redMe text-center">Ticket volume per priority</label>
                                </div>
                                <div class="panel-body">
                                    <div id="morris-priority-quant-chart"></div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- END Morris chart -->

                    <!-- Morris chart -->
                    <section>
                        <div class="col-md-6 col-sm-12 col-xs-12 ">
                            <div class="panel panel-default">
                                <div class="panel-heading ">
                                    <label class="redMe text-center">Ticket volume per type</label>
                                </div>
                                <div class="panel-body">
                                    <div id="morris-type-quant-chart"></div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- END Morris chart -->

                </div>
                <!--------------------------------------------------------------------------------------------->


            </div>
            <div role="tabpanel" class="tab-pane" id="profile" ng-app="todoApp">

                <!--------------------------------------------------------------------------------------------->
                <h4 class="redMe">Challenges</h4>

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
                        <input type="text" ng-model="todoList.todoText" size="30"
                               placeholder="add new reward here">
                        <input class="btn-primary" type="submit" value="add">
                    </form>
                </div>
                <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.7/angular.min.js"></script>
                <script>
                    angular.module('todoApp', [])
                            .controller('TodoListController', function () {
                                var todoList = this;
                                todoList.todos = [
                                    {text: 'Solve 50 tickets - win a beer', done: false},
                                    {text: 'Solve 3 Incidents - win a coffee', done: false}];

                                todoList.addTodo = function () {
                                    todoList.todos.push({text: todoList.todoText, done: false});
                                    todoList.todoText = '';
                                };

                                todoList.remaining = function () {
                                    var count = 0;
                                    angular.forEach(todoList.todos, function (todo) {
                                        count += todo.done ? 0 : 1;
                                    });
                                    return count;
                                };

                                todoList.archive = function () {
                                    var oldTodos = todoList.todos;
                                    todoList.todos = [];
                                    angular.forEach(oldTodos, function (todo) {
                                        if (!todo.done) todoList.todos.push(todo);
                                    });
                                };
                            });
                </script>
                <!--------------------------------------------------------------------------------------------->
                <br/><br/>

            </div>
            <div role="tabpanel" class="tab-pane" id="messages">

                <!--------------------------------------------------------------------------------------------->
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
                <!--------------------------------------------------------------------------------------------->


            </div>
            <div role="tabpanel" class="tab-pane" id="settings">

                <!--------------------------------------------------------------------------------------------->
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
                <nav class="col-xs-12 col-md-12 col-sm-12 col-lg-12">
                    <ul class="pager">
                        <li class="hidden-xs"><a class="pageNumber" href="#"><i class="glyphicon glyphicon-th-list"></i> Page: 1</a></li>
                    </ul>
                </nav>


                <div class="row col-lg-12 col-md-12">
                    <div>
                        <ul class="list-group ">
                            <li class="list-group-item"> Title <span class="pull-right"> Limit time to solve </span></li>
                        </ul>
                        <ul class="list-group " id="ticketList">
                            <!-- LIST WITH TICKETS -->
                        </ul>
                    </div>

                    <!--MID------------------------------------------------------------------------------------------>
                    <nav class="col-xs-12 col-md-12 col-sm-12 col-lg-12">
                        <ul class="pager">
                            <li class="previous"><a href="#"><span>&larr;</span> Previous</a></li>
                            <li class="next"><a href="#">Next <span>&rarr;</span></a></li>
                        </ul>
                    </nav>
                    <!--------------------------------------------------------------------------------------------->


                    <div class="col-md-2 col-lg-2 col-sm-2 pull-right">
                        <ul class="list-group">
                            <li class="list-group-item list-group-item-heading">Legend<a
                                        href="secretRoute/FranciscoSantos-oGajoDeCalcoes">.</a></li>
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



                <div class="clearfix"></div>
                <!--------------------------------------------------------------------------------------------->

            </div>
        </div>

    </div>

</div>


<!--------------------------------------------------------------------------------------------------------------------->
<!--------------------------------------------------------------------------------------------------------------------->
<!--------------------------------------------------------------------------------------------------------------------->
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
                <h4 class="modal-title" id="TimeTravelModalLabel">Adjust dates</h4>
                <h5>Reload the dashboard to display data from a different time. </h5>
            </div>
            <div class="modal-body">
                <div class="btn-group btn-group-sm" role="group">
                    <button id="setTimeWeek" type='button' class='btn btn-lg btn-default '>last week</button>
                    <button id="setTimeMonth" type='button' class='btn btn-lg btn-default '>last month</button>
                </div>
                <p class="text-primary">Adjust the dashboard's dates for this interval&hellip;</p>

                <p class="text-primary">Start Date:
                    <input type="text" id="startDatePicker">
                </p>

                <p class="text-primary">End Date:
                    <input type="text" id="endDatePicker">
                </p>
                <button id="timeTravelTrigger" type="button" class="btn btn-danger">GO!</button>
                <div id='loader'><img src="assets/loader.gif" class="text-center"/></div>
                <label class="text-secundary"><h6><small>After clicking 'Go' you can close the window, we'll do the work
                    for you in the background (just please be patient)</small></h6></label>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- END Modal for time travel panel -->

<footer class="">
    last synchronization time: <%$lastsynctime%> <br/>
    Copyright by Celfocus. Gamification page. All rights reserved.
    <hr/>
    <button type="button" class="btn btn-default" id="AutomationTogler">Disable Automation</button>
    <br/><br/>
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
