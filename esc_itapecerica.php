<?php
	require_once 'lazy_mofo.php';
	require_once 'site.php';
	$_SESSION['pgname'] = basename(__FILE__);
	$pgname = str_replace('.php', '', $_SESSION['pgname']);
	
	$ID = 3;
		
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if ($_POST['isupt'] == '1') {
			$rs = $dbh->query("SELECT isupt FROM tables WHERE id = $ID");
			$col = $rs->fetch(PDO::FETCH_OBJ);
			echo $col->isupt;
			die;
		}	
	}
	
	page_header('Escolas Itapecerica da Serra','data:image/png;base64,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');
		
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
