$(document).ready(function () {

    $("#loginForm").submit(function (event) {
        event.preventDefault();
        login($(this));
    });

});

function login(formObject) {
    $.ajax({
        type: formObject.attr('method'),
        url: formObject.attr('action'),
        data: formObject.serialize(),
        success: function (response) {
            var alertBox;
            var referrer = '/';
            if(document.referrer)
            {
                referrer = document.referrer;
            }
            switch (response.result) {
                case 'fail':
                    alertBox = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Verkeerde gegevens.</div>';
                    $("#responseStatus").empty().append(alertBox);
                    break;
                case 'success':
                    window.location = referrer;
                    break;
            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            var alertBox = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Fout opgetreden tijdens inloggen.</div>';
            $("#responseStatus").empty().append(alertBox);
        }
    });
}