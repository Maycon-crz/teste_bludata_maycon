<?php $v->layout("_theme", ["title" => "painel"]); ?>

	<?php require_once(__DIR__."/cadastroEmpresas.php"); ?>
	<?php require_once(__DIR__."/cadastroFornecedores.php"); ?>
	<div class="row border ocultar" id="LinhaListagemEmpresas">
		<div class="col-12 text-center">
			<button type="button" class="form-control btn btn-outline-danger btAbreListagemDeEmpresas">X Fechar</button>
			<h2 class="text-secondary">Linha Listagem Empresas</h2>
			<form id="buscadorEmpresas">
				<input type="text" id="chaveEmpresa" class="border border-success rounded p-1">		
				<button type="submit" class="btn btn-outline-success">Buscar</button>
			</form>
		</div>
		<div id="carregarEmpresas"></div>
	</div>
	<div class="row border ocultar" id="LinhaListagemFornecedores">
		<div class="col-12 text-center">
			<button type="button" class="form-control btn btn-outline-danger btAbreListagemDeFornecedores">X Fechar</button>
			<h2 class="text-secondary">Linha Listagem Fornecedores</h2>
			<form id="buscadorFornecedores">
				<input type="text" id="ChaveFornecedor" class="form-control border border-success rounded p-1">
				<label >Tipo de Busca:</label>
				<input type="radio" id="buscaPeloNome" name="tipoDeBuscaFornecedor" value="Nome" class="border border-success rounded p-1">
				<label for="buscaPeloNome">Nome</label>
				<input type="radio" id="buscaPeloDocumento" name="tipoDeBuscaFornecedor" value="Documento" class="border border-success rounded p-1">
				<label for="buscaPeloDocumento">CPF/CNPJ</label>
				<input type="radio" id="buscaPelaData" name="tipoDeBuscaFornecedor" value="Data" class="border border-success rounded p-1">
				<label for="buscaPelaData">Data</label>
				<div class="ocultar" id="divBuscaPorData">
					<input type="date" id="inputDataCadastroFornecedor" name="inputDataCadastroFornecedor" class="form-control border border-success rounded p-1 my-3">
				</div>				
				<button type="submit" class="form-control btn btn-lg btn-outline-success my-3">Buscar</button>
			</form>
		</div>
		<div id="carregarFornecedores"></div>
	</div>
	<div class="row border my-5">
		<div class="col-12 py-5">
			<h1 class="text-center text-secondary">Painel de Controle</h1>		
		</div>
	</div>

<?php $v->start("js"); ?>
	<script src="<?= url("/theme/assets/js/Edition/Empresas.js"); ?>"></script>
	<script src="<?= url("/theme/assets/js/Edition/Fornecedores.js"); ?>"></script>
	<script src="<?= url("/theme/assets/js/Listing/Empresas.js"); ?>"></script>	
	<script src="<?= url("/theme/assets/js/Listing/Fornecedores.js"); ?>"></script>
	<script src="<?= url("/theme/assets/js/Registration/SelecaoAutomaticaEstadosCidades.js"); ?>"></script>
	<script src="<?= url("/theme/assets/js/Registration/Empresas.js"); ?>"></script>
	<script src="<?= url("/theme/assets/js/Registration/Fornecedores.js"); ?>"></script>
<?php $v->end(); ?>