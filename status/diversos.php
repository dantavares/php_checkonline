<?php
	require_once 'lazy_mofo.php';
	require_once 'site.php';
	$_SESSION['pgname'] = basename(__FILE__);
	$pgname = str_replace('.php', '', $_SESSION['pgname']);
	
	$ID = 5;
		
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if ($_POST['isupt'] == '1') {
			$rs = $dbh->query("SELECT isupt FROM tables WHERE id = $ID");
			$col = $rs->fetch(PDO::FETCH_OBJ);
			echo $col->isupt;
			die;
		}	
	}
	
	page_header(ucfirst($pgname),'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4KPCEtLSBMaWNlbnNlOiBNSVQuIE1hZGUgYnkgRXNyaTogaHR0cHM6L
	y9naXRodWIuY29tL0VzcmkvY2FsY2l0ZS11aS1pY29ucyAtLT4KPHN2ZyB3aWR0aD0iODAwcHgiIGhlaWdodD0iODAwcHgiIHZpZXdCb3g9IjAgMCAyNCAyNCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAv
	c3ZnIj48cGF0aCBkPSJNMTAgMTBIMlYyaDh6TTMgOWg2VjNIM3ptMTggMWgtOFYyaDh6bS03LTFoNlYzaC02em0zIDEzLjY1N0wxMS4zNDMgMTcgMTcgMTEuMzQzIDIyLjY1NyAxN3pNMTIuNzU3IDE3TDE3IDIxLjI
	0MyAyMS4yNDMgMTcgMTcgMTIuNzU3ek0xMCAyMUgydi04aDh6bS03LTFoNnYtNkgzeiIvPjxwYXRoIGZpbGw9Im5vbmUiIGQ9Ik0wIDBoMjR2MjRIMHoiLz48L3N2Zz4=');
		
	$rs = $dbh->query("SELECT lstupt FROM tables WHERE id = $ID");
	$col = $rs->fetch(PDO::FETCH_OBJ);
	$data = date_create($col->lstupt);
	echo "<BR><table><tr><td>Ultima Atualização: </td><td>" . date_format($data, 'd/m/y - H:i') . "</td></tr></table>";
	
	$lm = new lazy_mofo($dbh, 'pt-br');
	$lm->table = $pgname;
	$lm->identity_name = 'id';
	$lm->top_table = true;
	
	if (!$_SESSION['user']['isadmin']) $lm->grid_add_link = '';
	
	$lm->grid_sql = sprintf("
	SELECT unidade,	provedor, 
	ip_pub as 'IP Publico / DDNS',
	ip_loc as 'IP Local',
	nvr_p as 'Porta',
	status %s
	FROM $pgname
	where coalesce(provedor, '')
	like :_search or coalesce(unidade, '')
	like :_search or coalesce(provedor, '')
	like :_search or coalesce(status, '')
	like :_search order by unidade
	", ($_SESSION['user']['isadmin']) ? ', id' : '');
	
	$lm->grid_sql_param[':_search'] = '%' . trim($_REQUEST['_search'] ?? '') . '%';
	
	$lm->rename['ip_pub'] = 'IP Público / DDNS';
	$lm->rename['ip_loc'] = 'IP Local';
	$lm->rename['nvr_p'] = 'Porta';
	$lm->form_input_control['nvr_p'] = array('type' => 'form_numero');
	$lm->form_input_control['n_cam'] = array('type' => 'form_numero');
	$lm->form_input_control['nvr_http_p'] = array('type' => 'form_numero');
	$lm->return_to_edit_after_insert = false;
	$lm->return_to_edit_after_update = false;
	$lm->grid_show_search_box = true;

	$lm->form_sql = "
	SELECT id, unidade, provedor,
	ip_pub,	ip_loc,	nvr_p
	FROM $pgname
	where id = :id ";

	$lm->form_sql_param[':id'] = @$_REQUEST['id'];

	$lm->run();
	site_footer();
?>
