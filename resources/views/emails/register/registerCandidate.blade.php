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
                	<tr><td align="center" bgcolor="#5b5056" height="100"><img src="<?php echo Config::get('app.url').asset('/images/logo.png')?>" width="128" height="83" /></td></tr>
                </table>
                <table width="610" align="center" style="font-size:15px; color:#5b5056">
                	<tr><td height="60" valign="middle">Bonjour <strong>{{ $subscriber->first_name }} {{ $subscriber->last_name }},<strong></td></tr>
                    <tr>
						<td style="text-align:justify">
							Bienvenue sur  Fifty Talents ! Notre plateforme simplifie le recrutement des meilleurs talents IT. Découvrez chaque semaine, notre sélection parmi les entreprises les plus convoitées du marché.
						</td>
					</tr>
                </table>
                <table width="610" align="center">
                	<tr>
                    	<td height="60" valign="middle" width="20">
                    		<img src="<?php echo Config::get('app.url').asset('/images/T-pink.png')?>" width="17" height="29" />
                        </td>
                        <td height="60" valign="middle" style="color:#e64e66; font-size:15px;">
                            <strong>COMMENT ÇA MARCHE ?</strong>
                        </td>
                	</tr>
                </table>
				<table width="610" align="center" style="font-size:15px; color:#5b5056">
                    <tr><td style="text-align:justify">Nous vous proposons une solution unique pour rencontrer et échanger avec les recruteurs et équipes techniques proposant les challenges les plus enthousiasmants. 
En participant à l’un de nos jobs-dating online, vous aurez la possibilité de recevoir de nombreuses propositions de jobs.
Anonyme et rapide, notre concept vous permet de choisir les entreprises avec qui vous souhaitez avoir des entretiens. Avec en moyenne 4 propositions reçues par talent inscrit on s’est dit que ça vous intéresserait !
                	</td></tr>
                </table>
				<table width="610" align="center">
                	<tr>
                    	<td height="60" valign="middle" width="20">
                    		<img src="<?php echo Config::get('app.url').asset('/images/T-pink.png')?> width="17" height="29" />
                        </td>
                        <td height="60" valign="middle" style="color:#e64e66; font-size:15px;">
                            <strong>COMMENT COMMENCER ?</strong>
                        </td>
                	</tr>
                </table>
				<table width="610" align="center" style="font-size:15px; color:#5b5056">
                    <tr>
						<td style="text-align:justify"><strong>&ndash; Complétez votre profil</strong> et soumettez le sur la plateforme (retour dans les 48h en moyenne).
						</td>
					</tr>
                </table>
				<table width="610" align="center" style="font-size:15px; color:#5b5056">
                    <tr>
						<td style="text-align:justify"><strong>&ndash; Echangez avec votre Talent Manager</strong> et préparez votre participation à un Job-Dating.
						</td>
					</tr>
                </table>
				<table width="610" align="center" style="font-size:15px; color:#5b5056">
                    <tr>
						<td style="text-align:justify"><strong>&ndash; Saisissez les opportunités</strong> qui se présenteront à vous ! Nos portes s’ouvrent Lundi prochain. 
						</td>
					</tr>
					<tr>
						<td valign="middle" width="20" align="center">
							{{ link_to($url, 'Editer votre profil', array('id' => 'myButton', 'style' => 'background-color:#e64e66;color:#FFFFFF;display:inherit;width:108px;line-height: 2;vertical-align: middle;font-size: 15px;text-decoration: none')) }}
						</td>
					</tr>
                </table>
                <table width="610" align="center" style="font-size:15px; color:#5b5056">
                    <tr>
						<td style="text-align:justify">
						Êtes-vous prêt ?<br />
						A très vite !
						</td>
					</tr>
                </table>
				<table width="610" align="center">
                	<tr>
						<td height="60" style="font-size:15px;color:#5b5056">
							Adrien LENOIR<br />
							<a href="www.fiftytalents.com">www.fiftytalents.com</a>
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
