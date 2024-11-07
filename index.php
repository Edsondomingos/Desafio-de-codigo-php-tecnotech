<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Devs do RN</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <a href="index.php">
        <h1>Devs do RN</h1>
    </a>

    <p class="anuidade">
        <a href="index.php?opcao=associado" rel="noopener noreferrer">Novo Associado</a>
        <a href="index.php?opcao=anuidade" rel="noopener noreferrer">Cadastrar Nova Anuidade</a>
        <a href="index.php?opcao=situacao" rel="noopener noreferrer">Situação Associados</a>
    </p>

    <?php
    if (isset($_GET['opcao'])) {
        if ($_GET['opcao'] == 'associado') {
            include_once "cadastro-associados.php";
        } else if ($_GET['opcao'] == 'anuidade') {
            include_once "cadastro-anuidade.php";
        } else if ($_GET['opcao'] == 'situacao') {
            include_once "situacao-associados.php";
        }
    }
    ?>

    <footer>
        <a href="https://linkedin.com/in/edson-domingos">Desenvolvido por &copy;Edson Domingos</a>
    </footer>



</body>

</html>