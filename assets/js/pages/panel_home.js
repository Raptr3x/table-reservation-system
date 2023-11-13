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