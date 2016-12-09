<?php

/* Responsavel pelos dados na sessao/coockie */
class FPHP_smart_session{

	/* Instancia a sessao global */
	private static $session = null;
	
    /* Verifica o session_start() e existencia de session [bool(1)] */
    private $open = false;
    private $exist = false;
    
    /* Informacoes da session [string, array(strings)] */
	private $name;
    private $params;

	/* Construtor (Verificando existencia da session) */
    public function __construct(){
		$this->open = false;
		$this->name = session_name();
		if(ini_get('session.use_trans_sid') && !ini_get('session.use_only_cookies'))
			$this->exist = isset($_GET[$this->name]);
		elseif(ini_get('session.use_cookies'))
			$this->exist = isset($_COOKIE[$this->name]);
    }

	/* Instantica uma classe global */
	public static function session() {
		if(self::$session == null){
			self::$session = new self();
		}
		return self::$session;
	}
	
	/* Verifica se esta com a sessao aberta */
    private function is_open(){
        return $this->open;
    }

	/* Verifica se exist a sessao */
    private function session_exist(){
        return $this->exist;
    }

	/* Inclui dados */
	public function set($key, $value){
		$this->open();
		$_SESSION[$key] = $value;
	}

	/* Recupera os dados */
	public function get($key, $false=false){
		if(!$this->key_exist($key))
			return $false;
		$this->open();
		$return = $_SESSION[$key];
		return $return;
    }
	
	/* Deleta os dados */
	public function del($key){
		if(!$this->key_exist($key))
			return;
		$this->open();
		unset($_SESSION[$key]);
	}
	
    /* Verifica se existe a variavel */
	public function key_exist($key){
		if(!$this->session_exist())
            return false;
        $this->open();
        return array_key_exists($key, $_SESSION);
    }

    /* Abre sessao */
    private function open(){
		if($this->is_open()) return;
		if(!session_start())
			echo 'error[\'open_session\']';

		if($this->name === null){
			$this->name = session_name();
			$this->params = session_get_cookie_params();
		}
		$this->open = true;
		$this->exist = true;
	}

	/* Salva sessao */
	private function save(){
		if(!$this->is_open())
			return;
		session_write_close();
		$this->open = false;
	}

	/* Limpa totalmente a sessao */
	public function clear(){
		if(!$this->session_exist())
			return;
		$this->open();
		session_unset();
		session_destroy();

        if(ini_get('sesion.use_cookies'))
            $this->clear_cookie();
		$this->open = false;
		$this->exist = false;
	}

	/* Limpa PHPSESSID do navegador */
    private function clear_cookie() {
		if(isset($_COOKIE[$this->name]))
			setcookie($this->name, '', time()-3600, '/');
		session_unset();
		session_destroy();
	}

}

/* Testando a classe FPHP_smart_session */

/*
public function set($key, $value)
public function get($key)
public function del($key)
public function key_exist($key)
public function clear()


$session = new FPHP_smart_session();

$session->clear();

$json = array('value' => $session->get('value'), 'value2' => $session->get('value2'), 'sessid' => session_id());
echo json_encode($json);
echo '<br>';

$session->set('value', 123);
$session->set('value2', 123);

$json = array('value' => $session->get('value'), 'value2' => $session->get('value2'), 'sessid' => session_id());
echo json_encode($json);
echo '<br>';

$session->del('value');

$json = array('value' => $session->get('value'), 'value2' => $session->get('value2'), 'sessid' => session_id());
echo json_encode($json);
echo '<br>';


//*/