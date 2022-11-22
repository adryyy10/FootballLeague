function removePlayer(playerId) {
    var httpRequest = new XMLHttpRequest();
    var params = 'id='+playerId;

    httpRequest.open('POST', "/removePlayerAction", true);
    httpRequest.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    httpRequest.send(params);
    httpRequest.onreadystatechange = function() {
        var $responseData = '';

        if (httpRequest.readyState == XMLHttpRequest.DONE) {
            $responseData = JSON.parse(httpRequest.responseText);
        }

        ($responseData.success) ? window.location.reload() : console.log("PLAYER NON EXISTENT");
    }
}

function editPlayer(playerUrl) {
    window.location.pathname = playerUrl;
}