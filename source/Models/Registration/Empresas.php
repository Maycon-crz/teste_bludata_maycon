<?php
	require_once("../Lib/Conn.php");
	require_once("../Ferramentas.php");
	class CadastroDeEmpresas{
		public function __construct(){
			$con = Connection::getConn();
			$ferramentas = new Ferramentas;
			if(session_status() === PHP_SESSION_NONE){ session_start(); }		
			if(isset($_POST['NomeFantasia']) && $_SESSION['login'] == "sim"){
				$this->validacao($con, $ferramentas);
			}
		}
		private function validacao($con, $ferramentas){
			$dados = array();
			$dados['NomeFantasia'] 	= $_POST['NomeFantasia'] ?? "";
			$dados['Estado'] 		= $_POST['Estado'] ?? "";
			$dados['Cidade'] 		= $_POST['Cidade'] ?? "";
			$dados['CNPJ'] 			= $_POST['CNPJ'] ?? "";
			$dados['NomeFantasia'] 	= $ferramentas->filtrando($dados['NomeFantasia']);
			$dados['Estado'] 		= $ferramentas->filtrando($dados['Estado']);
			$dados['Cidade'] 		= $ferramentas->filtrando($dados['Cidade']);
			$dados['CNPJ'] 			= $ferramentas->filtrando($dados['CNPJ']);

			$msg = ($dados['NomeFantasia'] == "") ? "Informe o nome da Empresa!" : "";
			$msg = ($msg == "") ? ($dados['Estado'] == "Selecionar Estado") ? "Informe o Estado" : "": $msg;
			$msg = ($msg == "") ? ($dados['Cidade'] == "Selecionar Cidade") ? "Informe a Cidade" : "": $msg;
			$msg = ($msg == "") ? ($dados['CNPJ'] == "") ? "Informe o CNPJ" : "": $msg;
			$msg = ($msg == "") ? (strlen($dados['CNPJ']) != 18) ? "Informe o CNPJ Correto" : "OK": $msg;
			if($msg == "OK"){
				$this->cadastro($con, $dados);
			}else{
				echo json_encode($msg);
			}
		}
		private function cadastro($con, $dados){						
			date_default_timezone_set('America/Sao_Paulo');
			$data = date("Y-m-d H:i:s");
			$sql = "INSERT INTO empresas(nome, estado, cidade, cnpj, data) VALUES(:nome, :estado, :cidade, :cnpj, :data)";
			$sql = $con->prepare($sql);
			$sql->bindParam(":nome", $dados['NomeFantasia']);
			$sql->bindParam(":estado", $dados['Estado']);
			$sql->bindParam(":cidade", $dados['Cidade']);
			$sql->bindParam(":cnpj", $dados['CNPJ']);
			$sql->bindParam(":data", $data);
			if($sql->execute()){
				echo json_encode("Empresa cadastrada com sucesso!");
			}else{
				echo json_encode("Erro ao cadastrar Empresa!");
			}
		}		
	}
	$cadastroDeEmpresas = new CadastroDeEmpresas();
?>