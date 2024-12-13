<!DOCTYPE html>
<html><head>
<title>Usuários</title>
<meta charset='UTF-8'>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="shortcut icon" href="favicon.ico" />
<link rel='stylesheet' type='text/css' href='ed_style.css' />
<meta name='robots' content='noindex,nofollow'>
</head><body font-size="10px">

<?php 
require_once 'lazy_mofo.php';
require_once 'site.php';
$_SESSION['pgname'] = basename(__FILE__);
$db->connect();
site_header(); 

if (!($_SESSION['user']['isadmin'])) {
    printf('Para gerenciar usuários, é necessário que você seja administrador');
    die;
}

$lm = new lazy_mofo($dbh, 'pt-br'); 
$lm->table = 'users';
$lm->identity_name = 'user_id';
$lm->return_to_edit_after_insert = false;
$lm->return_to_edit_after_update = false;
$lm->grid_limit = 0;
$lm->top_table = false;
$lm->form_input_control['isadmin'] = array('type' => 'checkbox');
$lm->rename['username'] = 'Usuário';
$lm->rename['isadmin'] = 'Administrador';
$lm->rename['rstpsswd'] = 'Resetar senha para: 123456';
$lm->rename['pg_list'] = 'Lista de páginas';
$lm->form_input_control['rstpsswd'] = array('type' => 'checkbox');
$lm->form_input_control['pg_list'] = array("type" => 'pg_list');
$lm->after_update_user_function = 'after_update';
$lm->on_update_user_function = 'on_update';

function on_update(){
	 global $lm;
}

function pg_list($column_name, $value, $command, $called_from){
	
    // $column_name: field name
    // $value: field value  
    // $command: array defined in the control, or string with legacy syntax; rarely needed
    // $called_from: origin of call; 'form', or 'grid'; rarely needed

    global $lm;
	global $db;
	$ret = '';
	
    $res = $db->query_params("select p_list from users where user_id = " . $_GET[$lm->identity_name]);
	$row = $res->fetch();
    		
	$plist = json_decode($row['p_list']);
	
	$res = $db->query_params('SELECT id, name FROM tables');
	
	while($row = $res->fetch()) {
		$N = count($plist);
		for($i=0; $i < $N; $i++) {
			if  ($plist[$i] == $row['id']) { 
				$ck = "checked";
				break;
			}
			else {
				$ck = '';
			}
		}
		
		$ret .= "<input type='checkbox' name='lst_pg[]' value='".$row['id']."' $ck>".ucwords(str_replace('_',' ',$row['name']))."</input><BR>";
	}	
	
	return $ret;
}

function after_update(){
    global $lm;
    
    if ($_POST['rstpsswd'] == '1') {
        $sql_param = array(':user_id' => $_POST['user_id'], ':passkey' => random_hash());
        $sql = "UPDATE users SET 
        password='$2y$10$7uGM/flOMPqvho3H3T5CKOjkyEX0g5FSNPpKnsp.dl6wAEJGCe03u', 
        passkey = :passkey
        WHERE user_id = :user_id";
        $lm->query($sql, $sql_param);
    }

	$lst_pg = $_POST['lst_pg'];
		
	if (!empty($lst_pg)){
		$jplist = '[0';
		
		$N = count($lst_pg);
		for($i=0; $i < $N; $i++) {
			$jplist .= ',' . $lst_pg[$i];
		}
		
		$jplist .= ']';
		
		$sql_param = array(':user_id' => $_POST['user_id'], ':p_list' => $jplist);
        $sql = "UPDATE users SET p_list=:p_list WHERE user_id = :user_id";
        $lm->query($sql, $sql_param);
	}
	else {
		$sql_param = array(':user_id' => $_POST['user_id']);
        $sql = "UPDATE users SET p_list='[0]' WHERE user_id = :user_id";
        $lm->query($sql, $sql_param);
	}
}

//Usuário id = 1 é o Superadministrador, não pode ser rebaixado ou excluído.
$lm->grid_sql = "
    SELECT t1.username, t1.email, 
    t2.username as convidado_por,  
    CASE WHEN t1.isadmin = 1 THEN 'Sim' ELSE 'Não' END as isadmin, 
    t1.user_id
    from users as t1
    LEFT JOIN users as t2
    on t1.invited_by = t2.user_id
    where t1.user_id !=1";

$lm->form_sql = "
    select user_id, username, 
	email, isadmin,
	0 as rstpsswd,
	(select name from tables where id = 1) as pg_list
    from users
    where user_id = :user_id ";

$lm->form_sql_param[':user_id'] = @$_REQUEST['user_id'];

$lm->run();
site_footer(false);
?>
