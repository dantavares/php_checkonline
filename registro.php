<?php

require_once 'site.php';
$db->connect();

if (array_key_exists('user', $_SESSION)) {
    site_header();
    $head = "Atualização Usuário";  
    $islogged = true;
    
}
else { 
    $head = "Registro novo usuário";  
    $islogged = false;
}

$errors = array();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    check_csrf();
    $data = array();
    $keys = array('username', 'password', 'password_again');
    if (!$islogged) array_push ($keys, 'email', 'invitation');
    foreach ($keys as $key) {
        if (!array_key_exists($key, $_POST)) die;
        $data[$key] = $_POST[$key];
    }

    if (strlen($data['username']) < 3) $errors [] = 'O nome do usuário deve ser mais longo';
    if (strlen($data['username']) > 15) $errors [] = 'O nome do usuário deve ser mais curto';
    if (!preg_match('/^[-_a-zA-Z0-9]*$/', $data['username'])) $errors []= 'Caracteres inválidos no nome do usuário';
    if (strlen($data['password']) < 5) $errors [] = 'A senha é muito curta';
    if (strlen($data['password']) > 40) $errors [] = 'A senha é muito longa';
    if ($data['password'] !== $data['password_again']) $errors []= 'As senhas não conferem';
    if (strpos($data['email'], '@') === false && !$islogged) $errors [] = 'O email é inválido';
    if (strlen($data['email']) > 255 && !$islogged) $errors [] = 'O email é muito longo';

    if (empty($errors) && !$islogged) {
        $res = $db->query_params('SELECT invitation_id, user_id FROM invitations WHERE email = :email AND invitation_key = :invitation_key', array('email' => $data['email'], 'invitation_key' => $data['invitation']));
        if (!($invitation_row = $res->fetch())) {
            $errors []= 'A chave de acesso é inválida, ou não foi gerada para este email';
        }
    }

    if (empty($errors) && !$islogged) {
        $res = $db->query_params('SELECT 1 FROM users WHERE username = :username OR email = :email', array('username' => $data['username'], 'email' => $data['email'])) or die('db error');
        if ($res->fetch()) {
            $errors []= 'Usuário ou email já cadastrado';
        }
    }

    if (empty($errors)) {
        $pw = password_hash($data['password'], PASSWORD_DEFAULT) or die('password error');
        if(!$islogged){
            $db->query_params('INSERT INTO users (username, password, passkey, email, invited_by) VALUES (:username, :password, :passkey, :email, :invited_by)', array('username' => $data['username'], 'password' => $pw, 'passkey' => random_hash(), 'email' => $data['email'], 'invited_by' => $invitation_row['user_id'])) or die('db error');
            $db->query_params('DELETE FROM invitations WHERE invitation_id = :invitation_id', array('invitation_id' => $invitation_row['invitation_id'])) or die('db error');
            header(sprintf('Location: %s/login.php?success', $CONFIG['base_url']));
            die;
        }
        else {
            $db->query_params('UPDATE users SET username=:username, password=:password, passkey=:passkey WHERE user_id=:user_id LIMIT 1', array('username' => $data['username'], 'password' => $pw, 'passkey' => random_hash(), 'user_id' => $_SESSION['user']['user_id'])) or die('db error');
            header('Location: ' . $CONFIG['base_url'] .'/'. $_SESSION['pgname']);
            die;
        }
    }
}

if ($islogged && !array_key_exists('update', $_GET)) {
        header(sprintf('Location: %s/login.php?exit', $CONFIG['base_url']));
        die;
}

$msg = "<h4 align='center'> $head </h4>";

if (!empty($errors)) {
    $msg =  '<h4 align="center" class="red">Erro !</h4>';
    $msg .= '<ul>';
    foreach ($errors as $error) {
        $msg .= '<li>'.html_escape($error).'</li>';
    }
    $msg .= '</ul>';
}

form_header(basename(__FILE__),$head,$msg);

printf('Usuário:');
printf('<input name="username" type="text" value="%s" />', array_key_exists('user', $_SESSION) ? html_escape(strtoupper($_SESSION['user']['username'])) : '');
printf('<br/>');

printf('Senha:');
printf('<input name="password" type="password" />');
printf('<br/>');

printf('Confirme a senha:');
printf('<input name="password_again" type="password" />');
printf('<br/>');

if (!$islogged){
    printf('Email:');
    printf('<input name="email" type="text" value="%s" />', array_key_exists('email', $_GET) ? html_escape($_GET['email']) : '');
    printf('<br/>');
}

if (!$islogged) {
    printf('Chave de acesso:');
    printf('<input name="invitation" type="text" value="%s" />', array_key_exists('invite', $_GET) ? html_escape($_GET['invite']) : '');
    printf('<br/>');
}

printf('<button type="submit" class="pure-button pure-button-primary">%s</button>', $islogged ? 'Atualizar' : 'Registrar');
printf('</form></body>');
