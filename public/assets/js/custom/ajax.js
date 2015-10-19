/**
 * Created by NB21334 on 06/06/2015.
 */

function getAjaxData(link) {
    return $.ajax({
        url : link,
        dataType: 'json'
    });
}


function generateLink(type, start, end){
    var link = "";
    switch (type){
        case 'open':
            link = '/api/v1/openTickets/';
            break;
        case 'resolved':
            link = '/api/v1/closedTickets/';
            break;
        case 'reOpened':
            link = '/api/v1/reOpenedTickets/';
            break;
        case 'groups':
            link = '/api/v1/groups/';
            break;
        case 'getChallengesCount':
            link = '/api/v1/getChallengesCount/';
            break;
        case 'articles':
            link = '/api/v1/articles/';
            break;
        case 'pointSettings':
            link = 'api/v1/getPointSettings';
            break;
        default:
            link = '/api/v1/openTickets/';
    }

    if (start && end) {
        link = link + start + '&' + end;
    }
    return link;
}