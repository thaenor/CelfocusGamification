/**
 * Created by NB21334 / Celfocus 2015.
 *
 * Group related functions.
 */

function getGroupData(start, end) {
    var link = generateLink('groups', start, end);
    getAjaxData(link).done(function (data) {
        _groupJson = removeEntriesWithZero(data).clean();
        //sort groups by points. So highest scoring comes first
        _groupJson.sort(function (a, b) {
            return parseFloat(b.points) -
                parseFloat(a.points)
        });
        leaderBoardPagination(_groupJson);
        //$('#notificationBox').empty().append('<p></p>');
    }).fail(function () {
        $.toaster({priority: 'danger', title: 'Internal Error', message: 'Getting team score blew up the server!'});
    });
}

function removeEntriesWithZero(array) {
    $.each(array, function (index, element) {
        if (parseInt(element.points) === 0) {
            delete array[index];
        }
    });
    return array;
}

function renderGroupLeaderBoard(data) {
    var teamsArray = {}; //Dictionary like array, will contain [team name][team's points]... etc
    $.each(data, function (index, currentTicket) {
        if (teamsArray[currentTicket.assignedGroup_id] == null) {
            teamsArray[currentTicket.assignedGroup_id] = 0;
        }
        //if (currentTicket.points != fooCalculator(currentTicket)){
        //    console.log("ticket: "+currentTicket.points+" foo: "+fooCalculator(currentTicket)+" priority
        // "+currentTicket.priority+" sla "+ currentTicket.percentage+ " type "+currentTicket.type);
        //}
        teamsArray[currentTicket.assignedGroup_id] += fooCalculator(currentTicket);
    });
    teamsArray ? (reDisplayGroupLeaderBoard(teamsArray)) : showGroupLeaderBoardError();
}

function renderMorrisBar_Team(dataArray) {
    $("#morris-Teambar-chart").empty();
    Morris.Bar({
        element: 'morris-Teambar-chart',
        data: dataArray,
        xkey: 'name',
        ykeys: ['point'],
        labels: ['points'],
        barColors: ['#00203C','#002074','#4D7692'],
        resize: true,
        gridTextColor: '#8C1213'
    });
}

function reDisplayGroupLeaderBoard(array) {
    $('#teamLeaderboard').empty();
    //$('.hidden-sm').remove();
    var orderedTeams = sortByPoints(array);
    var graphData = [];
    $.each(orderedTeams, function (index, el) {
        if(index === 10){ renderMorrisBar_Team(graphData); return false;}
        if((index%2) == 0) {
            $('#teamLeaderboard').append('<tr> ' +
                '<td class="col-md-1 col-lg-1 col-xm-1 ">' + (index + 1) + '</td> ' +
                '<td class=""> <a data-toggle="modal" data-target="#TeamInfo">' + el[0] + '</a></td>' +
                '<td class="">' + el[1] + '</td> </tr>');
        }else{
            $('#teamLeaderboard').append('<tr class="greyME"> ' +
                '<td class="col-md-1 col-lg-1 col-xm-1 ">' + (index + 1) + '</td> ' +
                '<td class=""> <a data-toggle="modal" data-target="#TeamInfo">' + el[0] + '</a></td>' +
                '<td class="">' + el[1] + '</td> </tr>');
        }
        var obj = {name: el[0], point: el[1]};
        graphData.push(obj);
    });
    renderMorrisBar_Team(graphData);
    //$('#groupLeaderBoardNav').hide();
}

function showGroupLeaderBoardError() {
    $("#table-resp").empty().append('No data was returned from the server. The cleaning lady did it again!');
}


/**
 * Draws a page in the leaderBoard. Currently this displays _recPerPage records per page
 */
function leaderBoardPagination(groups) {
    $('#grouplist').empty();

    var page = _pagination[_pageTab],
        startRec = Math.max(page - 1, 0) * _recPerPage,
        endRec = Math.min(startRec + _recPerPage, groups.length);
    var recordsToShow = groups.slice(startRec, endRec);

    // loop through the array to populate your list
    $.each(recordsToShow, function (i, currentGroup) {
        // alternative - output data has a list. adds an option tag to your existing list
        //$('#yourlist').append(new Option( currentAirport.airport_name )); adds option tags with item
        //$('#grouplist').append('<li>'+ '<a href="#profile"" data-toggle="tab">'+ currentGroup.title + '</a>' +'</li>'); print names in list
        //draws has table. Column "variant name" is hidden on smaller screens
        $('#grouplist').append('<tr> ' +
            '<td class="success">' + currentGroup.title + '</td>' +
            '<td class="info hidden-xs hidden-sm">' + currentGroup.variant_name + '</td>' +
            '<td class="warning">' + currentGroup.points + '</td> </tr>');
    });
}


function findTeamTickets(array, teamToFind) {
    var foundMatches = [];
    for (var i = 0; i < array.length; i++)
        if (array[i].assignedGroup_id === teamToFind)
            foundMatches.push(array[i]);
    return foundMatches;
}


/**
 * (Re)draws Morris bar graph displaying all teams.
 * Each time a new page is opened the old graphs aren't removed, to do that you'd have to either remove them
 * Or supply a copy of _barGraphDesignJson with only the desired data
 * */
function drawMorrisBarGraph_Team() {
    $('#morris-bar-chart').empty();

    Morris.Bar({
        element: 'morris-bar-chart',
        data: _barGraphDesignJson,
        xkey: 'y',
        ykeys: ['a'],
        labels: ['Group name']
    });
}


/**
 * Fills global array @_barGraphDesignJson with name and points of each group.
 * This array will later be used by Morris lib to draw the graph
 */
function fillBarGraphData(title, points) {
    var tmp = {};
    tmp.y = title;
    tmp.a = points;
    _barGraphDesignJson.push(tmp);
}
