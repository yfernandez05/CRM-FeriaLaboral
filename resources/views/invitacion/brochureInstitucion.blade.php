<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invitación Descubre tu vocación - {{$invitacion->institucion}}</title>
    <style type="text/css" media="all">
html{font-family:sans-serif}.container:after,.row:after{clear:both}.container{margin-right:0;margin-left:0}.col-xs-1,.col-xs-10,.col-xs-11,.col-xs-12,.col-xs-2,.col-xs-3,.col-xs-4,.col-xs-5,.col-xs-6,.col-xs-7,.col-xs-8,.col-xs-9{float:left;position:relative;min-height:1px;padding-right:15px;padding-left:15px}.col-xs-12{width:100%}.col-xs-11{width:91.66666667%}.col-xs-10{width:83.33333333%}.col-xs-9{width:75%}.col-xs-8{width:66.66666667%}.col-xs-7{width:58.33333333%}.col-xs-6{width:50%}.col-xs-5{width:41.66666667%}.col-xs-4{width:33.33333333%}.col-xs-3{width:25%}.col-xs-2{width:16.66666667%}.col-xs-1{width:8.33333333%}.table{width:100%;max-width:100%;margin-bottom:20px}.table>tbody>tr>td,.table>tbody>tr>th,.table>tfoot>tr>td,.table>tfoot>tr>th,.table>thead>tr>td,.table>thead>tr>th{padding:8px;line-height:1.42857143;vertical-align:top;border-top:1px solid #ddd}.table>caption+thead>tr:first-child>td,.table>caption+thead>tr:first-child>th,.table>colgroup+thead>tr:first-child>td,.table>colgroup+thead>tr:first-child>th,.table>thead:first-child>tr:first-child>td,.table>thead:first-child>tr:first-child>th{border-top:0;border-bottom:0}.table-bordered,.table-detalles{border:0px solid #ddd}.table .table{background-color:#fff}.table-condensed>tbody>tr>td,.table-condensed>tbody>tr>th,.table-condensed>tfoot>tr>td,.table-condensed>tfoot>tr>th,.table-condensed>thead>tr>td,.table-condensed>thead>tr>th{padding:0px}.table-bordered>thead>tr>td,.table-bordered>thead>tr>th{background:#fff}.table-detalles>thead>tr>td,.table-detalles>thead>tr>th{background:#F4F4F4}p{margin:0 0 2px}.text-rigth{text-align:right}
.tituloguia{
    padding: 10px;background: #343434;color: white;
}
hr { 
    border: 2px solid #424242;
}
.text-center{
    text-align: center;
}
.border-content{
    border: 2px solid #424242;
}
hr.footer {  
    border: 5px solid #424242; 
}
.contenedorstiker{
    padding: 15%;
}
.contenedor-ruc{
    border:0px solid #343434;text-align:center;display:block;padding:70px;font-size:14px; justify-content: center
}
.justify-end{
    justify-content: end;
}
.pb-2{
    padding-bottom: 10px;
}
.pt-2{
    padding-top: 5px;
}
table, tr, td{ 
    border:none !important;
}
.contenedor-peso{ 
    border:1px solid #343434;text-align:center;display:block;margin-top: 60px;padding:0px 10px 0px 10px;
}
.contenedor-peso p{
    margin-bottom:4px;font-size: 18px;
}
.info_invitation{
    line-height:0.28in; font-style:normal;font-size:11pt;color:#797979;letter-spacing: 0.01in;
}
.title_invitation{
line-height:0.30in;font-size:11pt;
}
.fecha_invitation{
    line-height:0.20in;float:right;padding-bottom: 100px !important;font-size:11pt;
}
.footerinfo_invitation{
    line-height:0.16in;font-size:11pt;font-style:normal;font-weight: normal;letter-spacing: 0.01in;line-height:0.20in;
}

     </style>
</head>
<body>
<img style="position:absolute;top:-0.50in;left:-0.50in;width:8.30in;height:1.40in" src="{{asset('/images/invitacion/header.png')}}">
<img style="position:absolute;top:10.08in;left:-0.45in;width:1.30in;height:1.12in" src="{{asset('/images/invitacion/line_footer.png')}}">

<div class="container" style="position:absolute;top:1.10in;left:0.52in;width:6in">
    <div class="row pt-10 mb-5 justify-content-center">
        <div class="col-xs-12">
            <table>
                <tr>
                    <td><span class="fecha_invitation">Lima, {{$date}}</span></td><br><br>
                </tr>
                <tr>
                    <td>
                        <span class="title_invitation"><strong>{{$invitacion->institucion}}</strong></span><br>          
                    </td>                    
                </tr>
                <tr>
                    <td style="padding-bottom: 15px">
                        <span class="title_invitation"><strong>Hola, Estimado/a {{$invitacion->nombresdirector}}</strong></span>
                    </td>
                </tr>
                <tr>
                    <td style=" text-align: justify; padding-bottom: 15px">
                       <span class="info_invitation">
                    Es un placer saludarle y por medio de la presente extenderle una cordial
                    invitación a su Institución a participar de nuestra <span style="font-style: italic;">virtual vocacional 3D en
                    el Perú, </span><strong style="color:#626262">“Descubre tu vocación”</strong> en su 2da edición a llevarse a cabo los días 24,
                    25, 26 y 27 de agosto del presente año, donde tendremos la presencia de
                    diversas Universidades e Institutos de Lima</span>
                    </td>
                </tr>
                <tr>
                    <td style=" text-align: justify; padding-bottom: 15px">
                       <span class="info_invitation">
                       Durante la feria los Alumnos podrán visitar diferentes stands de carreras, asistir a
                        charlas vocacionales y conocer de cerca la carrera que más les apasiona,
                        disfrutando de un ambiente dinámico y ameno e incluso podrán participar de
                        algunos sorteos y sorpresas que tenemos preparado para ellos.
                        </span>
                    </td>
                </tr>
                <tr>
                    <td style=" text-align: justify; padding-bottom: 15px">
                       <span class="info_invitation">
                       Además Descubre tu vocación realizara charlas vocacionales donde
                        podríamos considerar a sus alumnos para que puedan asistir de modo gratuito.
                        </span>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: justify;padding-bottom: 15px">
                       <span class="info_invitation">
                        Agradecemos que nos confirme su presencia en nuestro evento y poder
                        conectarnos con su institución de modo virtual o remoto para proceder a
                        realizar la invitación.
                        </span>
                    </td>
                </tr>
                <tr>
                    <td style="padding-bottom: 15px">
                       <span class="info_invitation">
                       Queda de usted.
                        </span>
                    </td>
                </tr>
                <tr>                   
                    <td>
                        <!-- <img src="{{asset('/images/invitacion/firma.png')}}" alt="Logo" style="height:0.80in;"> -->
                        <img src="{{asset('/images/invitacion/firma.png')}}" alt="Logo" style="height:0.80in;"> 
                    </td> 
                </tr>
                <tr>                   
                    <td><span class="footerinfo_invitation">Miguel Angel, Rodriguez Padin</span></td>
                </tr>
                <tr>                   
                    <td><span class="footerinfo_invitation">955238766</span></td>
                </tr>
                <tr>                   
                    <td><span class="footerinfo_invitation"><strong>CEO & founder Descubre tu vocación<strong></span></td>
                </tr>
            </table>
        </div>
    </div>    
</div>

<div style="position:relative;top:10.19in;width:6.40in;left:0.42in;">
    <span style="font-style:normal;font-weight:normal;font-size:11pt;color:#2d53c2; float:right;">951 079 231</span>
    <!-- <img src="{{asset('/images/invitacion/cel_footer.png')}}" alt="Logo" style="height:0.30in; position:relative; bottom:12px;right:-15px"><br> -->
    <img src="{{asset('/images/invitacion/cel_footer.png')}}" alt="Logo" style="height:0.30in; position:relative; bottom:12px;right:-15px"><br>
    <span style="font-style:normal;font-weight:normal;font-size:11pt;color:#2d53c2; float:right;">mrodriguez@descubretuvocacion.pe</span>
    <!-- <img src="{{asset('/images/invitacion/correo_footer.png')}}" alt="Logo" style="height:0.15in;position:relative;right:-15px"><br> -->
    <img src="{{asset('/images/invitacion/correo_footer.png')}}" alt="Logo" style="height:0.15in;position:relative;right:-15px"><br>
    <div>
        <hr  style="background-color:#f18568;position:absolute;right:-0.90in;width:3.55in;height:0.03in;border:none;">
    </div>
</div>

</body>
</html>