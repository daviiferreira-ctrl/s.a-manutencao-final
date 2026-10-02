```php
<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require "conexao.php";


// Pega os dados do formulário
$nome_pet = $_POST['nome_pet'] ?? '';
$especie = $_POST['especie'] ?? 'Cachorro';

$nome_completo = $_POST['nome_completo'] ?? '';
$cpf = $_POST['cpf'] ?? '';
$telefone = $_POST['telefone'] ?? '';


// Verifica se foi informado um pet
if (!empty($nome_pet)) {


    // 1. Pega o usuário logado
    if (isset($_SESSION['id_usuario'])) {

        $id_usuario_valido = $_SESSION['id_usuario'];

    } else {

        $id_usuario_valido = $pdo->query(
            "SELECT id_usuario FROM usuario LIMIT 1"
        )->fetchColumn() ?: 1;
    }



    // 2. Salva o pet na tabela pet
    $especie_completa = $especie . " (" . $nome_pet . ")";

    $sql_pet = "INSERT INTO pet
                (id_usuario, especie, foto_pet)
                VALUES (:id_usuario, :especie, '')";

    $stmt_pet = $pdo->prepare($sql_pet);

    $stmt_pet->execute([
        ':id_usuario' => $id_usuario_valido,
        ':especie' => $especie_completa
    ]);

    $id_pet = $pdo->lastInsertId();



    // 3. Busca um veterinário
    $id_vet = $pdo->query(
        "SELECT id_vet FROM veterinario LIMIT 1"
    )->fetchColumn() ?: 1;



    // 4. Registra a adoção na tabela consulta
    // Isso mantém o funcionamento antigo
    // e faz o pet desaparecer da página de adoção.

    $sql_consulta = "INSERT INTO consulta
        (id_pet, id_vet, id_usuario, local, data, hora, descricao)
        VALUES (?, ?, ?, 'Clinica', CURDATE(), CURTIME(), ?)";

    $stmt_consulta = $pdo->prepare($sql_consulta);

    $stmt_consulta->execute([
        $id_pet,
        $id_vet,
        $id_usuario_valido,
        "Adoção: " . mb_strtolower($nome_pet)
    ]);




    // 5. Salva a adoção no histórico

    $sql_historico = "INSERT INTO historico_adocao
        (nome_pet, especie, nome_adotante, cpf, telefone, data_adocao)
        VALUES (?, ?, ?, ?, ?, CURDATE())";

    $stmt_historico = $pdo->prepare($sql_historico);

    $stmt_historico->execute([
        $nome_pet,
        $especie,
        $nome_completo,
        $cpf,
        $telefone
    ]);

}


// 6. Mensagem de sucesso e volta para adoção

echo "<script>
    alert('Parabéns! Você adotou o pet " . htmlspecialchars($nome_pet) . " com sucesso!');
    window.location.href = 'adocao.php';
</script>";

?>
```
