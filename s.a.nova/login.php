<?php
$mensagem = "";
if (isset($_GET["erro"])) {
    $mensagem = "E-mail ou senha incorretos.";
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Login - VetKet</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body class="login-body">

    <div class="login-container">

        <h2>Login do VetKet</h2>
        <?php if ($mensagem != "") { ?>
            <div class="mensagem-login">
                <?php echo $mensagem; ?>
            </div>
        <?php } ?>

        <form method="POST" action="verificalogin.php">

            <label for="email">E-mail:</label>
            <input type="email"name="email"id="email"required placeholder="Digite seu e-mail">
            <label for="senha">Senha:</label>

            <input type="password"name="senha"id="senha" required placeholder="Digite sua senha">

            <button type="submit"> Entrar</button>

            <div class="conta">
                <span>Não tem conta?</span>
                <a href="cadastro.php">Cadastre-se </a>
            </div>
        </form>
    </div>
</body>

</html>
