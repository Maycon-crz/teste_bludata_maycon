class CadastroDeEmpresa{
	constructor(){
		this.abrirCadastro();
		this.cadastrar();
		this.mascaraDeCNPJ();		
	}
	abrirCadastro(){
		$(".btAbreCadastroDeEmpresas").on("click", function(event){			
			$("#LinhaCadastroDeEmpresas").toggle();			
		});	
	}
	cadastrar(){
		$("#FormCadastroDeEmpresas").on("submit", function(event){			
			event.preventDefault();
			ferramentas("Aguarde", 1, 0);
			let dados = $(this).serialize();			
			var getUrl = window.location;
			var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];		
			var url = baseUrl+"/source/Models/Registration/Empresas.php";
			$.ajax({
				url: url,
				type: 'post',
				data: dados,
				dataType: 'json',
				success: function(retorno){	
					ferramentas("Aguarde", 0, 0);
					if(retorno === "Empresa cadastrada com sucesso!"){
						alert(retorno);
						ferramentas("Recarregar", 0, 0);
					}else{ alert(retorno); }		
				}
			});
		});		
	}
	mascaraDeCNPJ(){
		$(".cnpjMasck").mask("99.999.999/9999-99");
	}
}
let cadastroDeEmpresa = new CadastroDeEmpresa();