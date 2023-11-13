// Make table rows clickable
$('.table-row').on('click', function(element){
    var reservationId = $(this).find('td:first').text();
    window.location.href = '/admin/reservation-edit/' + reservationId;
});

// logout button func
$('#logout-btn').on('click', function(){
    $.ajax({
        type: "POST",
        url: "/admin/login",
        data: {
            logout: true
        },
        dataType: "json",
        success: function () {
            window.location.replace("/admin/login");
        },
        error: function (resp){
            console.error('Error logging out');
        }
    });
});