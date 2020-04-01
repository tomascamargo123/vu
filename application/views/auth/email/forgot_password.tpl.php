<html>
	<body style="padding:0;margin:0;">
		<table bgcolor="#4A75B5" style="width:100%;">
			<tr>
				<td style="padding:10px;"><img src="http://modlavalle.com.ar/img/logo_login.png" width="200" height="100" alt="Municipalidad de Lavalle"></td>
			</tr>
		</table>
		<table bgcolor="#ECF0F5" style="width:100%;padding-top:40px;">
			<tr>
				<td style="display:block!important;max-width:600px!important;margin:0 auto!important;clear:both!important;">
					<div style="background-color:#fff;padding:10px;max-width:600px;margin:0 auto;display:block;">
						<table style="width: 100%;">
							<tr>
								<td>
									<h3 style="color:#4A75B5"><?php echo sprintf(lang('email_forgot_password_heading'), $identity); ?></h3>
									<p><?php echo sprintf(lang('email_forgot_password_subheading'), anchor('auth/reset_password/' . $forgotten_password_code, lang('email_forgot_password_link'))); ?></p>
								</td>
							</tr>
						</table>
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<div style="padding:5px;font-size:10px;text-align:justify;margin-top:40px;border-top:2px solid #4A75B5;text-transform:uppercase;">
						La información contenida en el presente correo y en los archivos adjuntos es confidencial y de uso exclusivo para el usuario de la dirección de correo electrónico a quien está dirigido. Por ello, si no es el receptor pretendido, o el responsable de entregar este mensaje, le notificamos por este medio que la legislación vigente prohibe su copia, distribución, divulgación, retención o uso de la información que contiene.<br />
						NO RESPONDA ESTE MENSAJE YA QUE EL REMITENTE ES UNA CASILLA AUTOMÁTICA. MUNICIPALIDAD DE LAVALLE NUNCA LE SOLICITARÁ QUE REVELE SUS CLAVES POR NINGÚN MEDIO. SI USTED RECIBE UN E-MAIL O UN LLAMADO TELEFÓNICO SOLICITÁNDOLE SUS CLAVES PERSONALES, NO LO RESPONDA. NUNCA REVELE SUS CLAVES O DATOS PERSONALES BAJO NINGÚN CONCEPTO.
					</div>
				</td>
			</tr>
		</table>
	</body>
</html>