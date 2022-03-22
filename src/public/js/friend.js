$(document).on("click", ".follow", function (e) {
    e.preventDefault();
    currentUser = $(this).data("currentuser_id")
    user_id = $(this).data("user_id");
    console.log('user_id',user_id,currentUser);

    $.ajax({
        method: "POST",
        url: "http://localhost:8080/friend/follow",
        data: { 
            'user_id': user_id ,
             'currentuser' : currentUser },
        // dataType: "JSON",
    }).done(function (data) {
        console.log(data);
        // console.log(data);
        // window.location.reload();
    });
});