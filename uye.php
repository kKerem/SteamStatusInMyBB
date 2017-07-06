<?php
	$uidhesap=$mybb->user['uid'];
	$b=mysql_connect($ddb);
	mysql_select_db("forum",$b);
	$m=mysql_query("SELECT username, uid, email FROM $tb Where uid='$uidhesap'");

	while($y=mysql_fetch_array($m))
	{
	$email = preg_replace('(@steamcommunity.com)', '', $y['email']);
	$api = "https://api.steampowered.com/ISteamUser/GetPlayerSummaries/v2/?key=$key&format=json&steamids=".$email."&format=json";
	$json = file_get_contents($api);
	$decoded = json_decode($json);

	$aktif=$decoded->response->players[0]->personastate;
	  if($aktif==1) {
	    $oyun=$decoded->response->players[0]->gameextrainfo;
	    if($oyun=="Team Fortress 2") {
				$oyundayazisi="Oyunda";
				$sunucubaglan='<span><a style="cursor:no-drop;">Oyuna Katıl</a></span>
				<span class="durumServer" original-title="Hiçbir serverda değil"><i class="fa fa-info" aria-hidden="true"></i></span>';
	      if(!empty($decoded->response->players[0]->gameserverip)) {$sunucu=$decoded->response->players[0]->gameserverip;}
	      if(!empty($sunucu))
	      {
	        if(substr($sunucu,0,13) === "185.124.85.13") {
            ...
						$oyundayazisi="Oyunda";
						$sunucubaglan='<span><a href="steam://connect/'.$sunucu.'" original-title="Direk Bağlanmak için tıkla">Oyuna Katıl</a></span>
						<span class="durumServer" original-title="'.$sunucuismi.' sunucusunda oynuyor"><i class="fa fa-info" aria-hidden="true"></i></span>'; }
					else
					{
						$oyundayazisi="Oyunda";
						$sunucubaglan='<span><a style="cursor:no-drop;" original-title="TF2 Turkiye dışında olduğu için bağlanılamaz.">Oyuna Katıl</a></span>
						<span class="durumServer" original-title="Sadece TF2 Turkiye bilgileri görüntülenir"><i class="fa fa-info" aria-hidden="true"></i></span>';
					}
	      }
	    }
			elseif($oyun=="") {
				$oyunkontrol=1;
				$oyundayazisi="Çevrimiçi";
      }
			else {
				$oyundayazisi="Oyunda";
				$oyun=$decoded->response->players[0]->gameextrainfo;
				$sunucubaglan='<span><a style="cursor:no-drop;" original-title="TF2 Turkiye dışında olduğu için bağlanılamaz.">Oyuna Katıl</a></span>
				<span class="durumServer" original-title="Sadece TF2 Turkiye bilgileri görüntülenir"><i class="fa fa-info" aria-hidden="true"></i></span>';
			}
	  }
    else {
      $oyunkontrol=2;$oyundayazisi="Çevrımdışı";
    }
