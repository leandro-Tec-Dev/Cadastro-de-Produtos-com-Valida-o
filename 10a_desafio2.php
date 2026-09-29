```php
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Produtos</title>
</head>
<body>

    <form method="post" action="">
        <label for="nome">Nome do Produto:</label>
        <input type="text" name="nome" required><br><br>

        <label for="preco">Preço:</label>
        <input type="number" name="preco" step="0.01" required><br><br>

        <button type="submit">Cadastrar</button>
    </form>

    <?php

    // Verifica se o formulário foi enviado
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // Recebe os valores enviados pelo formulário
        $nome = $_POST['nome'];
        $preco = $_POST['preco'];

        // Verifica se o nome não está vazio
        if (empty(trim($nome))) {
            echo "<p id='msg' style='color: red;'>Erro: O nome do produto não pode estar vazio.</p>";
        }

        // Verifica se o preço é um número maior que zero
        elseif (!is_numeric($preco) || $preco <= 0) {
            echo "<p id='msg' style='color: red;'>Erro: O preço deve ser um número positivo.</p>";
        }

        else {

            // Conecta ao banco de dados
            $servername = "localhost";
            $username = "root";
            $password = "Senai@118";
            $dbname = "exercicio";

            $conn = new mysqli($servername, $username, $password, $dbname);

            // Verifica a conexão
            if ($conn->connect_error) {
                die("Falha na conexão: " . $conn->connect_error);
            }

            // Cria a tabela produtos caso ela ainda não exista
            $sqlTabela = "CREATE TABLE IF NOT EXISTS produtos (
                id INT AUTO_INCREMENT PRIMARY KEY,
                nome VARCHAR(255) NOT NULL,
                preco DECIMAL(10,2) NOT NULL
            )";

            $conn->query($sqlTabela);

            // Insere o produto no banco de dados
            $sql = "INSERT INTO produtos (nome, preco)
                    VALUES ('$nome', '$preco')";

            if ($conn->query($sql) === TRUE) {
                echo "<p id='msg' style='color: Darkgreen;'>Produto cadastrado com sucesso!</p>";
            } else {
                echo "<p id='msg' style='color: red;'>Erro ao cadastrar o produto.</p>";
            }

            // Fecha a conexão
            $conn->close();
        }

        // Oculta a mensagem após 5 segundos
        echo "
        <script>
            setTimeout(function() {
                document.getElementById('msg').style.display = 'none';
            }, 5000);
        </script>
        ";
    }

    ?>

</body>
</html>
```
