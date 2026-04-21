<?php
	require_once 'lazy_mofo.php';
	require_once 'site.php';
	$_SESSION['pgname'] = basename(__FILE__);
	$pgname = str_replace('.php', '', $_SESSION['pgname']);
	
	$ID = 4;
		
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if ($_POST['isupt'] == '1') {
			$rs = $dbh->query("SELECT isupt FROM tables WHERE id = $ID");
			$col = $rs->fetch(PDO::FETCH_OBJ);
			echo $col->isupt;
			die;
		}	
	}
	
	page_header('Câmara Municipal Barueri','data:image/png;base64,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');
		
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
	nvr_p as 'Porta NVR Dados',
	nvr_http_p as 'Porta NVR HTTP',
	n_cam as 'Num. Cameras',
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
	$lm->rename['nvr_p'] = 'Porta dados NVR';
	$lm->rename['nvr_http_p'] = 'Porta HTTP NVR';
	$lm->rename['n_cam'] = 'Num. Cameras';
	$lm->form_input_control['nvr_p'] = array('type' => 'form_numero');
	$lm->form_input_control['n_cam'] = array('type' => 'form_numero');
	$lm->form_input_control['nvr_http_p'] = array('type' => 'form_numero');
	$lm->return_to_edit_after_insert = false;
	$lm->return_to_edit_after_update = false;
	$lm->grid_show_search_box = true;

	$lm->form_sql = "
	SELECT id, unidade,	provedor,
	ip_pub,	ip_loc,	nvr_p,
	nvr_http_p,	n_cam
	FROM $pgname
	where id = :id ";

	$lm->form_sql_param[':id'] = @$_REQUEST['id'];

	$lm->run();
	site_footer();
?>
