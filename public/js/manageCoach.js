function removeCoach(coachId) {
    $.ajax({
        type: "POST",
        url: '/removeCoachAction',
        data: {
            id: coachId
        },
        success: function(response)
        {
            // coach is deleted successfully, reload the page
            (response.success == "1") ?  window.location.reload() : console.log("COACH NON EXISTENT");
       }
   });
}


window.onclick = e => {
    window.location.pathname = e.target.dataset.url;
} 

/*function updateCoach(coachId) {
    let element = document.querySelector('.js-update-coach');
    let url     = element.dataset.url;
    console.log(url);

    window.location.pathname = url;
}*/

//let element = document.querySelector('.update-coach');
//let element1 = document.querySelector('.update-coach');

// $( ".update-coach" ).addEventListener("click", function () {
//     console.log("JUAS");
// });
// element.onclick = function () {
//     //location.href = "newURL";
//     console.log("JEJE");
// };

// $(".update-coach").click(function(event) {
    
//     let url     = $(event.target).data('url');
//     let coachId = $(event.target).data('coachId');


//     let redirectUrl = url + '?' + coachId;
//     console.log(redirectUrl);
//     window.location.pathname = redirectUrl;
// });

