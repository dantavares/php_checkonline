<?php
require_once 'lazy_mofo.php';
require_once 'site.php';
$db->connect();

if (!require_auth()) {
    printf('Para gerenciar cores, é necessário que você seja perfil administrador');
    die;
}

?>

<!DOCTYPE html>
<html><head>
<title>Censo - Cores</title>
<meta charset='UTF-8'>
<link rel="shortcut icon" href="favicon.ico" />
<link rel='stylesheet' type='text/css' href='ed_style.css' />
<meta name='robots' content='noindex,nofollow'>
</head><body font-size="10px">

<?php 
site_header(); 

echo "<br><h2 align=center>Atenção! Se houver uma expressão errada, poderá afetar o funcionamento de todas as cores! </h2><br>";

$lm = new lazy_mofo($dbh, 'pt-br'); 
$lm->table = 'colors';
$lm->identity_name = 'color_id';
$lm->return_to_edit_after_insert = false;
$lm->return_to_edit_after_update = false;
$lm->grid_limit = 0;
$lm->rename['exp'] = 'Expressão Regular';
$lm->rename['rgb'] = 'Cor';
$lm->form_input_control['rgb'] = array('type' => 'form_color');
$lm->grid_output_control['rgb'] = array('type' => 'grid_color');

function form_color($column_name, $value, $command, $called_from) {
    global $lm;
    $val = $lm->clean_out($value);
    return "<input type='color' name='$column_name' value='$val' >";
}

function grid_color($column_name, $value, $command, $called_from) {
    global $lm;
    $val = $lm->clean_out($value);
    return sprintf("<div style='background-color:%s'>&nbsp;</div>",$val);
}

$lm->grid_sql = "select exp, rgb, color_id from colors";

$lm->form_sql = "
    select * from colors
    where color_id = :color_id ";

$lm->form_sql_param[':color_id'] = @$_REQUEST['color_id'];

$lm->run();
echo "<a href='https://regexr.com/' target='_blank'> Criar Expressão Regular</a>";
site_footer(false);
?>