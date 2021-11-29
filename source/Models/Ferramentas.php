<?php
	class Ferramentas{				
		public function verificaSeEmailExiste($con, $ferramentas, $email){	
			$sqlverificaEmail = "SELECT * FROM usuarios WHERE email=:email LIMIT 1";
			$verificaEmail = $con->prepare($sqlverificaEmail);
			$verificaEmail->bindParam(':email', $email);			
			if($verificaEmail->execute()){
				$result = $verificaEmail->fetchAll(PDO::FETCH_ASSOC);
				$retornado = array();
				$retornado["msg"] = "";
				foreach($result as $retorno){ 
					$retornado["email"] 	= $retorno["email"];
					$retornado["senha"] 	= $retorno["senha"];
					$retornado["nome"] 		= $retorno["nome"];
				}
				if($retornado["email"] == ""){ $retornado["msg"] = "Erro"; }
			}else{ $retornado["msg"] = "Erro"; }
			return $retornado;			
		}
		public function filtrando($dados){
			$dados = trim($dados);
			$dados = htmlspecialchars($dados);			
			$dados = addslashes($dados);
			return $dados;		
		}
	}

?>