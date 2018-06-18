$(document).ready(function () {
    $("#addProductForm").submit(function (event) {
        event.preventDefault();
        postForm("/Product/add", $(this).serialize());
    });

    $("#editProductForm").submit(function (event) {
        event.preventDefault();
        postForm("/Product/update", $(this).serialize());
    });

    $("#addItemForm").submit(function (event) {
        event.preventDefault();
        postForm("/item/insert", $(this).serialize());
    });

    $("#addRoleForm").submit(function (event) {
        event.preventDefault();
        postForm("/role/insert", $(this).serialize());
    });

    $("#addPermissionForm").submit(function (event) {
        event.preventDefault();
        postForm("/permission/insert", $(this).serialize());
    });

    $("#loginForm").submit(function (event) {
        event.preventDefault();
        login("/login", $(this).serialize());
    });
});

function postForm(url, formData) {
    $.ajax({
        type: "POST",
        url: url,
        data: formData,
        success: function (response) {
            var alertBox;
            switch (response.result) {
                case 'succes':
                    alertBox = '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' + response.type + ' opgeslagen.</div>';
                    break;
                case 'duplicate':
                    alertBox = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' + response.type + ' bestaat al.</div>';
                    break;
            }
            $("#responseStatus").empty().append(alertBox);
        },
        error: function () {
            var alertBox = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Fout opgetreden tijdens het opslaan.</div>';
            $("#responseStatus").empty().append(alertBox);
        }
    });
}

function login(url, formData) {
    $.ajax({
        type: "POST",
        url: url,
        data: formData,
        success: function (response) {
            var alertBox;
            switch(response.result )
            {
                case 'fail':
                    alertBox = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Verkeerde gegevens.</div>';
                    $( "#responseStatus" ).empty().append( alertBox );
                    break;
                case 'succes':
                    window.location = '/';
                    break;
            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            var alertBox = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Fout opgetreden tijdens inloggen.</div>';
            $( "#responseStatus" ).empty().append( alertBox );
        }
    });
}