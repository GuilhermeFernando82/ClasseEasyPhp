<?php
class EasyPHP
{   
    public $host;
    public $db_name;
    public $username;
    public $password;
    public $conn;
    //função que cria uma conexão com a base dados
    public function DbConexao($host, $db_name, $username, $password)
	{
     
	    $this->conn = null;    
        try
		{
            $this->conn = new PDO("mysql:host=" . $host . ";dbname=" . $db_name, $username, $password);
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
                        echo 'Conectado';
        }
		catch(PDOException $exception)
		{
            echo "Connection error: " . $exception->getMessage();
        }
         
        return $this->conn;
    }
    //função para jogar comandos sql como INSERT, DELETE, SELECT E UPDATE 
    public function comandos_sql($comando){
        $sql = $this->conn;
        $a = $sql->query($comando);
        
        }
        //Autenticação de login e senha
        public function autentica_login($login, $senha, $campo_senha, $campo_nome, $table, $pagina){
            $sql = $this->conn; 
            $a = $sql->query("SELECT * FROM $table WHERE $campo_nome= '$login' and $campo_senha = '$senha'");
            if($a->rowCount() > 0){
                echo "<script>alert('Logado com Sucesso!');location.href='$pagina'</script>";
            }
            
        }
        //Verfica se existe um valor especifico no banco de dados
        public function Verificar1($valor, $nome, $table){
            $sql = $this->conn; 
            $a = $sql->query("SELECT * FROM $table WHERE $nome= '$valor'");
            if($a->rowCount() > 0){
                echo "<script>alert('Já existe no banco!')</script>";
            }
        }
        
        //Verifica se dois valores existem no banco de dados
        
        public function Verificar2($valor1, $valor2, $nome1, $nome2, $table){
            $sql = $this->conn; 
            $a = $sql->query("SELECT * FROM $table WHERE $nome1= '$valor1' and $nome2 = '$valor2'");
            if($a->rowCount() > 0){
                echo "<script>alert('Já existe no banco!')</script>";
            }
        }
        
        //Função que verifica se um campo é vazio
        
        public function vacuo_do_campo($valor){
            if(empty($valor)){
                return TRUE;
            };
        }
        //Função para validar CPF
        public function validarCPF($cpf = null){
         	// Verifica se um número foi informado
	if(empty($cpf)) {
		return false;
	}

	// Elimina possivel mascara
	$cpf = preg_replace("/[^0-9]/", "", $cpf);
	$cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);
	
	// Verifica se o numero de digitos informados é igual a 11 
	if (strlen($cpf) != 11) {
		return false;
	}
	// Verifica se nenhuma das sequências invalidas abaixo 
	// foi digitada. Caso afirmativo, retorna falso
	else if ($cpf == '00000000000' || 
		$cpf == '11111111111' || 
		$cpf == '22222222222' || 
		$cpf == '33333333333' || 
		$cpf == '44444444444' || 
		$cpf == '55555555555' || 
		$cpf == '66666666666' || 
		$cpf == '77777777777' || 
		$cpf == '88888888888' || 
		$cpf == '99999999999') {
		return false;
	 // Calcula os digitos verificadores para verificar se o
	 // CPF é válido
	 } else {   
		
		for ($t = 9; $t < 11; $t++) {
			
			for ($d = 0, $c = 0; $c < $t; $c++) {
				$d += $cpf{$c} * (($t + 1) - $c);
			}
			$d = ((10 * $d) % 11) % 10;
			if ($cpf{$c} != $d) {
				return false;
			}
		}

		return true;
	}
}
}

?>