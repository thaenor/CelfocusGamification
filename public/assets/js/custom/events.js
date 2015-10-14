/**
 * Created by NB21334 / Celfocus 2015.
 *
 * jQuery event handling
 * */

 /**
 * appends html dynamic dates and the number of tickets open.
 * Must only be run once all the ajax requests are completed
 */
 function appendPageElements(){
     $('#startTimeLabel').append(moment().startOf('month').format('MMMM Do YYYY'));
     $('#endTimeLabel').append(moment().format('MMMM Do YYYY'));
     //$('#ticketNumber').empty().append(_openTicketsData.length);
 }


 function renderEvents() {

    /**
     * Click event on next button in pagination
     * This code handles all "next" buttons
     * Please refer to the global variables to
     * see what each one holds
     */
    $(".next").click(function (event) {
        event.preventDefault();
        _pagination[_pageTab]++;
        switch (_pageTab) {
            case 'ticket':
                if(_pagination[_pageTab] > _maxPageOpenTickets){
                    _pagination[_pageTab]--;
                    $.toaster({ priority : 'warning', title : 'Notice', message : 'no more pages to show'});
                }
                ticketPagination(_openTicketsData);
                break;
            case 'groupLeaderBoard':
                if(_pagination[_pageTab] > _maxPagePlayerLeaderboard){
                    _pagination[_pageTab]--;
                    $.toaster({ priority : 'warning', title : 'Notice', message : 'no more pages to show'});
                }
                //_barGraphDesignJson = [];
                leaderBoardPagination(_groupJson);
                //drawMorrisBarGraph();
                break;
            default:
                console.error('invalid key in pagination');
        }
        updatePageNumber();
    });


    /**
     * Click event on next button in pagination
     *
     */
    $(".previous").click(function (event) {
        event.preventDefault();
        _pagination[_pageTab]--;
        if(_pagination[_pageTab] <= 0){
            _pagination[_pageTab]++;
            $.toaster({ priority : 'warning', title : 'Notice', message : 'no more pages to show'});
        }
        updatePageNumber();
        switch (_pageTab) {
            case 'ticket':
                ticketPagination(_openTicketsData);
                break;
            case 'groupLeaderBoard':
                _barGraphDesignJson = [];
                leaderBoardPagination(_groupJson);
                drawMorrisBarGraph();
                break;
            default:
                console.error('invalid key in pagination');
        }
    });


    $('#ticket-tab').click(function () {
        _pageTab = "ticket";
        updatePageNumber();
    });
    $('#hofteams-tab').click(function () {
        _pageTab = "groupLeaderBoard";
        updatePageNumber();
    });


    /** search event handling */
    $("#ticketSearchField").keyup(function () {
        _pagination["ticket"] = 1;
        _pagination["groupLeaderBoard"] = 1;
        updatePageNumber();
        var searchResults = searchTickets($("#ticketSearchField").val());
        if (searchResults[0] == 'no results') {
            $('#ticketList').empty().append("<p class=\"well\">Sorry, these aren't the tickets you are looking for</p>");
        } else {
            ticketPagination(searchResults);
        }
    });


    /** Date pickers for advanced search*/
    $(function () {
        $("#startDatePicker").datepicker({
            dateFormat: "yy-mm-dd"
        });
        $("#endDatePicker").datepicker({
            dateFormat: "yy-mm-dd"
        });
    });


    /** simple validation (if dates are inserted)*/
    $("#startDatePicker, #endDatePicker").change(function () {
        if ($("#startDatePicker").val() && $('#endDatePicker').val()) {
            $('#timeTravelTrigger').removeAttr('disabled');
        }
    });


    /** renewing all ajax calls */
    $("#timeTravelTrigger").click(function () {
        var start = replaceAll('/', '-', $('#startDatePicker').val());
        var end = replaceAll('/', '-', $('#endDatePicker').val());
        var now = new Date();
        if( Date.parse(start) < Date.parse(end) && Date.parse(start) < now) {
            _pagination["ticket"] = 1;
            _pagination["groupLeaderBoard"] = 1;
            updatePageNumber();
            $("#donut-example").empty();
            getOpenTicketData(start, end);
            var link = generateLink('resolved',start, end);
            getAjaxData(link).done(function(data){
                _resolvedTicketsData = data;
                renderPlayerLeaderBoard(data);
                renderGroupLeaderBoard(data);
                $('#startTimeLabel').empty().append(start);
                $('#endTimeLabel').empty().append(end);
            }).fail(function(){
                $.toaster({ priority : 'danger', title : 'Internal Error', message : 'No closed/resolved tickets received'});
            });
        }else{
            alert('You set the "End Date" lower than the start date, or the start date is in the future. Please make sure the dates are correct');
        }
        
    });


    /** set default time-travel values for last week */
    $("#setTimeWeek").click(function () {
        $("#startDatePicker").val(moment().weekday(-7).format('YYYY[-]MM[-]DD')); // last Monday
        $('#endDatePicker').val(moment().weekday(-2).format('YYYY[-]MM[-]DD')); //Last Friday
        $('#timeTravelTrigger').prop('disabled', false);
    });
    /** set default time-travel values for last month */
    $("#setTimeMonth").click(function () {
        $("#startDatePicker").val(moment().subtract(1, 'months').startOf('month').format('YYYY[-]MM[-]DD'));
        $('#endDatePicker').val(moment().subtract(1, 'months').endOf('month').format('YYYY[-]MM[-]DD'));
        $('#timeTravelTrigger').prop('disabled', false);
    });


    /** Button event to post feed */
    $("#postFeed").click(function(){
        var post = $('#writtenFeed').val();
        if(post){
            //TODO: make ajax call to post feed
            $('#articleList').append('<li class="list-group-item">'+ 'You : ' +post + '</li>');
        } else {
            $.toaster({ priority : 'warning', title : 'Newsfeed', message : 'Please write something'});
        }
        $('#writtenFeed').val("");
    });

     /** point settings calculation modal event handling*/
     $("#pointSettingSubmit").click(function(e){
         e.preventDefault();
         var p1 = $("#p1PointVal").val();
         var p2 = $("#p2PointVal").val();
         var p3 = $("#p3PointVal").val();
         var p4 = $("#p4PointVal").val();

         var inc = $("#incidentPointVal").val();
         var problem = $("#problemPointVal").val();
         var serviceReq = $("#serviceReqPointVal").val();
         if(p1===""||p2===""||p3===""||p4===""||inc===""||problem===""||serviceReq === "") {
             $.toaster({ priority : 'warning', title : 'point settings', message : 'you did not fill the entire' +
             ' form'});
             return true;
         }
         if(parseInt(p1)>0||parseInt(p2)>0||parseInt(p3)>0||parseInt(p4)>0||parseInt(inc)>0||parseInt(problem)>0||parseInt(serviceReq )>0) {
             calculatorPointSettings.p1 = parseInt(p1);
             calculatorPointSettings.p2 = parseInt(p2);
             calculatorPointSettings.p3 = parseInt(p3);
             calculatorPointSettings.p4 = parseInt(p4);
             calculatorPointSettings.inc = parseInt(inc);
             calculatorPointSettings.prob = parseInt(problem);
             calculatorPointSettings.serviceReq = parseInt(serviceReq);
             renderPlayerLeaderBoard(_resolvedTicketsData);
             renderGroupLeaderBoard(_resolvedTicketsData);
         }else{
             $.toaster({ priority : 'warning', title : 'point settings', message : 'invalid fields'});
         }
     });

     $("#AutomationTogler").click(function(){
         if(_automationFlag == true){
             _automationFlag=false;
             automator(_automationFlag);
             $("#AutomationTogler").text("Enable Automation");
         } else{
             _automationFlag=true;
             automator(_automationFlag);
             $("#AutomationTogler").text("Disable Automation");
         }
     });

    /** Event that triggers modal with player points details. Attach a delegated event handler */
    $( "#playerLeaderboard" ).on( "click", "a", function( event ) {
        event.preventDefault();
        $("#playerDetails").empty().append( $(this).text()+'\'s information');
        renderPlayerDetailtModal($(this).text());
    });

    /** Event that triggers modal with ticket details */
    $("#ticketList").on("click","a",function(event){
        event.preventDefault();
        var title = $(this).text();
        $("#ticketDetails").empty().append(title+' related data:');
        var addressValue = $(this).attr("href");
        addressValue = addressValue.replace("#","").trim();
        renderTicketDetailsModal(addressValue);
    });

     /**Event that triggers modal with team details*/
     $("#table-teamleaderboard").on("click","a",function(event){
         event.preventDefault();
         $("#teamDetails").empty().append( $(this).text()+'\'s information');
         renderTeamDetailModal($(this).text());
     })
}
