<section class="row ocultar" id="LinhaCadastroDeFornecedores">
	<div class="col-12 text-center">
		<button type="button" class="form-control btn btn-outline-danger btAbreCadastroDeFornecedores">X Fechar</button>
		<form class="form-control border" id="FormCadastroDeFornecedores">
			<h1 class="text-secondary">Cadastro de Fornecedor</h1>
			<select class="form-select" name="" id="empresa">
				<option value="Selecionar Empresa Cadastrada">Selecionar Empresa Cadastrada</option>
			</select>
			<div id='linhaAuxiliares'><input type='hidden' value='' name='Empresa' /><input type='hidden' value='' name='UF' /></div>
			<div id='linhaEstado'></div>
			<input type="text" name="nomeFornecedor" class="form-control mt-3" placeholder="Nome do Fornecedor" />				
			<div class="border mt-3">
				<label for="cpf_fornecedor">CPF</label>
				<input type="radio" name="tipo_documento" id="cpf_fornecedor" value="CPF" />
				<label for="cnpj_fornecedor">CNPJ</label>
				<input type="radio" name="tipo_documento" id="cnpj_fornecedor" value="CNPJ" />
			</div>
			<div class="border mt-3 ocultar" id="linhaPessoaFisica">
				<label for="documento_cpf">CPF</label>
				<input type="text" name="documento_cpf" id="documento_cpf" placeholder="Digite o CPF" class="form-control input-lg cpfMasck">
				<label for="rg">RG</label>
				<input type="text" name="rg" id="rg" placeholder="Digite o RG" class="form-control input-lg rgMasck">
				<label for="data_nascimento">Data de Nascimento</label>
				<input type="date" name="data_nascimento" id="data_nascimento" placeholder="Digite a Data de Nascimento" class="form-control input-lg">
			</div>
			<div class="border mt-3 ocultar" id="linhaPessoaJuridica">
				<label for="documento_cnpj">CNPJ</label>
				<input type="text" name="documento_cnpj" id="documento_cnpj" placeholder="Digite o CNPJ" class="form-control input-lg cnpjMasck">
			</div>
			<div class="border mt-3 p-3">
				<label for="telefone" class="form-control">Telefone</label>
				<input type="text" name="telefone0" id="telefone" class="form-control input-lg telefoneMask" placeholder="EX: (00) 0000-0000">
				<div id="linhaMaisTelefonesFornecedor"></div>
				<button type="button" id="btAdicionarTelefone" class="form-control btn btn-warning">Add Fone +</button>
			</div>
			<div class="border mt-3 p-3" id="linhaDeTelefones"></div>
			<button type="submit" class="form-control btn-lg btn-outline-success mt-5">Cadastrar</button>				
		</form>
	</div>
</section>