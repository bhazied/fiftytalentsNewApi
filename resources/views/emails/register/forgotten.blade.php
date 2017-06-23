<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
	</head>
	<body>
		<table width="100%">
			<tbody>
				<tr>
					<td>
						<table width="650" align="center">
							<tr><td align="center" bgcolor="#5b5056" height="100"><img src="<?php echo Config::get('app.url')?>/assets/images/logo.png" width="128" height="83" /></td></tr>
						</table>
						<table width="610" align="center" style="font-size:15px; color:#5b5056">
							<tr><td height="40" valign="middle">Bonjour @if(!empty($subscriber)){{ $subscriber->first_name.' '.$subscriber->last_name }} @else {{ $teams->full_name }} @endif,</td></tr>
						</table>
						<table width="610" align="center" style="font-size:15px; color:#5b5056">
							<tr>
								<td style="text-align:justify">
									Voici votre nouveau mot de passe à n’oublier sous aucun prétexte !
Bonne navigation avec {{ $password }} sur le site www.fiftytalents.com.

								</td>
							</tr>
							<tr>
								<td valign="middle" width="20" align="center">
									{{ link_to($url, 'Se connecter', array('id' => 'myButton', 'style' => 'background-color:#e64e66;color:#FFFFFF;display:inherit;width:108px;line-height: 2;vertical-align: middle;font-size: 15px;text-decoration: none')) }}
								</td>
							</tr>
						</table>
						<table width="610" align="center" style="font-size:15px; color:#5b5056">
							<tr>
								<td style="text-align:justify">
									À très vite.<br />
L’équipe Fifty Talents.
								</td>
							</tr>
						</table>
						<table width="650" align="center" style="vertical-align: initial;" align="center" bgcolor="#ada3a8" height="80">
							<tr>
								<td align="center">
									<p style="font-size:15px;color:white;">Invitez vos amis sur Fifty Talents et 
									soyez récompensé lorsqu’ils sont recrutés</p>
								</td>
							</tr>
							<tr>
								<td valign="middle" width="20" align="center">
									{{ link_to('home/share', 'Partager', array('id' => 'myButton', 'style' => 'background-color:#e64e66;color:#FFFFFF;display:inherit;width:108px;line-height: 2;vertical-align: middle;font-size: 15px;text-decoration: none')) }}
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</tbody>
		</table>
	</body>
</html>
