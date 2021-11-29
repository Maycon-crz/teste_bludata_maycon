<?php 
    if (session_status() === PHP_SESSION_NONE) {
        session_start();    
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $title; ?></title>    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="<?= url("/theme/assets/css/styles.css"); ?>"/>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Bludata</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <?php if(isset($_SESSION['login'])){ ?>
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">                
                    <li class="nav-item m-3">
                        <a href="#"><button class="text-center btn btn-outline-success form-control btAbreListagemDeEmpresas">Listagem de Empresas |||</button></a>
                    </li>
                    <li class="nav-item m-3">
                        <a href="#"><button class="text-center btn btn-outline-success form-control btAbreListagemDeFornecedores">Listagem de Fornecedores |||</button></a>
                    </li>
                    <li class='nav-item text-center p-2'>
                        <a id='navOpcoesLogado' class='text-center btn btn-outline-success dropdown-toggle mt-2 form-control' role='button' data-bs-toggle='dropdown' aria-expanded='false'>Cadastros</a>
                        <ul class='dropdown-menu form-control text-center' aria-labelledby='navOpcoesLogado'>
                            <li class='dropdown-item border p-0 mt-2'>                
                                <a href="#LinhaCadastroDeEmpresas"><button class="form-control btn btn-outline-success btAbreCadastroDeEmpresas">Cadastro de Empresas |||</button></a>
                            </li>
                            <li class='dropdown-item border p-0 mt-2'>
                                <a href="#LinhaCadastroDeFornecedores"><button class="form-control btn btn-outline-success btAbreCadastroDeFornecedores">Cadastro de Fornecedores |||</button></a>
                            </li>                           
                        </ul>
                    </li>
                    <li class="nav-item m-3">
                      <button class="text-center btn btn-outline-danger form-control" id='btSair'>Sair</button>
                    </li>
                <?php }else{ ?>
                    <li class="nav-link m-3">
                         <a href='index.php?pagina=login&metodo=index' class='form-control text-center bg-light' data-bs-toggle='modal' data-bs-target='#Modal' id='btAbreLogin'>Login</a>
                    </li>
                <?php } ?>                                      
                </ul>
            </div>
        </div>
    </nav>

    <main class="container">
        <?= $v->section("content"); ?>
    </main>

    <div id="aguarde"></div>
        <!-- Modal -->
        <?php require_once(__DIR__."\modalLogin.php"); ?>
        <!-- -->        
        <script src="<?= url("/theme/assets/js/Ferramentas.js"); ?>"></script>
        <script src="<?= url("/theme/assets/js/Login.js"); ?>"></script>
        <!-- Plugin jquery.mask.min -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>
        <!-- Option 2: Separate Popper and Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

    <?= $v->section("js"); ?>

</body>
</html>