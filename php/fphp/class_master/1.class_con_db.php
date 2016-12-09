<?php

/*--- Classe responsavel por executar o bind_param ---*/
class MYSQLI_bind_param{ 
	private $values = array(), $types = '';
	
	public function add($type, &$value){
		$this->values[] = &$value;
		$this->types .= $type;
	}
	public function get(){
		return array_merge(array($this->types), $this->values);
	}
}
/*-------->->->->->->------ metadata*/

/*--- Classe responsável por Instruções Sql ---*/
class MYSQLI_instruction{
/*--- Váriaveis de escopo ---*/
	protected $stmt, $mysqli, $resp;
	protected $aff_rows, $error, $error_num, $last_id;
	
	private static $con;
	private $con_exist = false;
	
	/* Instantica uma classe global */
	public static function con(){
		if(self::$con == null){
			self::$con = new self();
		}
		return self::$con;
	}
	
	/* Construtor */
	public function __construct(){
		$this->con_exist = false;
	}
	
	/*--- Função responsável pela conexao com o banco de dados ---*/
	public function con_mysqli(){
		if($this->con_exist) return true;
		$this->con_exist = true;
		
		$host_sql = def_host_sql;
		$user_sql = def_user_sql;
		$pass_sql = def_pass_sql;
		$bd_sql =   def_db_sql;
		$this->mysqli = new mysqli($host_sql, $user_sql, $pass_sql, $bd_sql);
		
		if($this->mysqli->connect_errno || !$this->mysqli->set_charset("utf8")){
			$this->error = "Error MySQL: ".$mysqli->error; return false;
		}
		return true;
	}
	/*--- Função responsável por encerrar a conexão ---*/
	public function end_con_sql(){
		$this->mysqli->close();
		$this->con_exist = false;
	}
	/*--- Função responsável por selecionar campos no banco de dados ---*/
	public function select_mysqli($query,$types='',$params=[]){
		$cont = count($params);
		$this->resp = array();
		
		if($cont > 0){
			$this->stmt = $this->mysqli->prepare($query);
			$bind_param = new MYSQLI_bind_param();
			for($i=0; $i<count($params); $i++){
				$bind_param->add($types[$i], $params[$i]);
			}
            $return = call_user_func_array(array($this->stmt,'bind_param'),$bind_param->get());
			$this->stmt->execute();
			$meta = $this->stmt->result_metadata();
			while($field = $meta->fetch_field()){
				$var = $field->name;
				$$var = null;
				$parameters[$field->name] = &$$var;
			}
			call_user_func_array(array($this->stmt, 'bind_result'), $parameters);
			while($this->stmt->fetch()){
				$data_par = array();
				foreach($parameters as $k1 => $v1) $data_par[$k1] = $v1;
				array_push($this->resp, $data_par);
			}
			$this->stmt->close();
		}
		else{
			$execute = $this->mysqli->query($query);
			while($row = mysqli_fetch_array($execute, MYSQLI_ASSOC)){
				array_push($this->resp, $row);
			}
		}
		
		if(!$this->resp) return false;
		else return $this->resp;
	}
	
	/*--- Função para inserir, deletar e atualizar no banco de dados ---*/
	public function generic_sql_mysqli($query,$types='',$params=[]){
		$cont = count($params);
		$this->resp = false;
		if($cont > 0){
			$this->stmt = $this->mysqli->prepare($query);
			$bind_param = new MYSQLI_bind_param(); 
			for($i=0; $i<count($params); $i++){
				$bind_param->add($types[$i], $params[$i]);
			}
            $return = call_user_func_array(array($this->stmt,'bind_param'),$bind_param->get());
			$this->resp = $this->stmt->execute();
			$this->aff_rows = $this->stmt->affected_rows;
			$type = $this->get_type_query($query);
			if(!$this->resp){
				$this->error = "Error Query MySQL: (".$this->stmt->errno.") ".$this->stmt->error;
				$error_num = $this->stmt->errno;
				$this->last_id = -1;
			}
			else $this->last_id = $this->stmt->insert_id;
		}
		else{
			$this->resp = $this->mysqli->query($query);
			$this->aff_rows = $this->mysqli->affected_rows;
			$type = $this->get_type_query($query);
			if(!$this->resp){
				$this->error = "Error Query MySQL: (".$this->mysqli->errno.") ".$this->mysqli->error;
				$error_num = $this->mysqli->errno;
				$this->last_id = -1;
			}
			else $this->last_id = $this->mysqli->insert_id;
		}
		
		return $this->resp;
	}

	public function affected_rows(){
		return $this->aff_rows;
	}
	
	public function last_error(){
		return $this->error;
	}
	
	public function errono(){
		return $this->error_num;
	}
	
	public function last_id_insert(){
		return $this->last_id;
	}
	
	private function get_type_query($str){
		/* Limpa a query */
		$remove_s = preg_split('/[\s]*/', $str, 2);
		$str = substr($remove_s[1], 0, 6);
		$str = strtoupper($str);
		/* Verifica seu tipo */
		$pattern = array('/SELECT/', '/INSERT/', '/DELETE/', '/UPDATE/');
		foreach($pattern as $k1 => $v1){
			if(preg_match($v1, $str)) return array('type'=>$str, 'i'=>$k1);
		}
		return false;
	}
}
?>