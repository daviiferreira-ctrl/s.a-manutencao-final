<?php
require "conexao.php";

$nome = $_POST["nome"];
$email = $_POST["email"];
$senha = $_POST["senha"];

// Verifica se o e-mail já existe
$sql = "SELECT id_usuario FROM usuario WHERE email = ?";

$stmt = $pdo->prepare($sql);
$stmt->execute([$email]);

if ($stmt->fetch()) {

    header("Location: cadastro.php?erro=1");
    exit;
}

// Protege a senha
$senha = password_hash($senha, PASSWORD_DEFAULT);

// Salva o usuário
$sql = "INSERT INTO usuario (nome, email, senha)
        VALUES (?, ?, ?)";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    $nome,
    $email,
    $senha
]);

header("Location: cadastro.php?sucesso=1");
exit;
?>

