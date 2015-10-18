/**
 * Created by NB21334 / Celfocus 2015.
 *
 * Ticket Premier Leader board app
 */
var _barGraphDesignJson = [];
var _pageTab = "ticket";
var _pagination = [];
_pagination["ticket"] = 1;
_pagination["groupLeaderBoard"] = 1;

var _recPerPage = 10;
var _groupJson;
var _openTicketsData;
var _resolvedTicketsData;
var _reopenedTicketsData;
var allArticles;
var _maxPageOpenTickets;
var _maxPagePlayerLeaderboard;
var calculatorPointSettings = {
    p1: 10,
    p2: 8,
    p3: 3,
    p4: 1,
    inc: 7,
    prob: 10,
    serviceReq: 5
};
var _automationFlag = true;

Array.prototype.clean = function (deleteValue) {
    for (var i = 0; i < this.length; i++) {
        if (this[i] == deleteValue) {
            this.splice(i, 1);
            i--;
        }
    }
    return this;
};
/*Array.prototype.move = function (old_index, new_index) {
    while (old_index < 0) {
        old_index += this.length;
    }
    while (new_index < 0) {
        new_index += this.length;
    }
    if (new_index >= this.length) {
        var k = new_index - this.length;
        while ((k--) + 1) {
            this.push(undefined);
        }
    }
    this.splice(new_index, 0, this.splice(old_index, 1)[0]);
    return this; // for testing purposes
};*/

$(document).ready(function () {
    jQuery.ajaxSetup({
        beforeSend: function () {
            $('#loader').show();
        },
        complete: function () {
            $('#loader').hide();
        },
        success: function () {
        }
    });
    welcome();
    getOpenTicketData();
    getGroupData();
    getResolvedAndReopenedTicketData();
    //getChallenges();
    getArticles();
    renderEvents();
    automator(_automationFlag);
});

function automator(bool) {
    if (bool === true) {
        console.log("automation running...");
        /** Automation made simple. This clicks a random tab every 5 minutes */
        tabSwitcher = setInterval(function () {
            tabClicker();
        }, 300000);
        /**changes page every 2 minutes*/
        pageSwitcher = setInterval(function () {
            var randomBoolean = !(+new Date() % 2);
            (randomBoolean ? $('.next').first().find('a:first').click() : $('.previous').first().find('a:first').click());
        }, 120000);
        pageReloader = setInterval(function () {
            location.reload();
        }, 900000)
    } else {
        console.log("automation stopped.");
        clearInterval(tabSwitcher);
        clearInterval(pageSwitcher);
        clearInterval(pageReloader);
    }
}

$(document).ajaxStop(function () {
    $.toaster({priority: 'info', title: 'Notice', message: 'Information Refreshed'});
    var lenghtOfOpenTicketsArray = _openTicketsData.length;
    $('#ticketNumber').empty().append(lenghtOfOpenTicketsArray);
    _maxPageOpenTickets = Math.ceil(lenghtOfOpenTicketsArray / _recPerPage);
    _maxPagePlayerLeaderboard = Math.ceil(_groupJson.length / _recPerPage);
    drawMorrisDonnutChart();
});

/*function getChallenges(){
 var link = generateLink('getChallengesCount');
 getAjaxData(link).done(function(result){
 $('#challengeCount').empty().append(result);
 }).fail(function(){
 $.toaster({ priority : 'warning', title : 'Challenges', message : 'failed to count'});
 });
 }*/

function getArticles() {
    $('#articleList').empty();
    var link = generateLink('articles');
    getAjaxData(link).done(function showArticles(data) {
        allArticles = data;
        displayArticles(data);
    }).fail(function () {
        $.toaster({priority: 'warning', title: 'Newsfeed', message: 'no articles to show'});
    });
}

function displayArticles(data) {
    $.each(data, function (i, currentArticle) {
        $('#articleList').append('<li class="list-group-item">' + currentArticle.author + ' : ' + currentArticle.body + '</li>');
    });
}

function updatePageNumber() {
    $('.pageNumber').empty().append('<i class="glyphicon glyphicon-th-list"></i> Page: ' + _pagination[_pageTab]);
}

function welcome() {
    var now = new Date();
    var greeting = "Good" + ((now.getHours() > 17) ? " evening" : " day");
    $('#welcome').append(greeting + ' - ');
    $('#timeTravelTrigger').prop('disabled', true);
    appendPageElements();
}

function tabClicker() {
    var tabbedArray = ["#ticket-tab", /*"#newsfeed-tab",*/ /*"#groupLeaderboard-tab",*/ "#player-leaderboard-tab",
        "#graph-tab", "#team-leaderboard-tab"];
    var selectedTabIndex = Math.floor((Math.random() * tabbedArray.length));
    var buttonToClick = tabbedArray[selectedTabIndex];
    $(buttonToClick).click();
}

/* these warning messages have been replaced with toaster - http://www.jqueryscript.net/other/jQuery-Bootstrap-Based-Toast-Notification-Plugin-toaster.html

 function showTicketErrorMessage() {
 $('#ticketList').empty().append('<div class="alert alert-danger" role="alert">Something went wrong... these aren\'t the tickets you are looking for...</div>');
 }

 function showAlertMessage(message){
 var html = '<div class="alert alert-warning alert-dismissible fade in" role="alert" data-spy="affix" data-offset-top="60" data-offset-bottom="200">'+
 '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>'+
 '<strong>Holy guacamole!</strong> '+message+' </div>';
 $('#notificationBox').append(html);
 }
 */