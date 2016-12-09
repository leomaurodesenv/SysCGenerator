<?php

/* Retorna o config encodado em json (fphp-addicionals.js) */
$config = parse_ini_file('config.ini');
echo json_encode($config);

?>
