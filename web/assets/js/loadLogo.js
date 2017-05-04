var loadLogo = function () {

    var config = {
        type: 'GET',
        dataType: 'json',
        contentType: "application/json",
        url: serviceaddress + '/api/logo',
        data: {},

        success: function (response)
        {
            if (response.success == true)
            {
                if (response.data.logo) {
                    $('#system-logo').attr('src', serviceaddress + response.data.logo)
                }

            }

        }
    }
    $.ajax(config);
}
loadLogo();


