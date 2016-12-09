<?php
/* Definindo charset - necessário a partir do php 5.3 */
header('Content-type: application/json; charset=utf-8');
/* Inclui sessão */
require_once('../session.php');

/* logout */
sign_out();
header('Location: ../../index.php');
exit;

?>
