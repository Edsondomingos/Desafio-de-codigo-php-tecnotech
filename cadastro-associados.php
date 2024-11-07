

    <?php
    include_once "index.php";

    date_default_timezone_set('America/Sao_Paulo');
    include "conexao.php";
    $conn = conectar();

    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    if (!empty($dados['nome']) && !empty($dados['email'])) {

        $procura_associado = "SELECT * FROM associado WHERE cpf_associado=" . $dados['cpf'];
        $result_cpf = $conn->query($procura_associado);

        if ($result_cpf->num_rows > 0) {
            echo "CPF CADASTRADO, UTILIZE OUTRO.";
        } else {

            $inserir_associado = "INSERT INTO associado (nome_associado, email_associado, cpf_associado, data_afiliacao_associado) 
            VALUES ('" . $dados['nome'] . "','" . $dados['email'] . "','" . $dados['cpf'] . "','" . $dados['data'] . "')";
            $result = $conn->query($inserir_associado);

            $pega_id = "SELECT id_associado FROM associado WHERE cpf_associado=" . $dados['cpf'];
            $result_id = $conn->query($pega_id)->fetch_assoc()['id_associado'];

            $data = new DateTime($dados['data']); // data associação
            $dataAtual = new DateTime(date('Y-m-d')); // data atual
            
            $restoDias = $dataAtual->diff($data)->days;
            $tempo = ceil($restoDias / 365); // Para ver quantas vezes vai iterar
            $tempo = $tempo < 1 ? 1 : ceil($restoDias / 365);
            for ($i = 0; $i < $tempo; $i++) {
                $inserir_associado = "INSERT INTO anuidade_associado (ano_anuidade_associado, situacao_anuidade_associado, id_associado) 
                VALUES ('" . $data->format('d-m-Y') . "','" . 0 . "','" . $result_id . "')";
                
                $result = $conn->query($inserir_associado);
                $data->modify('+ 366 days')->format('d-m-Y');
            }
            
        }
        header('Location: index.php?opcao=associado');
    }

    ?>


    <form action="" method="POST">
        <h1>Novo Associado</h1>

        <input type="text" placeholder="Procurar Associado" list="associados">
        <datalist id="associados">
            <?php
            $associados = "SELECT * FROM associado";
            $procuraAssociados = $conn->query($associados);
            if ($procuraAssociados->num_rows > 0) {
                while ($row = $procuraAssociados->fetch_assoc()) {
                    echo "<option value='" . $row['nome_associado'] . "'>";
                }
            }
            
            desconectar($conn);
            ?>
        </datalist>

        <fieldset>
            <legend>Cadastrar Associado</legend>
            <input type="text" name="nome" placeholder="Nome" required>
            <input type="email" name="email" placeholder="Email" required>
            <div>
                <input type="number" name="cpf" placeholder="CPF" required>
                <input type="date" name="data" max="<?php echo date('Y-m-d'); ?>" required title="Data de afiliação">
            </div>
            <input type="submit" name="cadastrar" value="Cadastrar Associado" />

        </fieldset>
    </form>
