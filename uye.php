$uidhesap = $mybb->get_input('uid', MyBB::INPUT_INT);
	$b=mysql_connect("host","id","pw");
	mysql_select_db("db",$b);
	mysql_query("SET NAMES 'utf8'");
	mysql_query("SET CHARACTER SET utf8_general_ci");
	$m=mysql_query("SELECT username, uid, email FROM mybb_users Where uid='$uidhesap'");

	while($y=mysql_fetch_array($m))
	{
	$email = preg_replace('(@steamcommunity.com)', '', $y['email']);
	$api = "https://api.steampowered.com/ISteamUser/GetPlayerSummaries/v2/?key=".$key."&format=json&steamids=".$email."&format=json";
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
						if($sunucu=="185.124.85.131:27015")	$sunucuismi="Mario Kart";
						elseif($sunucu=="185.124.85.131:27016")	$sunucuismi="Mario Kart #2";
						elseif($sunucu=="185.124.85.132:27015")	$sunucuismi="Trade";
						elseif($sunucu=="185.124.85.132:27016")	$sunucuismi="Premium Trade";
						elseif($sunucu=="185.124.85.133:27015")	$sunucuismi="Orange X7";
						elseif($sunucu=="185.124.85.133:27016")	$sunucuismi="Orange X7 #2";
						elseif($sunucu=="185.124.85.134:27015")	$sunucuismi="Deathrun";
						elseif($sunucu=="185.124.85.135:27015")	$sunucuismi="Saxton Hale";
						elseif($sunucu=="185.124.85.135:27016")	$sunucuismi="Saxton Hale #2";
						elseif($sunucu=="185.124.85.136:27015")	$sunucuismi="Jailbreak";
						elseif($sunucu=="185.124.85.136:27016")	$sunucuismi="Jailbreak #2";
						elseif($sunucu=="185.124.85.137:27015")	$sunucuismi="Surf";
						elseif($sunucu=="185.124.85.137:27016")	$sunucuismi="Slender Fortress";
						elseif($sunucu=="185.124.85.137:27017")	$sunucuismi="Jump Academy";
						elseif($sunucu=="185.124.85.138:27015")	$sunucuismi="Public";
						elseif($sunucu=="185.124.85.138:27016")	$sunucuismi="Medieval Wars";
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
				$oyundayazisi="Çevrimiçi";}
			else {
				$oyundayazisi="Oyunda";
				$oyun=$decoded->response->players[0]->gameextrainfo;
				$sunucubaglan='<span><a style="cursor:no-drop;" original-title="TF2 Turkiye dışında olduğu için bağlanılamaz.">Oyuna Katıl</a></span>
				<span class="durumServer" original-title="Sadece TF2 Turkiye bilgileri görüntülenir"><i class="fa fa-info" aria-hidden="true"></i></span>';
			}
	  } else {$oyunkontrol=2;$oyundayazisi="Çevrımdışı";}
	}
