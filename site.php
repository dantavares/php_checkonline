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
		
		foreach ($plist as $i) {
			if ($i) { 
				$res = $db->query_params('SELECT name FROM tables WHERE id = :ID', array('ID'=>$plist[$i]));
				$row = $res->fetch();
				if ( $row['name'] == $pgname )  { $isnauth = 0; }
				echo (' | <a href="'.$row['name'].'.php">'.ucwords(str_replace('_',' ',$row['name'])).'</a>');
			}
		}
		
		if (($_SESSION['user']['isadmin']) == '1') {
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
		
		echo ' | <a href="login.php?exit">Sair</a><br/></h4>';
		
		$db->close;
		
		if ($isnauth) {
			echo ('<BR><center> <h2>Você não está autorizado a acessar esta página!</h2></center>');
			die;
		}
		
	}
	
	function page_header($title) {
	?>
	<!DOCTYPE html>
	<html><head>
		<title>Escolas de Araçoiaba da Serra</title>
		<meta charset='UTF-8'>
		<meta http-equiv="refresh" content="300">
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta name='robots' content='noindex,nofollow'>
		<link rel="shortcut icon" href="favicon.ico" />
		<link rel='stylesheet' type='text/css' href='ed_style.css' />
		<link rel='stylesheet' type='text/css' href='print_style.css' media='print' />
		</head><body font-size="5px">
		<?php  site_header(); ?>
		<table style="width:100%">
			<tr><td><img src="data:image/png;base64,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"
				width="50" height="54" style="float:left"></td><td>
				<h1 align=center><?php echo ($title); ?></h1></td><td>
				<img src="data:image/png;base64,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"
			width="50" height="50" style="float:right"></td></tr>
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
		var close = document.getElementsByClassName("closebtn");
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
	
	
	/*Action for dialog close button*/
	for (i = 0; i < close.length; i++) {
		close[i].onclick = function () {
			var div = this.parentElement;
			div.style.opacity = "0";
			setTimeout(function () {
				div.style.display = "none";
			}, 600);
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