<?php
require_once 'lazy_mofo.php';
require_once 'site.php';
$db->connect();

if (!require_auth()) {
    printf('Para gerenciar usuários, é necessário que você seja perfil administrador');
    die;
}

?>

<!DOCTYPE html>
<html><head>
<title>Censo - Usuários</title>
<meta charset='UTF-8'>
<link rel="shortcut icon" href="favicon.ico" />
<link rel='stylesheet' type='text/css' href='ed_style.css' />
<meta name='robots' content='noindex,nofollow'>
</head><body font-size="10px">

<?php 
site_header(); 

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
$lm->form_input_control['rstpsswd'] = array('type' => 'checkbox');
$lm->after_update_user_function = 'reset_passwd';

function reset_passwd(){
    global $lm;
    
    if ($_POST['rstpsswd'] == '1') {
        $sql_param = array(':user_id' => $_POST['user_id'], ':passkey' => random_hash());
        $sql = "UPDATE users SET 
        password='$2y$10$7uGM/flOMPqvho3H3T5CKOjkyEX0g5FSNPpKnsp.dl6wAEJGCe03u', 
        passkey = :passkey
        WHERE user_id = :user_id";
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
    select user_id, username, email, isadmin, 0 as rstpsswd
    from users
    where user_id = :user_id ";

$lm->form_sql_param[':user_id'] = @$_REQUEST['user_id'];

$lm->run();
site_footer(false);
?>
