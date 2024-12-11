<?php
require_once 'site.php';
$db->connect();
?>

<!DOCTYPE HTML>
<head>
<meta charset="utf-8" />
</head>
<body>

<?php
site_header();

if (!require_auth()) {
    printf('Para gerar / gerenciar convites, é necessário que você seja perfil administrador');
    die;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    check_csrf();
    if (!array_key_exists('email', $_POST)) {
        die;
    }
    
    $email = $_POST['email'];
    if (strpos($email, '@') === false) {
        header(sprintf('Location: %s/convite.php?emailinv', $CONFIG['base_url']));
        die;
    }

    $res = $db->query_params("SELECT email FROM users WHERE email = :email", array('email' => $email)) or die('db error');
    if ($res->fetch()) {
        header(sprintf('Location: %s/convite.php?emailje', $CONFIG['base_url']));
        die;
    }
    
    $db->query_params('INSERT INTO invitations (user_id, email, invitation_key) VALUES (:user_id, :email, :invitation_key)', array('user_id' => $_SESSION['user']['user_id'], 'email' => $email, 'invitation_key' => random_hash())) or die('db error');
    header(sprintf('Location: %s/convite.php?success', $CONFIG['base_url']));
    die;
} 
else { 
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if (array_key_exists('delete', $_GET)) {
            $db->query_params("DELETE from invitations WHERE invitation_id = :invitation_id", array('invitation_id' => $_GET['delete'])) or die('db error');
            header(sprintf('Location: %s/convite.php', $CONFIG['base_url']));
            die;
        }
    }
}

$msg = '<h4 align="center">Novo Convite</h4>';

if (array_key_exists('emailinv', $_GET)) {
    $msg = '<h4 align="center" class="red">Email inválido!</h4>';
}

if (array_key_exists('emailje', $_GET)) {
    $msg = '<h4 align="center" class="red">Este email já está cadastrado!</h4>';
}

form_header(basename(__FILE__),'Convite - Painel Censo',$msg);
printf('<input name="email" type="text" placeholder="Email" class="pure-input-1" /><br/>');
printf('<button type="submit" class="pure-button pure-button-primary">Criar convite</button>');
printf('</fieldset></form></div>');

$res = $db->query_params('SELECT username, email FROM users WHERE invited_by = :invited_by ORDER BY username', array('invited_by' => $_SESSION['user']['user_id']));
if ($res) {
    $any = false;
    while ($row = $res->fetch()) {
        if (!$any) {
            $any = true;
            printf('Você já convidou:');
            printf('<br/>');
        }
        printf('%s', html_escape($row['username']));
        printf(' - ');
        printf('%s, ', html_escape($row['email']));
    }
    if ($any) { printf("<br/>"); }
}

$res = $db->query_params('SELECT invitation_id, email, invitation_key FROM invitations WHERE user_id = :user_id ORDER BY invitation_id DESC;', array('user_id' => $_SESSION['user']['user_id']));
if ($res) {
    $any = false;
    $first = true;
    while ($row = $res->fetch()) {
        if (!$any) {
            $any = true;
            if (array_key_exists('success', $_GET)) {
                printf('<br/>Envie o link, ou somente a chave de acesso para o convidado para ele poder se registrar:<br/><br>');
            }
            else {
                printf('<br/>Você possui convite(s) em aberto: <br/></br>');
            }
        }
        
        echo 'Email solicitado: ';
        printf('%s', html_escape($row['email']));
        echo '<br/>';
        echo 'Chave de acesso: ';
        printf('%s', $row['invitation_key']);
        echo '<br/> Link de registro: ';
        printf('<a href="%s/registro.php?invite=%s&email=%s">Clique com o botão direito aqui para copiar o link</a><br>', $CONFIG['base_url'], $row['invitation_key'], $row['email']);
        printf('<a href="%s?delete=%s" onclick="return confirm(%s);" > Excluir este convite </a>', basename(__FILE__), $row['invitation_id'], "'Tem certeza que deseja excluir o convite do ".$row['email']."'");
        echo '<br/></br>';
        
        if ($first && array_key_exists('success', $_GET)) { 
            echo 'Outro(s) convite(s) seu em aberto: <br/></br>'; 
            $first = false;
        }
        
    }
}
site_footer(false);
?>
