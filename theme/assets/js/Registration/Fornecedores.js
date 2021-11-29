class CadastroDeFornecedores{
	constructor(){
		this.cadastrar();		
		this.mascaraDeCNPJ();
		this.mascaraDeCPF();
		this.mascaraDeRG();
		this.mascaraDeTelefone();
		this.adicionarTelefone(this);		
		this.pessoaFisica();
		this.carregarEmpresasSelect(this);
		this.abrirCadastro();
	}
	cadastrar(){
		$("#FormCadastroDeFornecedores").on("submit", function(event){
			event.preventDefault();
			ferramentas("Aguarde", 1, 0);
			let dados = $(this).serialize();
			var getUrl = window.location;
			var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];		
			var url = baseUrl+"/source/Models/Registration/Fornecedores.php";
			$.ajax({
				url: url,
				type: 'POST',
				data: dados,
				dataType: 'json',
				success: function(retorno){
					ferramentas("Aguarde", 0, 0);
					if(retorno === "Fornecedor cadastrado com sucesso!"){
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
	mascaraDeCPF(){
		 $('.cpfMasck').mask('000.000.000-00', {reverse: true});
	}
	mascaraDeRG(){
		 $('.rgMasck').mask('99.999.999-9');
	}
	mascaraDeTelefone(){
		 $(".telefoneMask").mask("(00) 0000-00000");
	}
	adicionarTelefone(objeto){		
		let contador=1;
		let input = "";
		$("#btAdicionarTelefone").on("click", function(){			
			if(contador<5){
				$("#linhaDeTelefones").prepend("<input type='phone' name='telefone"+contador+"' class='form-control input-lg telefoneMask' placeholder='EX: (00) 0000-0000' />");
				objeto.mascaraDeTelefone();
				contador++;
			}else{
				alert("Este formulário de cadastro está Limitado a 5 telefones");
			}
		});
	}	
	pessoaFisica(){
		$("input[type=radio][name=tipo_documento]").on("change", function(){
			let documento = $(this).val();
			if(documento == "CPF"){				
				$("#linhaPessoaFisica").show();
				$("#linhaPessoaJuridica").hide();
			}else{
				$("#linhaPessoaJuridica").show();
				$("#linhaPessoaFisica").hide();
			}
		});
	}
	carregarUF(){
		$("#empresa").on("change", function(){
			let selecionando = $(this).val();
			let estadoDaEmpresa = $("#"+selecionando).val();			
			$("#linhaAuxiliares").html("");
			let valor = $("option:selected", this).text();
			if(estadoDaEmpresa != undefined){
				$("#linhaAuxiliares").html("<input type='hidden' value='"+valor+"' name='Empresa' /><input type='hidden' value='"+estadoDaEmpresa+"' name='UF' />");				
			}else{
				$("#linhaAuxiliares").html("<input type='hidden' value='' name='Empresa' /><input type='hidden' value='' name='UF' />");				
			}
		});
	}
	carregarEmpresasSelect(objeto){		
		$("#empresa").on("click", function(){				
			if($(this).val() == "Selecionar Empresa Cadastrada"){				
				ferramentas("Aguarde", 1, 0);
				var getUrl = window.location;
				var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];		
				var url = baseUrl+"/source/Models/Registration/Fornecedores.php";
				$.ajax({
					url: url,
					type: 'POST',
					data: {"selectEmpresas": "selectEmpresas"},
					dataType: 'JSON',
					success: function(retorno){
						ferramentas("Aguarde", 0, 0);
						let qtdEmpresas = retorno.length;
						let options="<option value='Selecionar Empresa Cadastrada'>Selecionar Empresa Cadastrada</option>";
						let UF = "";
						for(let i=0; i<qtdEmpresas;i++){
							options += "<option value='estadosSelect"+i+"'>"+retorno[i].nome+"</option>";
							UF += "<input type='hidden' id='estadosSelect"+i+"' value='"+retorno[i].UF+"' name='UFs' />";
						}						
						$("#empresa").html(options);
						$("#linhaEstado").html(UF);
						objeto.carregarUF();
					}
				});
			}			
		});		
	}
	abrirCadastro(){
		$(".btAbreCadastroDeFornecedores").on("click", function(event){				
			$("#LinhaCadastroDeFornecedores").toggle();			
		});	
	}
}
let cadastroDeFornecedores = new CadastroDeFornecedores();