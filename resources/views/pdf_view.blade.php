<!DOCTYPE html>
<html>

<head>
    <title>Page Title</title>
</head>

<body>

    <div class="container">
        <div id="contact">
            <img src="/storage/images/citas.jpg" alt="">
            <h3>Datos del Paciente</h3>
            <div class="fieldset">
                <table class="tg" style="undefined;table-layout: fixed; width: 100%">
                    <tr>
                        <td class="tg-xn46">
                            <label for="identificacion">Identificación: {{$identificacion}}</label>
                        </td>
                        <td class="tg-xn46">
                            <label for="nombre">Nombre: {{$nombre}}</label>
                        </td>
                        <td class="tg-xn46">
                            <label for="edad">Edad: {{$edad}}</label>
                        </td>
                    </tr>
                    <tr>
                        <td class="tg-xn46">
                            <label for="sexo">Sexo: {{$sexo}}</label>
                        </td>
                        <td class="tg-xn46">
                            <label for="ips">IPS Básica: {{$ips}}</label>
                        </td>
                        <td class="tg-xn46">
                            <label for="direccion">Dirección: {{$direccion}}</label>
                        </td>
                    </tr>
                    <tr>
                        <td class="tg-xn46">
                            <label for="aseguradora">Aseguradora y plan: {{$aseguradora}}</label>
                        </td>
                        <td class="tg-xn46">
                            <label for="correo">Correo: {{$correo}}</label>
                        </td>
                        <td class="tg-xn46">
                            <label for="telefono">Teléfono: {{$telefono}}</label>
                        </td>
                    </tr>
                    <tr>
                        <td class="tg-xn46">
                            <label for="tipo_afiliado">Tipo de afiliado: {{$tipo_afiliado}}</label>
                        </td>
                        <td class="tg-xn46" colspan="2">
                            <label for="estado_afiliado">Estado de afiliado: {{$estado_afiliado}}</label>
                        </td>
                    </tr>
                </table>
            </div>
            <hr>
            <br>
            <h3>Datos del Servicio</h3>
            <div class="fieldset">
                <table class="tg" style="width: 100%">
                    <tr>
                        <td class="tg-xn46">
                            <label for="dx_principal">Dx Principal: {{$dx_principal}}</label>
                        </td>
                        <td class="tg-xn46">
                            <label for="ubicacion">Ubicación: {{$ubicacion}}</label>
                        </td>
                        <td class="tg-xn46">
                            <label for="descripcion">Descripción: {{$descripcion}}</label>
                        </td>
                    </tr>
                    <tr>
                        <td class="tg-xn46">
                            <label for="cups">CUPS: {{$cups}}</label>
                        </td>
                        <td class="tg-xn46">
                            <label for="servicios">Servicios: {{$servicios}}</label>
                        </td>
                        <td class="tg-xn46">
                            <label for="fecha">Fecha de realización: {{$fecha}}</label>
                        </td>
                    </tr>
                    <tr>
                        <td class="tg-xn46">
                            <label for="cantidad">Cantidad: {{$cantidad}}</label>
                        </td>
                        <td class="tg-xn46" colspan="2">
                            <label for="observaciones">Observaciones: {{$observaciones}}</label>
                        </td>
                    </tr>
                    <tr>
                        <td class="tg-xn46">
                            <label for="medico_tratante">Medico tratante: {{$medico_tratante}}</label>
                        </td>
                        <td class="tg-xn46" colspan="2">
                            <label for="medico_ordena">Medico que ordena: {{$medico_ordena}}</label>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

</body>

<style>
    @import url(https://fonts.googleapis.com/css?family=Roboto:400,300,600,400italic);
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -webkit-font-smoothing: antialiased;
        -moz-font-smoothing: antialiased;
        -o-font-smoothing: antialiased;
        font-smoothing: antialiased;
        text-rendering: optimizeLegibility;
    }
    
    body {
        font-family: "Roboto", Helvetica, Arial, sans-serif;
        font-weight: 100;
        font-size: 12px;
        line-height: 20px;
        color: #777;
        background: gray;
    }
    
    .container {
        max-width: 700px;
        width: 100%;
        margin: 0 auto;
        position: relative;
    }

    .tg {border-collapse:collapse;border-spacing:0;}

    .tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;}

    .tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;}

    .tg-xn46{border-color:#ffffff;text-align:left;vertical-align:top}
    
    #contact {
        background: #F9F9F9;
        padding: 25px;
        margin: 100px 0;
        box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
    }
    
    #contact h3 {
        display: block;
        font-size: 30px;
        font-weight: 300;
        margin-bottom: 10px;
    }
    
    #contact h4 {
        margin: 5px 0 15px;
        display: block;
        font-size: 13px;
        font-weight: 400;
    }
    
    .fieldset {
        border: medium none !important;
        margin: 0 0 10px;
        padding: 0;
        width: 100%;
    }
    
    ::-webkit-input-placeholder {
        color: #888;
    }
    
    :-moz-placeholder {
        color: #888;
    }
    
    ::-moz-placeholder {
        color: #888;
    }
    
    :-ms-input-placeholder {
        color: #888;
    }
</style>

</html>