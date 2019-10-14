<!DOCTYPE html>
<html>

<head>
    <title>Page Title</title>
    <link rel="stylesheet" type="text/css" href="home.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="print.css" media="print" />
<body>

    <div class="container">
        <div id="contact" class="table-responsive">
                <table class="tg" style="undefined;table-layout: fixed; width: 100%">
                        <tr>
                            <td class="tg-xn46">
                                <img src="images/logo.png" height="90" width="100" alt="">
                            </td>
                            <td class="tg-xn46 text-center">
                                <label for="SUMIMEDICAL"><b>SUMIMEDICAL</b></label><br>
                                <label for="Nit: "><b>NIT: </b><span><i>900033371-4</i></span></label><br>
                                <label for="Dirección: "><i>Calle 33 # 74E - 31</i></label><br>
                                <label for="Telefono: "><b>Telefono: </b><i>520-10-40</i></label><br>
                                <label for="Medellín: "><b>Medellín</b></label>
                            </td>
                            <td class="tg-xn46 text-center">
                                <label for="SUMIMEDICAL"><b>Autorización:</b><b><i>0001</i></b></label><br>
                                <label for="Nit: "><b>Fecha Autorización: </b><span><i>900033371-4</i></span></label><br>
                                <label for="Dirección: "><i>Impreso Por: </i><b><i>Error 404</i></b></label><br>
                                <label for="Telefono: "><b>Autorización de Servicios: </b></label><br>
                            </td>
                        </tr>
                </table>
                <hr>
                <br><br>
            <h3>Datos del Usuario</h3>
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
            <h3>Datos de formulación</h3>
            <div class="fieldset">
                <table class="tg" style="width: 100%">
                    <tr>
                        <td class="tg-xn46">
                            <label for="dx_principal">Dx Principal: {{$dx_principal}}</label>
                        </td>
                        <td class="tg-xn46">
                            <label for="grupo_farmaceutico">Grupo farmacéutico: {{$grupo_farmaceutico}}</label>
                        </td>
                        <td class="tg-xn46">
                            <label for="medicamento">Medicamento: {{$medicamento}}</label>
                        </td>
                    </tr>
                    <tr>
                        <td class="tg-xn46">
                            <label for="cantidad_dosis">Cantidad por dosis: {{$cantidad_dosis}}</label>
                        </td>
                        <td class="tg-xn46">
                            <label for="via">Vía: {{$via}}</label>
                        </td>
                        <td class="tg-xn46">
                            <label for="frecuencia">Frecuencia: {{$frecuencia}}</label>
                        </td>
                    </tr>
                    <tr>
                        <td class="tg-xn46">
                            <label for="unidad_tiempo">Unidad de tiempo: {{$unidad_tiempo}}</label>
                        </td>
                        <td class="tg-xn46">
                            <label for="duracion">Duración: {{$duracion}}</label>
                        </td>
                        <td class="tg-xn46">
                            <label for="cantidad_mensual">Cantidad mensual: {{$cantidad_mensual}}</label>
                        </td>
                    </tr>
                    <tr>
                        <td class="tg-xn46">
                            <label for="renovable">Renovable por: {{$renovable}}</label>
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
            <label for="firma_digital">Firma digital: {{$firma_digital}}</label>
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