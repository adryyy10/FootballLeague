function removeClub(clubId) {
    var httpRequest = new XMLHttpRequest();
    var params = 'id='+clubId;

    httpRequest.open('POST', "/removeClubAction", true);
    httpRequest.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    httpRequest.send(params);
    httpRequest.onreadystatechange = function() {
        var $responseData = '';

        if (httpRequest.readyState == XMLHttpRequest.DONE) {
            $responseData = JSON.parse(httpRequest.responseText);
        }

        ($responseData.success) ? window.location.reload() : console.log("CLUB NON EXISTENT");
    }
}

function editClub(clubUrl) {
    window.location.pathname = clubUrl;
}