<?php
require_once '../../methods/usermanager.php';
require_once '../../methods/conn.php';
require_once '../../methods/crypt.php';

UserManager::verifySession("../auth/login.php", ["gestao", "professor"]);
?>