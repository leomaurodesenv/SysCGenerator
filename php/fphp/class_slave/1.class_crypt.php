<?php

class CRYPT_instruction extends FPHP_master{
	
	/* Variaveis da criptografia */
	private $key_prefix = 'FormsPHP_';
	/* http://php.net/manual/pt_BR/mcrypt.ciphers.php */
	/* http://docstore.mik.ua/orelly/webprog/pcook/ch14_08.htm */
	/* Corrigir pkcs7: http://collaboradev.com/2009/08/21/encryption-and-decryption-between-net-and-php/ */
	
	/* Construtor */
	public function __construct($set_key_prefix = 'FormsPHP_'){
		$this->key_prefix = $set_key_prefix;
	}
	
	/* Função para criptografa a string */
	public function encrypt($string, $code=0){
		$td = mcrypt_module_open('tripledes', '', 'ecb', '');
		
		$block_size = mcrypt_get_block_size('tripledes', 'ecb');
		
		$iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), 2);
		$key = $this->generate_key($code, mcrypt_enc_get_key_size($td));
		mcrypt_generic_init($td, $key, $iv);
		
		/* Incluindo o padding block */
		$value_length = strlen($string);
		$padding = $block_size - ($value_length % $block_size);
		$string .= str_repeat(chr($padding), $padding); 
		
		/* Encrypt a $string */
		$crypt = mcrypt_generic($td, $string);
		
		mcrypt_generic_deinit($td);
		mcrypt_module_close($td);

		/* Retorna base64url */
		return $this->base64url_encode($crypt);
	}

	/* Função para criptografa a string */
	public function decrypt($crypt, $code=0){
		$td = mcrypt_module_open('tripledes', '', 'ecb', '');
		
		$block_size = mcrypt_get_block_size('tripledes', 'ecb');
		
		$iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), 2);
		$key = $this->generate_key($code, mcrypt_enc_get_key_size($td));
		mcrypt_generic_init($td, $key, $iv);
		
		/* Descriptografando o base64url */
		$decrypt = mdecrypt_generic($td, $this->base64url_decode($crypt));
		
		/* Removendo o padding block pkcs7 */
		$packing = ord($decrypt[strlen($decrypt) - 1]);
		if($packing && $packing < $block_size){
			for($P = strlen($decrypt) - 1; $P >= strlen($decrypt) - $packing; $P--){
				if(ord($decrypt{$P}) != $packing) $packing = 0;
			}
		}
		$decrypt = substr($decrypt, 0, strlen($decrypt) - $packing); 
		
		mcrypt_generic_deinit($td);
		mcrypt_module_close($td);
		
		return $decrypt;
	}
	
	/* Gerador do salt unidirecional */
	private function generate_key($code){
		/* print_r(hash_algos()); */
		$key = md5($this->key_prefix.$code);
		$key = substr($key, 0, 24);
		return $key;
	}
	
	/* Funcao para checar a string decodificada */
	/* Utilizasse o encrypt para check pois alguns scripts retorna 'lixo' (pkcs7) na string decrypt */
	public function check($string, $code, $hash){
		return ($this->encrypt($string, $code) === $hash);
    }
	
	/* Converte para base64url (pode ser interpretada pela url) e limpa os iguais(=) */
	/* base64: [A-Za-z0-9+/] */
	/* base64url: [A-Za-z0-9-_] */
	private function base64url_encode($string){ 
		$trans = array('+'=>'-', '/'=>'_');
		$return = rtrim(strtr(base64_encode($string), $trans), '=');
		return $return;
	}

	/* Decodifica a base64url para o texto original */
	/* = e um filtro para os ultimos bytes, possui o tamanho ate 3 */
	private function base64url_decode($string){ 
		$trans = array('-'=>'+', '_'=>'/');
		$return = base64_decode(str_pad(strtr($string, $trans), strlen($string)%4, '=', 1)); 
		return $return;
	}

}
/*$this->data_search = json_decode(rtrim($decp, "\0"), true);*/
/*$this->data_search = json_decode(preg_replace( "/\p{Cc}*$/u", "", $decp), true);*/
/* \p{Cc} or \p{Control}: an ASCII 0x00–0x1F or Latin-1 0x80–0x9F control character. */


/* Testando a classe CRYPT_instruction() */
/*
$password = '[{"field":"p.desc_processo","operator":"LIKE","value":"12"}]';

for($i=0; $i<1; $i++){
$crypt = new CRYPT_instruction('search');
$code = 'exemplos_'.$i;
$hash = $crypt->encrypt($password, $code);
var_dump("<br>i:",$i,"<br>pass:",$password,'<br>code:',$code,'<br>hash64:',$hash,'<br>hash:',base64_decode($hash));

$decp = $crypt->decrypt($hash, $code);
var_dump('<br>decrypt:',$decp,'<br>check:', $crypt->check($password, $code, $hash),'<br><br>');
}

//*/

?>