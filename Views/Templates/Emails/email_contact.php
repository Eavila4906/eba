<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<title>Notificación de pago total <?=$data['periodo'];?></title>
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
	<table align="center" cellpadding="0" cellspacing="0" bgcolor="#ffffff">
		<tbody>
			<tr>
				<td>
					<div class="x_sgwrap x_title_primary" style="text-align:center;">     
                        <h1><?=COMPANY_NAME;?></h1>
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<div class="">
						<p><b>Remitente:</b> <?=$data['fullName'];?></p>
                        <?php
                            $dataEmail = explode(".", $data['emailUser']);
                        ?>
                        <p><b>Email:</b> <?=$dataEmail[0]." .".$dataEmail[1]?></p>
                        <p><b>Telefono:</b> <?=$data['cell'];?></p>
					</div>
                    <br>
					<p>
                        <b>Mensaje:</b><br>
                        <?=$data['message'];?>
                    </p><br>
                        
                    <p style="text-align:center;">
                        <?=$data['emailUser'];?>
                        <small>Toca el enlace para responder</small>
                    </p>
				</td>
			</tr>
		</tbody>
	</table>
</body>
</html>