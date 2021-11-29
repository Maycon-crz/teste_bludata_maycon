<section class="row ocultar" id="LinhaCadastroDeEmpresas">
	<div class="col-12 text-center">
		<button type="button" class="form-control btn btn-outline-danger btAbreCadastroDeEmpresas">X Fechar</button>
		<form class="form-control border" id="FormCadastroDeEmpresas">
			<h1 class="text-secondary">Cadastro de Empresa</h1>
			<label for="nomeFantasia" class="form-control mt-3">Nome Fantasia:</label>				
			<input type="text" name="NomeFantasia" id="nomeFantasia" placeholder="Digite o nome fantasia:" class="form-control">
			<select class="form-select mt-3 Estado" name="Estado" id="">
				<option>Selecionar Estado</option>
			</select>
			<select class="form-select mt-3 Cidade" name="Cidade" id="" >
				<option>Selecionar Cidade</option>
			</select>
			<label for="cnpj" class="form-control mt-3">CNPJ:</label>
			<input name="CNPJ" id="cnpj" class="form-control rounded-form cnpjMasck" type="text" placeholder="Insira o CNPJ" maxlength="18"/>
			<button type="submit" class="form-control btn-lg btn-outline-success mt-5">Cadastrar</button>
		</form>
	</div>
</section>