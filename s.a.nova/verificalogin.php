
<?php

session_start();

require "conexao.php";

$email = $_POST["email"];
$senha = $_POST["senha"];

$sql = "SELECT * FROM usuario WHERE email = ?";

$stmt = $pdo->prepare($sql);
$stmt->execute([$email]);

$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if ($usuario && password_verify($senha, $usuario["senha"])) {

    $_SESSION["id_usuario"] = $usuario["id_usuario"];
    $_SESSION["nome"] = $usuario["nome"];

    header("Location: base.html");
    exit;

} else {

    header("Location: login.php?erro=1");
    exit;
}

?>

