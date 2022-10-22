function removeCoach(coachId) {
    var httpRequest = new XMLHttpRequest();
    var params = 'id='+coachId;

    httpRequest.open('POST', "/removeCoachAction", true);
    httpRequest.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    httpRequest.send(params);
    httpRequest.onreadystatechange = function() {
        var $responseData = '';

        if (httpRequest.readyState == XMLHttpRequest.DONE) {
            $responseData = JSON.parse(httpRequest.responseText);
        }

        ($responseData.success) ? window.location.reload() : console.log("COACH NON EXISTENT");
    }
}

function editCoach(coachUrl) {
    window.location.pathname = coachUrl;
}
