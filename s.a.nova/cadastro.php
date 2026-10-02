<?php
$mensagem = "";

if (isset($_GET["sucesso"])) {
    $mensagem = "Cadastro realizado com sucesso!";
}

if (isset($_GET["erro"])) {
    $mensagem = "Este e-mail já está cadastrado.";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro - VetKet</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body class="login-body">
    <div class="login-container">
        <h2>Cadastro do responsável</h2>

        <?php if ($mensagem != "") { ?>
            <div class="mensagem-cadastro">
                <?php echo $mensagem; ?>
            </div>
        <?php } ?>

        <form method="POST" action="salvar-usuario.php">
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" required placeholder="Digite seu nome">

            <label for="email">E-mail:</label>
            <input type="email" name="email" id="email" required placeholder="Digite seu e-mail">

            <label for="senha">Senha:</label>
            <input type="password" name="senha" id="senha" required placeholder="Digite sua senha">

            <button type="submit">Cadastrar</button>

            <div class="conta">
                <span>Já possui uma conta?</span>
                <a href="login.php">Entrar</a>
            </div>
        </form>
    </div>
</body>
</html>