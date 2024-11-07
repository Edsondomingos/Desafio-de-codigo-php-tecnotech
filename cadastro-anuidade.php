
<?php

include "conexao.php";
$conn = conectar();

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

if (!empty($dados['cadastrar'])) {
    if ($conn->query("SELECT * FROM anuidade WHERE ano_anuidade =" . $dados['ano'])->num_rows > 0) {
        $atualiza_associado = $conn->query("UPDATE anuidade SET valor_anuidade=" . $dados['valor'] . " WHERE ano_anuidade= " . $dados['ano']);
    } else {
        $inserir_associado = "INSERT INTO anuidade (ano_anuidade, valor_anuidade) 
            VALUES ('" . $dados['ano'] . "','" . $dados['valor'] . "')";

        $result = $conn->query($inserir_associado);
    }

    header('Location: index.php?opcao=anuidade');
}

?>

<form action="" method="POST">
    <h1>Cadastro Anuidade</h1>
    <select name="id_anuidade">
        <?php
        $anuidades = "SELECT * FROM anuidade ORDER BY ano_anuidade";
        $procuraAnuidades = $conn->query($anuidades);
        if ($procuraAnuidades->num_rows > 0) {
            while ($row = $procuraAnuidades->fetch_assoc()) {
                echo "<option value='" . $row['id_anuidade'] . "'>Ano: " . $row['ano_anuidade'] . " / valor: R$" . $row['valor_anuidade'] . "</option>";
                echo $row['valor_anuidade'];
            }
        }
        desconectar($conn);
        ?>
    </select>
    <fieldset>
        <legend>Anuidade</legend>
        <div>
            <input type="number" name="ano" pattern="\d+" minlength="4" maxlength="4" placeholder="Ano anuidade - ex: 2022" required>
            <input type="number" name="valor" pattern="\d+" placeholder="Valor" required>
        </div>
        <input type="submit" name="cadastrar" value="Cadastrar Associado" />
    </fieldset>
</form>
