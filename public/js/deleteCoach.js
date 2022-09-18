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