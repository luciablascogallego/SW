
$(document).ready(function () {
    function correoValido(email) {
        var emailReg = /^([\w-\.]+)@(campus\.es)$/i;
        return emailReg.test(email);
    };
    ///////////////CHANGE////////////////
    $("#emailUsuario").change(function () {

        if (!correoValido($("#emailUsuario").val())) {
            const $img2 = $("#estado");
            $img2.replaceWith('<img src="includes/src/img/no.png" alt="estado" id="estado"/>');
            $("#correo-error").text("*@campus.es");
            $("#emailUsuario").addClass('error');

        }
        else {
            $("#correo-error").text("");
            $("#estado").remove();
            $("#emailUsuario").removeClass('error');

        }
    });
    $("#NIF").change(function () {

        if ($("#NIF").val().length < 7) {
            $("#nif-error").text("*NIF debe tener longitud mayor de 7");
            $("#NIF").addClass('error');

        }
        else {
            $("#nif-error").text("");
            $("#NIF").removeClass('error');
        }
    });
    $("#nombre").change(function () {
        if ($("#nombre").val().length < 2) {
            $("#nombre").addClass('error');
            $("#nombre-error").text("*nombre debe tener longitud mayor de 2");
        }
        else {
            $("#nombre-error").text("");
            $("#nombre").removeClass('error');

        }
    });
    $("#apellidos").change(function () {
        if ($("#apellidos").val().length < 7) {
            $("#apellidos").addClass('error');
            $("#apellidos-error").text("*apellidos longitud mayor de 7");

        }
        else {
            $("#apellidos-error").text("");
            $("#apellidos").removeClass('error');

        }
    });
    $("#telefono").change(function () {
        var telefono = $("#telefono").val();
        var regex = /^\+34/;
        if (!regex.test(telefono) || telefono.length !== 12) {
            $("#telefono").addClass('error');
            $("#telefono-error").text("*El teléfono debe comenzar con +34 y tener 9 digitos");

        } else {
            $("#telefono-error").text("");
            $("#telefono").removeClass('error');

        }
    });
    ///////////////////////////////////////
    $("#formLogin").submit(function (event) {
        if ($("#password").val().length < 5) {
            $("#password-error").text("La contraseña debe tener al menos 5 digitos");
            $("#password").val("");
            $("#password").focus();
            event.preventDefault();
        } else if (!correoValido($("#emailUsuario").val())) {
            $("#correo-error").text("*@campus.es");
            $("#emailUsuario").val("");
            $("#emailUsuario").focus();
            event.preventDefault();
        }
    });

    $("#formNuevoUsuario").submit(function (event) {
        var regex = /^\+34/;
        var telefono = $("#telefono").val();
        if ($("#password").val() !== $("#password2").val()) {
            $("#password").addClass('error');
            $("#password2").addClass('error');
            $("#password-error").text("*Las contraseñas no coinciden");
            $("#password").val("");
            $("#password2").val("");
            $("#password").focus();
            event.preventDefault();
        }
        else if ($("#password").val().length < 5) {
            $("#password-error").text("La contraseña debe tener al menos 5 digitos");
            $("#password").val("");
            $("#password2").val("");
            $("#password").focus();
            event.preventDefault();
        } else {
            $("#password-error").text("");
        }
        if (correoValido($("#emailUsuario").val())) {
            $("#correo-error").text("");
        } else {
            $("#correo-error").text("*@campus.es");
            $("#emailUsuario").val("");
            $("#emailUsuario").focus();
            event.preventDefault();
        }
        if (!regex.test(telefono) || telefono.length !== 12) {
            $("#telefono-error").text("*El teléfono debe comenzar con +34 y tener 9 digitos");
            $("#telefono").val("");
            $("#telefono").focus();
            event.preventDefault();
        }
        else if ($("#NIF").val().length < 7) {
            $("#nif-error").text("*NIF debe tener longitud mayor de 7");
            $("#NIF").val("");
            $("#NIF").focus();
            event.preventDefault();

        } else if ($("#apellidos").val().length < 7) {
            $("#apellidos-error").text("*apellidos longitud mayor de 7");
            $("#apellidos").val("");
            $("#apellidos").focus();
            event.preventDefault();

        } else if ($("#nombre").val().length < 2) {
            $("#nombre-error").text("*nombre debe tener longitud mayor de 2");
            $("#nombre").val("");
            $("#nombre").focus();
        }
    });
    $("#formEditaUsuario").submit(function (event) {
        var regex = /^\+34/;
        var telefono = $("#telefono").val();
        if ($("#password").val().length < 3) {
            $("#password-error").text("La contraseña debe tener al menos 5 digitos");
            $("#password").val("");
            $("#password2").val("");
            $("#password").focus();
            event.preventDefault();
        } else {
            $("#password-error").text("");
        }
        if (correoValido($("#emailUsuario").val())) {
            $("#correo-error").text("");
        } else {
            $("#correo-error").text("*@campus.es");
            $("#emailUsuario").val("");
            $("#emailUsuario").focus();
            event.preventDefault();
        }
        if (!regex.test(telefono) || telefono.length !== 12) {
            $("#telefono-error").text("*El teléfono debe comenzar con +34");
            $("#telefono").val("");
            $("#telefono").focus();
            event.preventDefault();
        }
        else if ($("#NIF").val().length < 9) {
            $("#nif-error").text("*NIF debe tener longitud mayor de 7");
            $("#NIF").val("");
            $("#NIF").focus();
            event.preventDefault();

        } else if ($("#apellidos").val().length < 7) {
            $("#apellidos-error").text("*apellidos longitud mayor de 7");
            $("#apellidos").val("");
            $("#apellidos").focus();
            event.preventDefault();
        } else if ($("#nombre").val().length < 2) {
            $("#nombre-error").text("*nombre debe tener longitud mayor de 2");
            $("#nombre").val("");
            $("#nombre").focus();
            event.preventDefault();

        }
    });
    $("#formNewPass").submit(function (event) {
        if ($("#password").val().length < 5) {
            $("#password-error").text("La contraseña debe tener al menos 5 dígitos");
            $("#password").val("");
            $("#password2").val("");
            $("#password").addClass('error');
            $("#password").focus();
            event.preventDefault();
        } else {
            $("#password-error").text("");
            $("#password").removeClass('error');

        }
    });
});

