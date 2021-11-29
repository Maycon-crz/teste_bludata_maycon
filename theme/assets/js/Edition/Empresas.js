class EditarDeletarEmpresa{
	constructor(){
		this.chamaEdicao(this);
		this.chamaExclusao(this);
	}
	chamaEdicao(objeto){
		$(".btEditarEmpresa").click(function(evento){			
			ferramentas("Aguarde", 1, 0);
			var id = $(this).val();
			var getUrl = window.location;
			var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];		
			var url = baseUrl+"/source/Models/Edition/Empresas.php";
			$.ajax({
				url: url,
				type: 'POST',
				data: $("#formEdicaoDeEmpresas"+id).serialize(),
				dataType: 'json',
				success: function(retorno){				
					ferramentas("Aguarde", 0, 0);
					alert(retorno);
				}
			});
		});
	}	
	chamaExclusao(objeto){
		$(".btExcluirEmpresa").click(function(evento){
			var idEmpresa = $(this).attr("id");
			var nomeEmpresa = $(this).val();
			objeto.excluir(objeto, idEmpresa, nomeEmpresa);
		});
	}
	excluir(objeto, idEmpresa, nomeEmpresa){
		ferramentas("Aguarde", 1, 0);
		var getUrl = window.location;
		var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];		
		var url = baseUrl+"/source/Models/Edition/Empresas.php";
		$.ajax({
			url: url,
			type: 'POST',
			data: {'excluir': idEmpresa, 'nomeEmpresa': nomeEmpresa},
			dataType: 'json',
			success: function(retorno){				
				ferramentas("Aguarde", 0, 0);					
				switch(retorno['msg']){
					case "Exluido com sucesso":
						alert(retorno['msg']);
						ferramentas("Recarregar", 0, 0);
					break;
					case "Fornecedores":		
						var result = confirm("Existe um total de "+retorno['Fornecedores'].length+" Fornecedor(es) relacionado(s) a empresa "+nomeEmpresa+" Nomes: ["+retorno['Fornecedores']+"]; Deseja realmente excluir essa empresa?");
			            if (result == true) {
			               objeto.excluir(objeto, idEmpresa, "Exclusao_Confirmada");
			            }
					break;
					default:
						alert(retorno['msg']);
					break;
				}
			}
		});
	}
}