$("#buttonSign").click(function() {
    let usr = $("#inputUsr").val();
    let password = $("#inputPassword").val();
    let obj = {
        "accion": "login",
        "usr": usr,
        "password": password,
    };
    $.post("includes/_funciones.php", obj, function(r) {
        if (r == 2) {
            $("#error").html("Campos vacios").fadeIn();
        }
        if (r == 0) {
            $("#error").html("Usuario o contraseña incorrectos").fadeIn();
        }
        if (r == 1) {
            window.location.href = "data.php";
        }
    });
});