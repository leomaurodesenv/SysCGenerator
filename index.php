<?php
/* Incluir top */
header('Content-Type: text/html; charset=utf-8');
require_once('./php/session.php'); 

/* Verifica loggin */
if(login(1)) header('Location: ./pages/index.php');
else header('Location: ./verify.php');
?>