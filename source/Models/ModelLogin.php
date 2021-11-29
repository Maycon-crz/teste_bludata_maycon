<?php
	require_once("Lib/Conn.php");
	require_once("Ferramentas.php");
	if(session_status() === PHP_SESSION_NONE){
		session_start();
	}
	class Login{
		public function __construct(){
			$con = Connection::getConn();
			$ferramentas  	= new Ferramentas;	
			if(isset($_POST['emaiLogin'])){
				$this->validalogin($con, $ferramentas, $_POST['emaiLogin'], $_POST['senhaLogin']);				
			}
			if(isset($_POST['sair'])){								
				$this->saindo();				
			}				
		}		
		public function validalogin($con, $ferramentas, $emaiLogin, $senhaLogin){
			$emaiLogin = $ferramentas->filtrando($emaiLogin);
			if(isset($emaiLogin) AND !empty($emaiLogin)){
				$emaiLogin = filter_var($emaiLogin, FILTER_SANITIZE_EMAIL);
				if(filter_var($emaiLogin, FILTER_VALIDATE_EMAIL)){
					if(isset($senhaLogin) AND !empty($senhaLogin)){
						$contasenha = strlen($senhaLogin);
						if($contasenha >=8){
							$retornoEmail = $ferramentas->verificaSeEmailExiste($con, $ferramentas, $emaiLogin);
							if($retornoEmail['msg'] != "Erro"){
								$this->logando($con, $retornoEmail['email'], $retornoEmail['nome'], $retornoEmail['senha'], $senhaLogin);
							}else{ echo json_encode("Este E-mail Não está cadastrado"); }
						}else{ echo json_encode("Senha inválida!"); }
					}else{ echo json_encode("Você Precisa informar sua senha!"); }
				}else{ echo json_encode("Você Precisa informar um E-mail válido!"); }
			}else{ echo json_encode("Você Precisa informar seu E-mail!"); }
		}
		public function logando($con, $emailDB, $nomeDB, $senhaDB, $senhaDigitada){
			if(password_verify($senhaDigitada, $senhaDB)){	
				$_SESSION['login']	= "sim";
				$_SESSION['email'] 	= $emailDB;
				$_SESSION['nome'] 	= $nomeDB;
				echo json_encode("Senha certa pronto para logar!");
			}else{ echo json_encode("Senha Incorreta!"); }
		}
		private function saindo(){			
			session_unset();
			session_destroy();
			echo json_encode("saiu");
		}
	}
	$login = new Login();
?>