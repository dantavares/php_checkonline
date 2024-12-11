<?php
	require_once 'lazy_mofo.php';
	require_once 'site.php';
	$_SESSION['pgname'] = basename(__FILE__);
	
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if ($_POST['isupt'] == '1') {
			$rs = $dbh->query("SELECT isupt FROM tables WHERE id = 1");
			$col = $rs->fetch(PDO::FETCH_OBJ);
			echo $col->isupt;
			#echo "Teste 2";
			die;
		}	
	}
	
	page_header('Escolas de Araçoiaba da Serra', "data:image/png;base64,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");
	
	$rs = $dbh->query("SELECT lstupt FROM tables WHERE id = 1");
	$col = $rs->fetch(PDO::FETCH_OBJ);
	$data = date_create($col->lstupt);
	echo "<BR><table><tr><td>Ultima Atualização: </td><td>" . date_format($data, 'd/m/y - H:i') . "</td></tr></table>";
	
	$lm = new lazy_mofo($dbh, 'pt-br');
	$lm->table = 'esc_aracoiaba';
	$lm->identity_name = 'id';
	$lm->top_table = true;
	
	if (!$_SESSION['user']['isadmin']) $lm->grid_add_link = '';
	
	$lm->grid_sql = sprintf("
		SELECT unidade as Unidade,
		provedor, ip_pub as 'IP Publico',
		ip_loc as 'IP Local',
		nvr_p as 'Porta NVR Dados',
		nvr_http_p as 'Porta NVR HTTP',
		alm_p as 'Porta Alarme',
		n_cam as 'Num. Cameras',
		status_nvr as 'Status NVR',
		status_al as 'Status Alarme' %s
		FROM esc_aracoiaba
		where coalesce(provedor, '')
		like :_search or coalesce(unidade, '')
		like :_search or coalesce(provedor, '')
		like :_search or coalesce(status_nvr, '')
		like :_search or coalesce(status_al, '')
		like :_search order by unidade
		", ($_SESSION['user']['isadmin']) ? ', id' : '');
	
	$lm->grid_sql_param[':_search'] = '%' . trim($_REQUEST['_search'] ?? '') . '%';
	
	$lm->rename['ip_pub'] = 'IP Público';
	$lm->rename['ip_loc'] = 'IP Local';
	$lm->rename['nvr_p'] = 'Porta dados NVR';
	$lm->rename['nvr_http_p'] = 'Porta HTTP NVR';
	$lm->rename['alm_p'] = 'Porta Alarme';
	$lm->rename['n_cam'] = 'Num. Cameras';
	$lm->form_input_control['nvr_p'] = array('type' => 'form_numero');
	$lm->form_input_control['n_cam'] = array('type' => 'form_numero');
	$lm->form_input_control['alm_p'] = array('type' => 'form_numero');
	$lm->form_input_control['nvr_http_p'] = array('type' => 'form_numero');
	$lm->return_to_edit_after_insert = false;
	$lm->return_to_edit_after_update = false;

	$lm->grid_show_search_box = true;	

	$lm->form_sql = "
		SELECT id, unidade,	provedor,
		ip_pub,	ip_loc,	nvr_p,
		nvr_http_p,	alm_p, n_cam
		FROM esc_aracoiaba
		where id = :id ";

	$lm->form_sql_param[':id'] = @$_REQUEST['id'];

	$lm->run();
	site_footer();
?>
