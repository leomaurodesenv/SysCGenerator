<?php 

/*
 * --------------------------
 * Master defines and data
 * --------------------------
 */
 
/* Pegando as definições de path do config.ini */
if(file_exists('../../../config.ini')) $config = parse_ini_file('../../../config.ini');
elseif(file_exists('../../config.ini')) $config = parse_ini_file('../../config.ini');
elseif(file_exists('../config.ini')) $config = parse_ini_file('../config.ini');
elseif(file_exists('./config.ini'))	$config = parse_ini_file('./config.ini');
else die();

define('def_path_online', $config['path_online']);
define('def_path_pages', def_path_online.$config['path_pages']);
define('def_path_default', def_path_online.$config['path_default']);

date_default_timezone_set($config['timezone']);

/*
 * --------------------------
 * Database defines
 * --------------------------
 */

define('def_database', $config['database']);
define('def_host_sql', $config['host_sql']);
define('def_user_sql', $config['user_sql']);
define('def_pass_sql', $config['pass_sql']);
define('def_db_sql', $config['db_sql']);

/*
 * --------------------------
 * Geral defines and data
 * --------------------------
 */

define('def_home_text', '<i class="fa fa-home"></i>');
define('def_home_href', def_path_pages.'/index.php'); /* home <- event */
define('def_index_href', def_path_online.'/index.php'); /* index */
define('def_search_title', 'Pesquisar');
define('def_limit_list', 10);

?>