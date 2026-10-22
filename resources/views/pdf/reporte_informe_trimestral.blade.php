<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acta de Calificaciones Totales</title>


    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    <section class="header" style ="top: -287px;">
        <table cellpadding="0" cellspancing="0" width="100%">
            <tr>
                <td width="100%" style="vertical-align: top; padding-top: 10px">
                    <img src="../public/assets/images/banner-ueas.jpg" height="100px" width="100%">
                </td>        
            </tr>
        </table>
        <br>
    </section>

    <section class="header" style ="top: -287px;">
        <table cellpadding="0" cellspancing="0" width="100%">
            <tr style="font-size:12px">
                <td width="100%">
                    <p class="text-center text-uppercase" style="margin: 0px;">UNIDAD EDUCATIVA AMERICAN SCHOOL - {{$datos['nivel']}}</p>
                    <p class="text-center" style="margin: 0px;">INFORME DE APRENDIZAJE POR DOCENTE</p>
                    <p class="text-center" style="margin: 0px;">{{$datos['periodolectivo']}}</p>
                </td> 
            </tr>
        </table>
        <br>
    </section>

    <section class="header" style ="top: -287px;">
    </section>
    
</body>
</html>