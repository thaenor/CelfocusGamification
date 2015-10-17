/**
 * Created by NB21334 / Celfocus 2015.
 *
 * Ticket related functions
 */

function getOpenTicketData(start, end) {
    var link = generateLink('open', start, end);
    getAjaxData(link).done(function (data) {
        _openTicketsData = sortTicketList(data);
        // this block of code used to sort all tickets by priority
        //_openTicketsData.sort(sort_by('priority', false, function (a) {
        //    return a.toUpperCase()
        //}));
        ticketPagination(_openTicketsData);
    }).fail(function () {
        $.toaster({priority: 'danger', title: 'Tickets', message: 'No open tickets to show.'})
    });
}

function sortTicketList(data){
    var p1Array=[], p2Array=[], p3Array=[], p4Array=[];
    $.each(data, function(index, el){
        switch (el.priority) {
            case '1 Critical':
                p1Array.push(el);
                break;
            case '2 High':
                p2Array.push(el);
                break;
            case '3 Medium':
                p3Array.push(el);
                break;
            case '4 Low':
                p4Array.push(el);
                break;
        }
    });
    var endArray = p3Array.concat(p4Array);
    for(var i=0; i<endArray.length; i++){
        //ENHANCEMENT: when the ticket objects contains the element "escalation solution time" update this if
        if(parseFloat(endArray[i].percentage) > 70){
            p2Array.push(endArray[i]);
            endArray.splice(i,1);
        }
    }
    return p1Array.concat(p2Array,endArray);
}

function getResolvedAndReopenedTicketData(start, end) {
    var link = generateLink('resolved', start, end);
    getAjaxData(link).done(function (resolvedData) {
        _resolvedTicketsData = resolvedData;
        renderGroupLeaderBoard(resolvedData);
        /*link = generateLink('reOpened');
         getAjaxData(link).done(function(data){
         _reopenedTicketsData = data;
         }).fail(showAlertMessage('Getting the reopened tickets was a bad idea... I know'));*/
        renderPlayerLeaderBoard(resolvedData);
        //drawMorrisDonnutchart();
    }).fail(function () {
        $.toaster({priority: 'warning', title: 'Leaderboard', message: 'We lost our leaderboard calculator, sorry!'});
    });
}


function replaceAll(find, replace, str) {
    return str.replace(new RegExp(find, 'g'), replace);
}


var sort_by = function (field, reverse, primer) {

    var key = primer ?
        function (x) {
            return primer(x[field])
        } :
        function (x) {
            return x[field]
        };

    reverse = !reverse ? 1 : -1;

    return function (a, b) {
        return a = key(a), b = key(b), reverse * ((a > b) - (b > a));
    }
};
/*
 // Sort by city, case-insensitive, A-Z
 homes.sort(sort_by('city', false, function(a){return a.toUpperCase()}));
 * */

/**
 * Draws a page in the tickets tab. Currently this displays _recPerPage records per page.
 * Both this and leaderBoard page are synced. This means that clicking next will change to page 2 globally.
 * Not sure to view that as a feature or a bug.
 */
function ticketPagination(tickets) {
    $('#ticketList').empty();
    var page = _pagination[_pageTab],
        startRec = Math.max(page - 1, 0) * _recPerPage,
        endRec = Math.min(startRec + _recPerPage, tickets.length);
    var recordsToShow = tickets.slice(startRec, endRec);
    if (recordsToShow.length <= 0) {
        $.toaster({priority: 'warning', title: 'No tickets to show', message: ''});
        return;
    }
    $.each(recordsToShow, function (i, currentTicket) {
        if (currentTicket.priority == "1 Critical") {
            $('#ticketList').append('<li class="list-group-item list-group-item-danger"> <a data-toggle="modal" data-target="#ticketModal" href="#' + currentTicket.id + '">' + currentTicket.title + '</a> <span class="pull-right">' + currentTicket.created_at + '</span> <span class="badge">' + currentTicket.percentage + '%</span> </li>');
        } else if (currentTicket.priority == "2 High") {
            $('#ticketList').append('<li class="list-group-item list-group-item-warning"> <a data-toggle="modal" data-target="#ticketModal" href="#' + currentTicket.id + '">' + currentTicket.title + '</a> <span class="pull-right">' + currentTicket.created_at + '</span> <span class="badge">' + currentTicket.percentage + '%</span> </li>');
        } else if (currentTicket.priority == "3 Medium") {
            $('#ticketList').append('<li class="list-group-item list-group-item-info"> <a data-toggle="modal" data-target="#ticketModal"href="#' + currentTicket.id + '">' + currentTicket.title + '</a> <span class="pull-right">' + currentTicket.created_at + '</span> <span class="badge">' + currentTicket.percentage + '%</span> </li>');
        } else {
            $('#ticketList').append('<li class="list-group-item list-group-item-success"> <a data-toggle="modal" data-target="#ticketModal" href="#' + currentTicket.id + '">' + currentTicket.title + '</a> <span class="pull-right">' + currentTicket.created_at + '</span> <span class="badge">' + currentTicket.percentage + '%</span> </li>');
        }
    });
}


/**
 * Searches the ticket array for the contents of
 * the string received as parameter.
 * if no results are found the single element
 * "no results" is returned
 * this method is only functional on some browsers,
 * to optimize this, use the array.prototype.indexOf()
 * @param searchString - string to be searched
 */
function searchTickets(searchString) {
    var searchResults = [];
    $.each(_openTicketsData, function (index, currentTicket) {
        var lowerCaseTitle = currentTicket.title.toLowerCase();
        searchString = searchString.toLowerCase();
        if (lowerCaseTitle.indexOf(searchString) != -1) {
            searchResults.push(currentTicket);
        }
    });

    if (searchResults.length === 0) {
        searchResults.push('no results');
    }
    return searchResults;
}

function findTicket(ticketArray, ticketId) {
    for (var i = 0; i < ticketArray.length; i++) {
        if (ticketArray[i].id === ticketId) {
            return ticketArray[i];
        }
    }
    return false;
}


function drawMorrisDonnutChart() {
    Morris.Donut({
        element: 'donut-example',
        data: [
            {label: "Open tickets", value: _openTicketsData.length},
            {label: "Resolved tickets", value: _resolvedTicketsData.length},
            {label: "In progress", value: _openTicketsData.length}
        ]
    });
}

function renderPlayerDetailtModal(playerName) {
    var ticketsOwnedByPlayer = findPlayers(_resolvedTicketsData, playerName);
    if (ticketsOwnedByPlayer.length <= 0) {
        $.toaster({priority: 'warning', title: 'No players to show', message: ''});
    } else {
        renderDetailModal(ticketsOwnedByPlayer, "player");
    }
}

function renderTeamDetailModal(teamName) {
    var ticketsOwnedByTeam = findTeamTickets(_resolvedTicketsData, teamName);
    if (ticketsOwnedByTeam.length <= 0) {
        $.toaster({priority: 'warning', title: 'No team data to show', message: ''});
    } else {
        renderDetailModal(ticketsOwnedByTeam, "team");
    }
}

/**
 * data is the array of tickets to analyse and reverse engineer the points
 * pageList is where to display "player" for individual player modal, "team" for team's leaderboard
 * @param data
 * @param pageList
 */
function renderDetailModal(data, pageList) {
    var criticalCount = 0, criticalPointCount = 0, highCount = 0, highPointCount = 0, mediumCount = 0, mediumPointCount = 0, lowCount = 0, lowPointCount = 0;
    var incidentCount = 0, incidentPointCount = 0, problemCount = 0, problemPointCount = 0, serviceRequestCount = 0, srPointCount = 0, slaPenalty = 0, slaOutput = "";

    $.each(data, function (index, el) {
        if (el.percentage > 40) {
            if (el.percentage < 100) {
                //slaPenalty = ( el.points * (el.percentage / 100) );
                //slaPenalty = Math.ceil(slaPenalty);
                slaOutput += "<li class='list-group-item list-group-item-warning'> <em> the ticket <abbr title='" + el.id + "'>" + el.title + "</abbr> is <abbr title='means the sla is getting big'>mouldy</abbr> </em> - " + el.percentage + "% <span class='badge'>" + el.points + " Points earned</span> </br></li>";
            }
            if (el.percentage > 100) {
                //slaPenalty = el.points - (el.points * (el.percentage / 100));
                //slaPenalty = Math.floor(slaPenalty);
                slaOutput += "<li class='list-group-item list-group-item-danger'> <em> the ticket <abbr title='" + el.id + "'>" + el.title + "</abbr> <abbr title='sla went KAPUT!'> blew up!1! </abbr> </em> - " + el.percentage + "% <span class='badge'>" + el.points + " Points Lost</span> </br></li>";
            }
        } else {
            switch (el.priority) {
                case '1 Critical':
                    criticalCount++;
                    criticalPointCount += calculatorPointSettings.p1;
                    break;
                case '2 High':
                    highCount++;
                    highPointCount += calculatorPointSettings.p2;
                    break;
                case '3 Medium':
                    mediumCount++;
                    mediumPointCount += calculatorPointSettings.p3;
                    break;
                case '4 Low':
                    lowCount++;
                    lowPointCount += calculatorPointSettings.p4;
                    break;
                default:
                    points += 0;
                    break;
            }
            switch (el.type) {
                case "Incident":
                    incidentCount++;
                    incidentPointCount += calculatorPointSettings.inc;
                    break;
                case "Service Request":
                    serviceRequestCount++;
                    srPointCount += calculatorPointSettings.serviceReq;
                    break;
                case "Problem":
                    problemCount++;
                    problemPointCount += calculatorPointSettings.prob;
                    break;
                default:
                    points += 0;
                    break;
            }
        }
    });

    if (pageList === "player") {
        $('#playerList').empty().append('A total of ' + data.length + ' tickets solved of which <ul>' +
            '<li class="list-group-item"> point analysis based on priority </li>' +
            '<li class="list-group-item list-group-item-danger">' + criticalCount + ' were P1-Critical <span class="badge">' + criticalPointCount + ' Points</span></li>' +
            '<li class="list-group-item list-group-item-warning">' + highCount + ' were P2 - High <span class="badge">' + highPointCount + ' Points</span></li>' +
            '<li class="list-group-item list-group-item-info">' + mediumCount + ' were P3 - Medium <span class="badge">' + mediumPointCount + ' Points</span></li>' +
            '<li class="list-group-item list-group-item-success">' + lowCount + ' were P4 - Low <span class="badge">' + lowPointCount + ' Points</span></li>' +
            '<li class="list-group-item"> point analysis based on type </li>' +
            '<li class="list-group-item list-group-item-danger">' + incidentCount + ' were incidents <span class="badge">' + incidentPointCount + ' Points</span></li>' +
            '<li class="list-group-item list-group-item-warning">' + problemCount + ' were problems <span class="badge">' + problemPointCount + ' Points</span></li>' +
            '<li class="list-group-item list-group-item-success">' + serviceRequestCount + ' were service requests' +
            ' <span class="badge">' + srPointCount + ' Points</span></li> </ul>'
        );
        if (slaOutput.length > 0) {
            $('#playerList').append(
                '<ul> <li class="list-group-item"> warnings (tickets with penalty) </li>' + slaOutput + '</ul>'
            );
        }
    } else {
        $('#teamList').empty().append('A total of ' + data.length + ' tickets solved of which <ul>' +
            '<li class="list-group-item"> point analysis based on priority </li>' +
            '<li class="list-group-item list-group-item-danger">' + criticalCount + ' were P1-Critical <span class="badge">' + criticalPointCount + ' Points</span></li>' +
            '<li class="list-group-item list-group-item-warning">' + highCount + ' were P2 - High <span class="badge">' + highPointCount + ' Points</span></li>' +
            '<li class="list-group-item list-group-item-info">' + mediumCount + ' were P3 - Medium <span class="badge">' + mediumPointCount + ' Points</span></li>' +
            '<li class="list-group-item list-group-item-success">' + lowCount + ' were P4 - Low <span class="badge">' + lowPointCount + ' Points</span></li>' +
            '<li class="list-group-item"> point analysis based on type </li>' +
            '<li class="list-group-item list-group-item-danger">' + incidentCount + ' were incidents <span class="badge">' + incidentPointCount + ' Points</span></li>' +
            '<li class="list-group-item list-group-item-warning">' + problemCount + ' were problems <span class="badge">' + problemPointCount + ' Points</span></li>' +
            '<li class="list-group-item list-group-item-success">' + serviceRequestCount + ' were service requests <span class="badge">' + srPointCount + ' Points</span></li> </ul>'
        );
        if (slaOutput.length > 0) {
            $('#playerList').append(
                '<ul> <li class="list-group-item"> warnings (tickets with penalty) </li>' + slaOutput + '</ul>'
            );
        }
    }
}

function fooCalculator(ticket) {
    var points = 0;
    switch (ticket.priority) {
        case '1 Critical':
            points += calculatorPointSettings.p1;
            break;
        case '2 High':
            points += calculatorPointSettings.p2;
            break;
        case '3 Medium':
            points += calculatorPointSettings.p3;
            break;
        case '4 Low':
            points += calculatorPointSettings.p4;
            break;
        default:
            points += 0;
            break;
    }
    switch (ticket.type) {
        case "Incident":
            points += calculatorPointSettings.inc;
            break;
        case "Service Request":
            points += calculatorPointSettings.serviceReq;
            break;
        case "Problem":
            points += calculatorPointSettings.prob;
            break;
        default:
            points += 0;
            break;
    }
    if (ticket.percentage > 40) {
        if (ticket.percentage < 100) {
            points = Math.ceil(points * (ticket.percentage / 100));
        } else if (ticket.percentage > 100) {
            points = Math.floor(points - (points * (ticket.percentage / 100)));
        }
    }
    return points
}

function displayTicketPercentage(percentage) {
    var output = "";
    if (percentage > 100) {
        output = "WARNING: expired " + percentage;
    } else if (percentage < 20) {
        output = "early ticket " + percentage;
    } else {
        output = percentage;
    }
    return output;
}

function renderTicketDetailsModal(ticketId) {
    var ticket = findTicket(_openTicketsData, parseInt(ticketId));
    var timeToSolveInHours = parseInt(ticket.sla_time) / 60;
    if (ticket != false) {
        $("#ticketInfo").empty().append('<ul class="list-group">' +
            '<li class="list-group-item"> id: #' + ticket.id + '</li>' +
            '<li class="list-group-item"> title: ' + ticket.title + '</li>' +
            '<li class="list-group-item"> status: ' + ticket.state + '</li>' +
            '<li class="list-group-item"> <b> type: ' + ticket.type + '</b> </li>' +
            '<li class="list-group-item"> <b> priority: ' + ticket.priority + '</b> </li>' +
            '<li class="list-group-item"> <b> sla: ' + ticket.sla + ' </b> <span class="badge">' + displayTicketPercentage(ticket.percentage) + '%</span> </li>' +
            '<li class="list-group-item"> <b> assigned to: ' + ticket.user_id + ' </b> </li>' +
            '<li class="list-group-item"> total time to solve: ' + timeToSolveInHours + 'h ( ' + ticket.sla_time + ' minutes)' +
            ' </li>' +
            '<li class="list-group-item"> team: ' + ticket.assignedGroup_id + '</li>' +
            '<li class="list-group-item"> points: ' + ticket.points + '</li>' +
            '<li class="list-group-item"> created at: ' + ticket.created_at + '</li>' +
            '<li class="list-group-item"> updated at: ' + ticket.updated_at + '</li>' +
            '<li class="list-group-item"> external ID: ' + ticket.external_id + '</li>' +
            '</ul>');
    } else {
        $("#ticketInfo").empty().append('No ticket found');
    }

}