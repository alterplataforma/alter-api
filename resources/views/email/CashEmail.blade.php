<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div style='width: 100%; height: auto;'>
        <div style='width: 100%; float: left; background: #0b2d3f; height: auto;'>
            <div style='width: 200px; float: left; padding: 10px; padding-left: 40px;'>
                <img src='http://finespublicidad.com/serviciosalter/media/img/logo_mailing_alter_w.png' width='100%'; height='auto;' />
            </div>
            <div style='float: right; text-align: right; padding: 10px; padding-top: 60px; padding-right: 40px;'>
                <a href='#' style='text-decoration: none; font-size: 12px; color: white; font-family: arial;'>info@alterclub.com</a>
            </div>
        </div>
        <div style='width: 100%; height: 10px; background: #36a1db; float: left;'>
        </div>
        <div style='width: 90%; height: auto; float: left; padding: 5%; font-family: arial; color: grey; text-align: justify;'>
            <p><h1>Hola,</h1></p>
            @switch($type)
                @case('retirement')
                    <p>Hemos recibido una solicitud para retirar dinero de tu cuenta ALTER, tu dinero ser&aacute; procesado y puesto en tu cuenta seg&uacute;n la siguiente informaci&oacute;n:</p>
                    <p><b>Monto solicitado:</b> ${{$value}}</p>
                    <p><b>Fecha de solicitud:</b> {{$date}}</p>
                    @break
                @case('pin')
                    <p>Hemos recibido una solicitud para enviar dinero de tu cuenta ALTER, a la siguiente cuenta:</p>
                    <p><b>Cedula:</b> {{$document}}</p>
                    <p><b>Nombre:</b> {{$name}}</p>
                    <p>Para poder completar el proceso utilice el siguiente PIN: <b>{{$pin}}</b>
                    @break
                @default
                    @break
            @endswitch
            <p><h3>Cordialmente,</h3></p>
            <p><h4>El Equipo Alter</h4></p>
        </div>
        <div style='width: 100%; height: auto; background: #36a1db; float: left;' >
            <p style='color: white; font-family: arial; padding-left: 40px; padding-right: 40px; padding-bottom: 20px; padding-top: 10px;'>
                <a href='https://itunes.apple.com/WebObjects/MZStore.woa/wa/viewSoftware?id=1267852082&mt=8'>
                    <img src='http://finespublicidad.com/serviciosalter/media/img/app_store.png' width='150px' height='auto' style='float: right; padding-bottom: 10px;'/>
                </a>
                <a href='https://play.google.com/store/apps/details?id=com.alter.alterclub'>
                    <img src='http://finespublicidad.com/serviciosalter/media/img/android.png' width='150px' height='auto' style='float: right; margin-right: 10px; padding-bottom: 10px;' />
                </a>Alter 2016 - Todos los derechos reservados Descarga nuestra APP &uacute;nete al Club
            </p>
        </div>
    </div>
</body>
</html>
