
    <h2>Situação Associados</h2>
    <input class="procura" type="text" placeholder="Procurar Associado" list="associados"><br>
    <section class="main">
        
        <?php
        include "conexao.php";
        $conn = conectar();
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        $associados = "SELECT * FROM associado";
        $procuraAssociados = $conn->query($associados);

        if ($procuraAssociados->num_rows > 0) {
            while ($row = $procuraAssociados->fetch_assoc()) {

                echo "<a href='checkout.php?associado=" . $row['id_associado'] . "' target='_blank'><b>" . $row['nome_associado'] . "</b>";
                echo "<p class='anuidade'>";

                $anuidadesPagas = "SELECT COUNT(*) AS totalPagas FROM anuidade_associado WHERE id_associado='" . $row['id_associado'] . "' AND situacao_anuidade_Associado=1";
                $verAnuidadesPagas = $conn->query($anuidadesPagas)->fetch_assoc()['totalPagas'];
                echo "<strong class='indica-pagador'>Pagas: " . $verAnuidadesPagas . "</strong>";

                $anuidades = "SELECT COUNT(*) AS total FROM anuidade_associado WHERE id_associado='" . $row['id_associado'] . "' AND situacao_anuidade_Associado=0";
                $verAnuidades = $conn->query($anuidades)->fetch_assoc()['total'];
                echo "<strong class='indica-devedor'>A Pagar: " . $verAnuidades . "</strong>";

                echo "</p> </a>";
            }
        }

        desconectar($conn);
        ?>
    </section>

    <script>
        const inputNomes = document.querySelector('input')
        const nomes = document.querySelectorAll('b')
        
        inputNomes.addEventListener('keydown', (f) => {
            console.log(f)
            nomes.forEach(e => {
                if (e.textContent.toLowerCase().includes(inputNomes.value.toLowerCase())) {
                    e.parentElement.style.display = 'block'
                    inputNomes.style.color = 'green'
                } else {
                    e.parentElement.style.display = 'none'
                    inputNomes.style.color = 'red'

                }
            })
        })
    </script>
