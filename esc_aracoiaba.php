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
	
	page_header('Escolas de Araçoiaba da Serra');
	
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
