<?php

/* Classe responsável por realizar os includes */
class FPHP_loader{
	
	private $directories = array();
	private $extensions = array();
    
	/* Construtor (extenções permitidas e diretórios) */
    public function __construct($extensions, $directories=array()){
		foreach ($directories as $name=>$path){
			$this->directories[$name] = $path;
		}
		$this->extensions = $extensions;
	}
    
	/* Inclui todos os diretórios */
	public function load_all(){
		foreach($this->directories as $k1 => $v1){
			$this->load_dir($v1);
		}
	}
	
	/* Verificar e inclui os arquivos permitidos do ($dir) */
	public function load_dir($dir){
		if(is_dir($dir)){
			$files = scandir($dir);
			foreach($files as $k2 => $v2){
				$this->load_file($dir.$v2);
			}
		}
	}
	
	/* Verifica e inclui o arquivo */
	public function load_file($path){
		$file = pathinfo($path);
		if(isset($file['extension']) && in_array($file['extension'], $this->extensions))
			require($path);
		/*echo $path.'<br>';*/
		/*else echo $file['basename'].'<br/>';*/
	}
	
}

/* Responsavel por incluir todas as classes */
$root = realpath(dirname(__FILE__)).'/';
$ext = array('php', 'class.php');

$loader = new FPHP_loader($ext);
$loader->load_file($root.'define_page.php');

$loader->load_file($root.'session.php');

$loader->load_dir($root.'fphp/class_master/');
$loader->load_dir($root.'fphp/class_slave/');

//header('Content-Type: application/json');
//var_dump($_SERVER);
//["REMOTE_ADDR"]

?>