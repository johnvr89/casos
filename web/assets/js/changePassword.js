

var changePasswordInit = function () {

    $('#changePasswordContainer').load("assets/pages/changePasswordUserModal.html", {}, function () {

        addModalChangePasswordSubmit();
        changePasswordValidationEngine('form-changePassword');
        $('#changePasswordContainer').on('hidden.bs.modal', function ()
        {
            clearForm('changePassword');
        });
    });

};

var addModalChangePasswordSubmit = function ()
{
    $("#form-changePassword").on("submit", function (e)
    {
        e.preventDefault();
        if ($("#form-changePassword").valid())
        {

            var data = {oldPassword: $("#form-changePassword input[name=oldPassword]").val(),
                confirmPassword: $("#form-changePassword input[name=confirmPassword]").val(),
                newPassword: $("#form-changePassword input[name=newPassword]").val()};
            waitMeShow("wrapper");
            excecuteAjax('POST', getRoute('cambiarcontraseña'), data, null, function (response)
            {
                if (response.success == true)
                {
                    $("#changePassword").modal('hide');
                    waitMeHide("wrapper");
                    alertify.success("Contraseña actualizada satisfactoriamente");
                    sessionStorage.auth_token = response.data.token;
                    $.ajaxSetup({
                        headers: {
                            apiKey: sessionStorage.auth_token}
                    });
                }
            }, false, true);
        }
    });
};
changePasswordInit();