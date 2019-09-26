<?php
session_start();
error_reporting(0);
$varsesion = $_SESSION['auth'];
if (isset($varsesion)) {
    ?>
    <!doctype html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <title>Data</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

        <!-- Custom styles for this template -->
        <link href="css/estilos.css" rel="stylesheet">
    </head>

    <body>
        <div>
            <nav class="navbar navbar-dark bg-dark">
                <a class="navbar-brand" href="#">
                    <img src="img/magi-green.png" width="30" height="30" class="d-inline-block align-top" alt="">
                    Dashboard
                </a>
                <a class="nav-link" href="chart.php">Chart</a>
                <a class="nav-link" href="data.php">Data</a>
            </nav>
        </div>

        <main role="main" class="col-md-9 col-lg-10 px-4" id="main">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Data</h1>
            </div>
            <div class="table-responsive view" id="show_data">
                <table class="table table-striped table-sm" id="list-data">
                    <thead>
                        <tr>
                            <th>Hash</th>
                            <th>Data</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            </form>
            </div>
        </main>
        </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

        <script>
            //cambia vista
            function change_view(vista = 'show_data') {
                $("#main").find(".view").each(function() {
                    // $(this).addClass("d-none");
                    $(this).slideUp('fast');
                    let id = $(this).attr("id");
                    if (vista == id) {
                        $(this).slideDown(300);
                        // $(this).removeClass("d-none");
                    }
                });
            }

            function consultar() {
                let obj = {
                    "accion": "consultar_data"
                };
                $.post("includes/_funciones.php", obj, function(respuesta) {
                    let template = ``;
                    $.each(respuesta, function(i, e) {
                        template +=
                            `
                                    <tr>
                                    <td>${e.data_hash}</td>
                                    <td>${e.data_fecha}</td>
                                    </tr>
                                    `;
                    });
                    $("#list-data tbody").html(template);
                }, "JSON");
            }
            $(document).ready(function() {
                consultar();
                change_view();
            });
        </script>
    </body>

    </html>
<?php
} else {
    header("Location:index.html");
}
?>