<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<title>Solicitud de registro</title>
	<style type="text/css">
		p{
			font-family: arial;
			letter-spacing: 1px;
			color: #7f7f7f;
			font-size: 15px;
		}
		a{
			color: #3b74d7;
			font-family: arial;
			text-decoration: none;
			text-align: center;
			display: block;
			font-size: 18px;
		}
		.x_sgwrap p{
			font-size: 20px;
		    line-height: 32px;
		    color: #009688;
		    font-family: arial;
		    text-align: center;
		}
		.x_title_gray {
		    color: #009688;
		    padding: 5px 0;
		    font-size: 15px;
			border-top: 1px solid #CCC;
		}
		.x_title_primary {
		    padding: 08px 0;
		    line-height: 25px;
		    text-transform: uppercase;
			border-bottom: 1px solid #CCC;
		}
		.x_title_primary h1{
			color: #009688;
			font-size: 25px;
			font-family: 'arial';
		}
		.x_bluetext {
		    color: #244180 !important;
		}
		.x_title_gray a{
			text-align: center;
			padding: 10px;
			margin: auto;
			color: #009688;
		}
		.x_text_white a{
			color: #FFF;
		}
		.x_button_link {
		    width: 100%;
			max-width: 470px;
		    height: 40px;
		    display: block;
		    color: #FFF;
		    margin: 20px auto;
		    line-height: 40px;
		    text-transform: uppercase;
		    font-family: Arial Black,Arial Bold,Gadget,sans-serif;
            border-radius: 10px;
		}
		.x_link_blue {
		    background-color: #009688;
		}
		.x_textwhite {
		    background-color: rgb(50, 67, 128);
		    color: #ffffff;
		    padding: 10px;
		    font-size: 15px;
		    line-height: 20px;
		}
        .text-info {
            color: dodgerblue;
        }
        .text-justify{
            text-align: justify;
        }
	</style>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <table align="center" cellpadding="0" cellspacing="0" bgcolor="#ffffff" style="text-align:center;">
        <tbody>
            <tr>
                <td>
                    <div class="x_sgwrap x_title_primary">
                        <h1><?=COMPANY_NAME;?></h1>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="x_sgwrap">
                        <p>
                            Hola, soy <?=$data['nombres']." ".$data['apellidoP']." ".$data['apellidoM'];?>. <br>
                            Eh solicitado mi resgistro a su entidad con los siguientes datos:
                        </p>
                    </div>
                    <p>
                        <ul class="text-justify">
                            <li><b>Cedula:</b> <?=$data['cedula'];?></li>
                            <li><b>Nombres:</b> <?=$data['nombres'];?></li>
                            <li><b>Apellido paterno:</b> <?=$data['apellidoP'];?></li>
                            <li><b>Apellido materno:</b> <?=$data['apellidoM'];?></li>
                            <li><b>email:</b> <?=$data['emailInfo'];?></li>
                            <li><b>telefono:</b> <?=$data['telefono'];?></li>
                            <li><b>Fecha de nacimiento:</b> <?=$data['fechNaci'];?></li>
                            <li><b>Sexo:</b> <?=$data['sexo'];?></li>
                        </ul>
                    </p>
                    <a href="<?=$data['url'];?>" target="_blank" class="x_button_link x_link_blue">Registrar</a>
                    
                    <p class="x_title_gray"><a href="<?=WEB_COMPANY;?>" target="_blanck"><?=WEB_COMPANY;?></a></p>
                </td>
            </tr>
        </tbody>
	</table>
</body>
</html>