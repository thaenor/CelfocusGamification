/**
 * Created by NB21334 / Celfocus 2015.
 *
 * Player related functions
 */

function renderPlayerLeaderBoard(receivedData) {
    var playerArray = {}; //Dictionary like array, will contain [player name][player's points]... etc
    var playerCounter = 0;
    if(receivedData.length < 0){
      $('#playerLeaderboard').empty().append('no players received');
      return false;
    }
    $.each(receivedData, function (index, currentTicket) {
        if (playerArray[currentTicket.user_id] === undefined) {
            playerArray[currentTicket.user_id] = 0;
            playerCounter++;
        }
        //if (currentTicket.points != fooCalculator(currentTicket)){
        //    console.log("ticket: "+currentTicket.points+" foo: "+fooCalculator(currentTicket)+" priority
        // "+currentTicket.priority+" sla "+ currentTicket.percentage+ " type "+currentTicket.type);
        //}
        playerArray[currentTicket.user_id] += fooCalculator(currentTicket);
        //console.log("player: "+currentTicket.user_id+" solved ticket with "+currentTicket.points+" priority"+currentTicket.priority+" type"+currentTicket.type+" sla "+currentTicket.sla_time+"%");
    });
    playerArray ? (showPlayerLeaderBoard(playerArray), countPlayers(playerCounter)) : $.toaster({
        priority: 'danger',
        title: 'Warning',
        message: 'no players exist'
    });
}

function renderMorrisBar_player(dataArray) {
    $("#morris-bar-chart").empty();
    Morris.Bar({
        element: 'morris-bar-chart',
        data: dataArray,
        xkey: 'name',
        ykeys: ['point'],
        labels: ['points'],
        barColors: ['#00203C','#002074','#4D7692'],
        resize: true,
        gridTextColor: '#696361'
    });
}

function countPlayers(size) {
    $('#playersInLeague').empty().append(size);
}

function showPlayerLeaderBoard(array) {
    $('#playerLeaderboard').empty();
    var orderedPlayers = sortByPoints(array);
    var graphData = [];
/*
    $.each(orderedPlayers, function (index, el) {
        if(index === 10){ renderMorrisBar_player(graphData); return false;}
        //$('#playerLeaderboard').append(index + ' ' + el + '<hr/>');
        if((index%2) == 0){
            $('#playerLeaderboard').append('<tr> <td class="lead col-md-1 col-lg-1 col-xm-1 ">' + (index + 1) + '</td> <td class=""> <a href="#"' +
                '  data-toggle="modal" data-target="#playerInfo">' + orderedPlayers[index][0] + '</a></td>' + '<td class="">' + orderedPlayers[index][1] + '</td> </tr>');
        }else
            $('#playerLeaderboard').append('<tr class="greyME"> <td class="lead col-md-1 col-lg-1 col-xm-1">' + (index + 1) + '</td> <td class=""> <a href="#"' +
                '  data-toggle="modal" data-target="#playerInfo">' + orderedPlayers[index][0] + '</a></td>' + '<td class="">' + orderedPlayers[index][1] + '</td> </tr>');

        var obj = {name: orderedPlayers[index][0], point: orderedPlayers[index][1]};
        graphData.push(obj);
    });
*/
    //filling the top three podium
    if(orderedPlayers.length > 3){
        $("#topPlayer1").empty().append(orderedPlayers[0][0]);
        $("#topPlayer2").empty().append(orderedPlayers[1][0]);
        $("#topPlayer3").empty().append(orderedPlayers[2][0]);
    }
    for(var i=3; i< 13 && i<orderedPlayers.length-1; i++){
        if((i%2) == 0){
            $('#playerLeaderboard').append('<tr> <td class="lead col-md-1 col-lg-1 col-xm-1 ">' + (i + 1) + '</td> <td class="col-md-3"> <a href="#"' +
                '  data-toggle="modal" data-target="#playerInfo">' + orderedPlayers[i][0] + '</a></td>' + '<td class="col-md-2">' + orderedPlayers[i][1] + '</td> </tr>');
        }else
            $('#playerLeaderboard').append('<tr class="greyME"> <td class="lead col-md-1 col-lg-1 col-xm-1">' + (i + 1) + '</td> <td class="col-md-3"> <a href="#"' +
                '  data-toggle="modal" data-target="#playerInfo">' + orderedPlayers[i][0] + '</a></td>' + '<td class="col-md-2">' + orderedPlayers[i][1] + '</td> </tr>');

        //var obj = {name: orderedPlayers[i][0], point: orderedPlayers[i][1]};
        //graphData.push(obj);
    }
    //renderMorrisBar_player(graphData);
}

function sortByPoints(array) {
    var sortable = [];
    for (var player in array) {
        sortable.push([player, array[player]]);
        sortable.sort(function (a, b) {
            return b[1] - a[1]
        })
    }
    return sortable;
}

/**
 * Method that finds all tickets that belong to a specific player (playerToFind)
 * It looks into the attribute "user_id" of each ticket which actually contains
 * the name of the user that detains the ticket
 * This assumes no two players have the same name
 *
 * @param array
 * @param playerToFind
 * @returns {Array}
 */
function findPlayers(array, playerToFind) {
    var foundMatches = [];
    for (var i = 0; i < array.length; i++)
        if (array[i].user_id === playerToFind)
            foundMatches.push(array[i]);
    return foundMatches;
}
