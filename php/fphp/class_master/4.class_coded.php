<?php

/* 
 * Classe de codificação de valores int
 * Responsavel por codificar|decodificar valores
 */

class FPHP_coded{
	/* Variaveis master */
	private static $map_cod = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	
	/* Retorna o código para crypt/decrypt */
	private function mp_cod() {
        return self::$map_cod;
    }
	
	/* int to code */
	public function intcod($dec, $padding){
		$str = '';
		$map = $this->mp_cod();
		$size_m = strlen($map);
	
		if($dec == 0) return '0';
		while($dec != 0){
			//echo '$dec:'.$dec.' --- ';
			$i = bcmod($dec, $size_m);
			$dec = (int)($dec/$size_m);
			$str = $map[$i].$str;
			
			//echo '$i:'.$i.' $str:'.$str.' $dec:'.$dec.'<br/>';
		}
		return str_pad($str, $padding, $map[0], STR_PAD_LEFT);
	}
	
	/* code to int */
	public function codint($cod){
		$val = 0;
		$map = $this->mp_cod();
		$size_m = strlen($map);
		$size_c = strlen($cod);
	
		while($size_c != 0){
			for($i=0; $i<$size_m; $i++)
				if($cod[0] == $map[$i]){$key = $i; break;}
			$val = $val + (pow($size_m, $size_c-1) * $key);
			
			$cod = substr($cod, 1);
			$size_c--;
		}
		return $val;
	}
	
}; /* /fim - classe*/

?>