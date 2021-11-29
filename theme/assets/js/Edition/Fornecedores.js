class EditarDeletarFornecedores{
	constructor(){
		this.chamaEdicao(this);
		this.chamaExclusao(this);
	}
	chamaEdicao(objeto){
		$(".btEditarFornecedor").click(function(evento){
			ferramentas("Aguarde", 1, 0);
			var id = $(this).val();
			var getUrl = window.location;
			var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];		
			var url = baseUrl+"/source/Models/Edition/Fornecedores.php";
			$.ajax({
				url: url,
				type: 'POST',
				data: $("#formEdicaoDeFornecedores"+id).serialize(),
				dataType: 'json',
				success: function(retorno){				
					ferramentas("Aguarde", 0, 0);
					alert(retorno);
				}
			});
		});
	}
	chamaExclusao(objeto){
		$(".btExcluirFornecedor").click(function(evento){
			ferramentas("Aguarde", 1, 0);
			var idFornecedor = $(this).val();						
			var getUrl = window.location;
			var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];		
			var url = baseUrl+"/source/Models/Edition/Fornecedores.php";
			$.ajax({
				url: url,
				type: 'POST',
				data: {'excluir': idFornecedor},
				dataType: 'json',
				success: function(retorno){				
					ferramentas("Aguarde", 0, 0);
					alert(retorno);
					if(retorno == "Exluido com sucesso"){
						ferramentas("Recarregar", 0, 0);
					}
				}
			});
		});
	}
}