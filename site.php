<?php
	require_once 'db.php';
	ob_start();
	
	$db_json = file_get_contents('db_config.json');
	if (!$db_json) {die('Erro lendo db_config.json');}
	$dbconf = json_decode($db_json);
	
	$db_host = $dbconf->host;
	$db_name = $dbconf->dbname;
	$db_user = $dbconf->user;
	$db_passwd = $dbconf->password;
	
	$CONFIG = array(
    'db' => array(
	'connection_string' => 'mysql:host=' . $db_host . ';dbname=' . $db_name,
	'type' => 'mysql', 'user' => $db_user, 'password' => $db_passwd,
    ),
    #Pode definir na variavel base_url outro endereco do sistema, que nao seja o padrao
    'base_url' => sprintf("%s%s/status",'http://',$_SERVER['HTTP_HOST']),
	);
	
	/**************************************************************************
		*    Nao altere nada abaixo desta linha se nao souber o que esta fazendo! *
	***************************************************************************/
	$db = $CONFIG['db']['type'] === 'mysql' ? new MySqlDatabase() : new PostgreSqlDatabase();
	
	try {
		$dbh = new PDO("mysql:host=$db_host;dbname=$db_name;", $db_user, $db_passwd);
		} catch (PDOException $e) {
		die('Erro de conexao com banco de dados: ' . $e->getMessage());
	}
	
	function form_numero($column_name, $value, $command, $called_from) {
		global $lm;
		$val = $lm->clean_out($value);
		return "<input type='text' name='$column_name' value='$val' size='10' title='Apenas número inteiro maior que zero' pattern='^[1-9]\d*$'>";
	}
	
	function form_data($column_name, $value, $command, $called_from) {
		global $lm;
		$val = $lm->clean_out($value);
		return "<input type='date' name='$column_name' value='$val' >";
	}
	
	function html_escape($s) {
		return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
	}
	
	function random_hash() {
		$s = openssl_random_pseudo_bytes(30);
		if ($s === null) {
			die('nao foi possivel gerar a chave');
		}
		return md5($s);
	}
	
	function islogged() {
		if (array_key_exists('user', $_SESSION)) {
			return true;
			} else {
			return false;
		}
	}
	
	function require_auth() {
		global $CONFIG;
		if (!array_key_exists('user', $_SESSION)) {
			header(sprintf("Location: %s/login.php", $CONFIG['base_url']));
			die;
			} else {
			if (($_SESSION['user']['isadmin']) == '1') {
				return true;
				} else {
				return false;
			}
		}
	}
	
	function check_csrf() {
		if (!array_key_exists('csrf', $_POST) || $_POST['csrf'] !== $_SESSION['csrf']) {
			die;
		}
	}
	
	function csrf_html() {
		printf('<input type="hidden", name="csrf" value="%s" />', html_escape($_SESSION['csrf']));
	}
	
	function gen_csrf($replace = false) {
		if ($replace || !array_key_exists('csrf', $_SESSION)) {
			$_SESSION['csrf'] = random_hash();
		}
	}
	
	function logout() {
		global $CONFIG;
		if (array_key_exists('user', $_SESSION)) {
			unset($_SESSION['user']);
		}
		
		header('Location: ' . $CONFIG['base_url'] . '/login.php?exit');
	}
	
	function form_header($page, $title, $msg) {
		echo '<!DOCTYPE html>';
		echo '<html><head>';
		printf("<title>%s</title>", $title);
		echo '<meta name="viewport" content="width=device-width, initial-scale=1" />';
		echo '<meta charset="UTF-8">';
		echo '<link rel="shortcut icon" href="favicon.ico" />';
		echo '<link rel="stylesheet" type="text/css" href="pureform.css" />';
		echo '<link rel="stylesheet" type="text/css" href="ed_style.css" />';
		echo '</head><body>';
		echo '<div class="wrapper"><div class="highlight"><div class="center">';
		printf('<form class="pure-form pure-form-stacked" method="POST" action="%s">', $page);
		csrf_html();
		printf("<fieldset><legend>%s</legend>", $msg);
	}
	
	function site_header() {
		GLOBAL $db;
		$isnauth = 1;
		$plist = json_decode($_SESSION['user']['p_list']);
		$pgname = str_replace('.php', '', $_SESSION['pgname']);
		
		if ($_SESSION['pgname'] == 'index.php') {
			$isnauth = 0;
		}
		else {
			$isnauth = 1;
		}
		
		if (islogged()) {
			echo '<h4 id="printbt">';
			printf('Usuário: <a href="registro.php?update">%s</a>', html_escape(strtoupper($_SESSION['user']['username'])));
		} 
		else {
			require_auth();
		}
		
		$db->connect();
		
		if ($_SESSION['user']['isadmin']) {
			$isnauth = 0;
			
			$res = $db->query_params('SELECT name FROM tables');
			while($row = $res->fetch()) {
				echo (' | <a href="'.$row['name'].'.php">'.ucwords(str_replace('_',' ',$row['name'])).'</a>'); 
			}
			
			echo ' | ';
			echo '<a href="convite.php">Convites</a>';
			echo ' | ';
			echo '<a href="usuarios.php">Usuários</a>';
			echo ' | ';
			echo '<a href="cores.php">Cores</a>';
		}
		else {
			if (count($plist) == 1) {
				$res = $db->query_params('SELECT email FROM users WHERE user_id = 1');
				$row = $res->fetch();
				echo ' | <a href="login.php?exit">Sair</a><br/></h4>';
				echo '<BR><center> <h2>Aguarde o Administrador te conceder os acessos necessários<BR><BR>';
				echo "Em caso de dúvidas envie um email para: <a href='mailto:".$row['email']."'>".$row['email'].'</h2></center>';
				die;
			}
			
			$cnt = count($plist);
			$res = $db->query_params('SELECT id, name FROM tables');		
			while($row = $res->fetch()) {
				for($i=0; $i < $cnt; $i++) {
					if  ($plist[$i] == $row['id']) { 
						if ($row['name'] == $pgname) $isnauth = 0;
						echo (' | <a href="'.$row['name'].'.php">'.ucwords(str_replace('_',' ',$row['name'])).'</a>');
						break;
					}
				}
			}
		}
		
		echo ' | <a href="login.php?exit">Sair</a><br/></h4>';
		
		$db->close;
		
		if ($isnauth) {
			echo ('<BR><center> <h2>Você não está autorizado a acessar esta página!</h2></center>');
			die;
		}
	}
	
	function page_header($title,$pgicon) {
	?>
	<!DOCTYPE html>
	<html><head>
		<title><?php echo ($title); ?></title>
		<meta charset='UTF-8'>
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta name='robots' content='noindex,nofollow'>
		<link rel="shortcut icon" href="favicon.ico" />
		<link rel='stylesheet' type='text/css' href='ed_style.css' />
		<link rel="stylesheet" type='text/css' href="alertify.css" />
		<script src="alertify.js"></script>
		</head><body font-size="5px">
		<?php  site_header(); ?>
		<table style="width:100%">
			<tr><td><img src="data:image/png;base64,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"
				width="50" height="54" style="float:left"></td><td>
				<h1 align=center><?php echo ($title); ?></h1></td><td>
			<img src="<?php  echo($pgicon); ?>"width="50" height="50" style="float:right"></td></tr>
		</table>
		<?php
		}
		
		function site_footer($color=true) {
		?>
	</body>
	<footer>
		<p style="font-size:10px" align='center' id='printbt'>Desenvolvido por: Daniel R. Tavares<br>
		<a href="mailto:dantavares@gmail.com">dantavares@gmail.com</a></p>
	</footer>
	<script>
		var table, tbody, rowCount, cellCount, value;
		//var close = document.getElementsByClassName("closebtn");
		var i;
		var httpRequest;
		
		setInterval(makeRequest, 300000);
		
		/*Ajax consult request to refresh page*/
		function makeRequest() {
			if (window.XMLHttpRequest) { // Mozilla, Safari, ...
				httpRequest = new XMLHttpRequest();
				} else if (window.ActiveXObject) { // IE
				try {
					httpRequest = new ActiveXObject("Msxml2.XMLHTTP");
				}
				catch (e) {
					try {
						httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
					}
					catch (e) {}
				}
			}
			
			if (!httpRequest) {
				alert('Giving up :( Cannot create an XMLHTTP instance');
				return false;
			}
			
			httpRequest.onreadystatechange = refreshpage;
			httpRequest.open('POST', <?php echo ("'".$_SESSION['pgname']."'"); ?>);
			httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			httpRequest.send('isupt=1');
		}
		
		function refreshpage() {
			if (httpRequest.readyState === 4) {
				if (httpRequest.status === 200) {
					if (httpRequest.responseText == '0'){
						location.reload();
					}
				} 
				else {
					alert('There was a problem with the request.');
				}
			}
		}
		
		/*Background Conditional format by value*/
		table=document.getElementsByClassName('lm_grid')[0];
		if(table.childNodes[1]) tbody=table.childNodes[1];
		if(tbody) rowCount=tbody.childNodes.length;
		
		for(i=0;i<rowCount;i++){
			cellCount=tbody.childNodes[i].childNodes.length;
			for(j=1;j<cellCount;j++){
				value=tbody.childNodes[i].childNodes[j].outerText.replaceAll(/\s/g,'');
				<?php
					if ($color){
						global $db;
						$db->connect();
						$res = $db->query_params("SELECT * from colors") or die('db error');
						while ($row = $res->fetch()) {
							printf("if(value.match(/%s/)) tbody.childNodes[i].childNodes[j].setAttribute('style','background-color: %s');\n", $row['exp'], $row['rgb']);
						}
					}
				?>
				j+=1;
			}
			i+=1;
		}
	</script></html>
	<?php
	}
	
session_start();
gen_csrf();