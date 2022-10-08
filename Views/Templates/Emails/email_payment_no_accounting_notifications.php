<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<title>Notificación de pago</title>
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
	</style>
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
						<p>Hola <?=$data['usuario'];?></p>
					</div>
					<p>Con número de cedula: <strong><?=$data['DNI'];?></strong></p>
					<p>Te informamos que se ha realizado el pago no contable del mes de <?=$data['mes'];?>. <br><br>
                        <small>para mas información, ingrese a la plataforma con sus credenciales y verifique el pago en sus notificaciones.</small>
                    </p>
					<p class="x_text_white">
					    <a href="<?=$data['url'];?>" target="_blank" class="x_button_link x_link_blue">Ir a la plataforma</a>
					</p>
					<br>
					<p>Si no funciona el botón puedes copiar y pegar la siguiente dirección en tu navegador.</p>
					<span><?=$data['url'];?></span>
					<p class="x_title_gray"><a href="<?=WEB_COMPANY;?>" target="_blanck"><?=WEB_COMPANY;?></a></p>
				</td>
			</tr>
		</tbody>
	</table>
</body>
</html>