<?php
	require_once("../Lib/Conn.php");
	require_once("../Ferramentas.php");
	class EdicaoDeEmpresas{	
		public function __construct(){
			$con = Connection::getConn();
			$ferramentas = new Ferramentas;
			if(session_status() === PHP_SESSION_NONE){ session_start(); }
			if($_SESSION['login'] == "sim"){
				if(isset($_POST['NomeFantasia'])){				
					$this->validacao($con, $ferramentas);
				}
				if(isset($_POST['excluir'])){				
					$this->excluir($con, $ferramentas);				
				}
			}
		}
		private function validacao($con, $ferramentas){
			$dados = array();
			$dados['NomeFantasia'] 	= $_POST['NomeFantasia'] ?? "";
			$dados['Estado'] 		= $_POST['Estado'] ?? "";
			$dados['Cidade'] 		= $_POST['Cidade'] ?? "";
			$dados['CNPJ'] 			= $_POST['CNPJ'] ?? "";
			$dados['id'] 			= $_POST['id'] ?? "";
			$dados['NomeFantasia'] 	= $ferramentas->filtrando($dados['NomeFantasia']);
			$dados['Estado'] 		= $ferramentas->filtrando($dados['Estado']);
			$dados['Cidade'] 		= $ferramentas->filtrando($dados['Cidade']);
			$dados['CNPJ'] 			= $ferramentas->filtrando($dados['CNPJ']);
			$dados['id'] 			= $ferramentas->filtrando($dados['id']);

			$msg = ($dados['NomeFantasia'] == "") ? "Informe o nome da Empresa!" : "";
			$msg = ($msg == "") ? ($dados['Estado'] == "Selecionar Estado") ? "Informe o Estado" : "": $msg;
			$msg = ($msg == "") ? ($dados['Cidade'] == "Selecionar Cidade") ? "Informe a Cidade" : "": $msg;
			$msg = ($msg == "") ? ($dados['CNPJ'] == "") ? "Informe o CNPJ" : "": $msg;
			$msg = ($msg == "") ? (strlen($dados['CNPJ']) != 18) ? "Informe o CNPJ Correto" : "OK": $msg;
			if($msg == "OK"){
				$this->atualizar($con, $dados);				
			}else{
				echo json_encode($msg);
			}
		}
		private function atualizar($con, $dados){
			$sql = "UPDATE empresas SET nome=:nome, estado=:estado, cidade=:cidade, cnpj=:cnpj WHERE id=:id";
			$sql = $con->prepare($sql);
			$sql->bindParam(":nome", $dados['NomeFantasia']);
			$sql->bindParam(":estado", $dados['Estado']);
			$sql->bindParam(":cidade", $dados['Cidade']);
			$sql->bindParam(":cnpj", $dados['CNPJ']);
			$sql->bindParam(":id", $dados['id']);
			if($sql->execute()){
				echo json_encode("Dados editados com sucesso");
			}else{ echo json_encode("Erro ao edita"); }
		}		
		private function excluir($con, $ferramentas){			
			$id = $_POST['excluir'] ?? "";
			$nomeEmpresa = $_POST['nomeEmpresa'] ?? "";
			$id = $ferramentas->filtrando($id);
			$nomeEmpresa = $ferramentas->filtrando($nomeEmpresa);
			if($nomeEmpresa != "Exclusao_Confirmada"){				
				$fornecedores = $this->verificaFornecedores($con, $nomeEmpresa);
			}else{
				$fornecedores = "no";
			}
			
			$retorno = array();
			if($fornecedores == "no"){
				$sql = "DELETE FROM empresas WHERE id=:id";
				$sql = $con->prepare($sql);			
				$sql->bindParam(":id", $id);
				if($sql->execute()){
					$retorno["msg"] = "Exluido com sucesso";
				}else{ $retorno["msg"] = "Erro ao Exluir"; }
			}else{
				$retorno["msg"] = "Fornecedores";
				$retorno["Fornecedores"] = $fornecedores;
			}
			echo json_encode($retorno);
		}
		private function verificaFornecedores($con, $nomeEmpresa){				
			$sql = "SELECT * FROM fornecedores WHERE empresa LIKE :empresa";
			$sql = $con->prepare($sql);
			$nomeEmpresa = "%".$nomeEmpresa."%";
			$sql->bindParam(':empresa', $nomeEmpresa);
			if($sql->execute()){
				$result = $sql->fetchAll(PDO::FETCH_ASSOC);
				$fornecedores = array();
				$contador=0;				
				foreach($result as $retorno){
					$fornecedores[$contador] = $retorno["nome"];
					$contador++;
				}
				if($fornecedores == ""){
					return "no";
				}else{
					return $fornecedores;
				}				
			}else{
				echo json_encode("Erro");
			}			
		}
	}
	$edicaoDeEmpresas = new EdicaoDeEmpresas();
?>
