<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cobrança</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>


    <?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    include "conexao.php";
    $conn = conectar();

    //Pega dados do formualrio
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    if (!empty($dados['pagar'])) {

        
        if (sizeof($dados) > 1) {
            foreach ($dados as $chave => $valor) {
                if ($chave != 'pagar') {
                    $pagamento = "UPDATE anuidade_associado set situacao_anuidade_associado=1 WHERE id_anuidade_associado=$chave";
                    $pagar = $conn->query($pagamento);
                }
            }
        }
        header('Location: '.$_SERVER['REQUEST_URI']);
    }

    $restoDias;

    $associado = "SELECT * FROM associado WHERE id_associado=" . $_GET['associado'] . ";";
    $procuraAssociado = $conn->query($associado);

    if ($procuraAssociado->num_rows > 0) {

        while ($row = $procuraAssociado->fetch_assoc()) {
            echo "<h1>" . $row['nome_associado'] . "</h1><section class='info-associado'>";
            echo "<p>" . $row['email_associado'] . "</p>";
            echo "<p>CPF: " . $row['cpf_associado'] . "</p>";
            echo "<p>Filiou-se em: " . (new DateTime($row['data_afiliacao_associado']))->format('d/m/Y') . "</p></section>";
        }
    }


    $associado = "SELECT * FROM anuidade_associado WHERE id_associado=" . $_GET['associado'] . ";";
    $procuraAssociado = $conn->query($associado);
    $valorTotal = 0;
    if ($procuraAssociado->num_rows > 0) {

        echo "<form action='' method='POST'><fieldset><legend>Anuidades</legend>";
        echo "<p class='anuidade'><strong>Situacao</strong><strong>Valor</strong><strong>Periodo</strong>";
        while ($row = $procuraAssociado->fetch_assoc()) {
            $data = new DateTime($row['ano_anuidade_associado']);
            $dat1 = new DateTime(date('Y-m-d'));
            $restoDias = $dat1->diff($data)->days;

            $tempo = ceil($restoDias / 365);
            
            echo "<p class='anuidade'>";
            echo $row['situacao_anuidade_associado'] == 0 ?  "<strong class='indica-devedor'><input type='checkbox' name='" . $row['id_anuidade_associado'] . "'/>Pagar</strong>" : "<strong>PAGO</strong>";
            
            $anuidades = "SELECT * FROM anuidade";
            $procuraAnuidade = $conn->query($anuidades);
            while ($row2 = $procuraAnuidade->fetch_assoc()) {
                if ($row2['ano_anuidade'] == $data->format('Y')) {
                    echo $row['situacao_anuidade_associado'] == 0 ? "<strong>R$" . $row2['valor_anuidade'] . "</strong>" : "<s>R$" . $row2['valor_anuidade'] . "</s>";
                   $valorTotal += $row['situacao_anuidade_associado'] == 0 ?  $row2['valor_anuidade'] : 0;
                }
            };
            echo $data->format('d-m-Y') . " / " . $data->modify('+ 366 days')->format('d-m-Y');
            echo "</p>";
        }
        echo "<span>A Pagar: </span><br><b>R$" . $valorTotal . "</b>";
        echo $valorTotal > 0 ? "<input type='submit' name='pagar' value='Pagar'></fieldset></form>" : "";
    }

    desconectar($conn);
    ?>

</body>

</html>