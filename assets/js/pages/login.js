$('#submit-btn').on('click', function () {
    $.ajax({
        type: "POST",
        url: "/admin/login",
        data: {
            email: $('#email').val(),
            password: $('#password').val()
        },
        dataType: "json",
        success: function (response) {
            $('#error-text').text();
            window.location.replace("/admin");
        },
        error: function(response){
            $('#error-text').text(response.responseJSON);
        }
    });
});