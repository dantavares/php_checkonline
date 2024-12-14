<?php

require_once 'site.php';
$db->connect();
$error = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    check_csrf();
    $data = array();
    $keys = array('username', 'password');
    foreach ($keys as $key) {
        if (!array_key_exists($key, $_POST)) {
            die;
        }
        $data[$key] = $_POST[$key];
    }
    
    if ($data['username'] == '') {
        header('Location: ' . $CONFIG['base_url']);
        die;
    }
    
    $res = $db->query_params('SELECT user_id, password, isadmin, p_list FROM users WHERE username = :username LIMIT 1', array('username'=>$data['username'])) or die('db error');
    if ($row = $res->fetch()) {
        if (!password_verify($data['password'], $row['password'])) {
            $error = true;
        }
    } else {
        $error = true;
    }

    if (!$error) {
        $_SESSION['user'] = array(
            'username' => $data['username'],
            'user_id' => $row['user_id'],
            'isadmin' => $row['isadmin'],
			'p_list' => $row['p_list']
        );

        header('Location: ' . $CONFIG['base_url'] .'/');
        die;
    }
}

$msg = '<h4 align="center"> Login - Status </h4>';

if (array_key_exists('success', $_GET)) {
    $msg = '<h4 align="center" class="green">Registro completo, faça login agora</h4>';
}

if (array_key_exists('exit', $_GET) && array_key_exists('user', $_SESSION)) {
    unset($_SESSION['user']);
    $msg = '<h4 align="center" class="green">Você saiu do sistema</h4>';
}

if ($error) {
    $msg = '<h4 align="center" class="red">Usuário ou Senha inválido</h4>';
}

form_header(basename(__FILE__),'Login',$msg);
printf('<input name="username" type="text" placeholder="Usuário" class="pure-input-1" /><br/>');
printf('<input name="password" type="password" placeholder="Senha" class="pure-input-1" /><br/>');
printf('<button type="submit" class="pure-button pure-button-primary">Entrar &rarr;</button> ou <a href="registro.php">Cadastrar</a> ');
printf('</form>');
