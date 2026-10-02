<?php
require "conexao.php";

// Captura os dados do formulário tirando espaços vazios
$nome       = isset($_POST['nome']) ? trim($_POST['nome']) : 'Responsável';
$email      = isset($_POST['email']) ? trim($_POST['email']) : 'email@teste.com';
$telefone   = isset($_POST['telefone']) ? trim($_POST['telefone']) : '00000000';
$pet_nome   = isset($_POST['pet_nome']) ? trim($_POST['pet_nome']) : 'Pet'; 
$especie    = isset($_POST['especie']) ? trim($_POST['especie']) : 'Animal';
$data       = isset($_POST['dataa']) ? $_POST['dataa'] : date('Y-m-d'); 
$hora       = isset($_POST['hora']) ? $_POST['hora'] : date('H:i:s');
$local      = "Clinica Principal"; 


$sql_check = "SELECT COUNT(*) FROM consulta WHERE data = ? AND hora = ? AND local = ?";
$stmt_check = $pdo->prepare($sql_check);
$stmt_check->execute([$data, $hora, $local]);
$horario_ocupado = $stmt_check->fetchColumn();

if ($horario_ocupado > 0) {
    echo "<script>
        alert('Atenção: Este horário já está preenchido na Clínica Principal! Por favor, escolha outro horário.');
        window.history.back();
    </script>";
    exit;
}


$nomeFoto = "";


if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
    $pasta = "uploads/";
    if (!is_dir($pasta)) {
        mkdir($pasta, 0777, true);
    }
    $nomeFoto = uniqid() . "_" . basename($_FILES['foto']['name']);
    move_uploaded_file($_FILES['foto']['tmp_name'], $pasta . $nomeFoto);
}

try {
    //  Localiza ou cadastra o Usuário pelo e-mail
    $sql_user = "SELECT id_usuario FROM usuario WHERE email = :email";
    $stmt_user = $pdo->prepare($sql_user);
    $stmt_user->bindValue(":email", $email);
    $stmt_user->execute();
    $user = $stmt_user->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $id_usuario = $user['id_usuario'];
    } else {
        $sql_ins_user = "INSERT INTO usuario (nome, email, senha, permissao_funcao) VALUES (:nome, :email, '123456', 'cliente')";
        $stmt_ins_user = $pdo->prepare($sql_ins_user);
        $stmt_ins_user->bindValue(":nome", $nome);
        $stmt_ins_user->bindValue(":email", $email);
        $stmt_ins_user->execute();
        $id_usuario = $pdo->lastInsertId();
    }

    // 2. Cadastra sempre um novo Pet de forma direta para evitar conflitos de IDs
    $especie_completa = $especie . " (" . $pet_nome . ")";
    $sql_ins_pet = "INSERT INTO pet (id_usuario, especie, foto_pet) VALUES (:id_usuario, :especie, :foto_pet)";
    $stmt_ins_pet = $pdo->prepare($sql_ins_pet);
    $stmt_ins_pet->bindValue(":id_usuario", $id_usuario);
    $stmt_ins_pet->bindValue(":especie", $especie_completa);
    $stmt_ins_pet->bindValue(":foto_pet", $nomeFoto);
    $stmt_ins_pet->execute();
    $id_pet = $pdo->lastInsertId();

    // 3. Garante que exista o Veterinário padrão (ID 1)
    $pdo->query("INSERT IGNORE INTO veterinario (id_vet, nome, especialidade, hora_atendi, descricao) VALUES (1, 'Geral', 'Clínica Geral', '08:00:00', 'Atendimento geral')");

    // 4. Insere a consulta médica de forma limpa na tabela
    $sql_consulta = "INSERT INTO consulta (id_pet, id_vet, id_usuario, local, data, hora, descricao) 
                     VALUES (:id_pet, 1, :id_usuario, :local, :data, :hora, :descricao)";
    $stmt_consulta = $pdo->prepare($sql_consulta);
    $stmt_consulta->bindValue(":id_pet", $id_pet);
    $stmt_consulta->bindValue(":id_usuario", $id_usuario);
    $stmt_consulta->bindValue(":local", $local);
    $stmt_consulta->bindValue(":data", $data);
    $stmt_consulta->bindValue(":hora", $hora);
    $stmt_consulta->bindValue(":descricao", "Consulta Medica"); // Texto neutro para passar direto pelo filtro do listar.php
    $stmt_consulta->execute();

    echo "<script>alert('Agendamento realizado com sucesso!'); window.location.href = 'listar.php';</script>";
} catch (PDOException $e) {
    // Se houver qualquer erro no banco, ele vai te avisar por meio de um alerta na tela
    echo "<script>alert('Erro ao salvar no banco de dados: " . addslashes($e->getMessage()) . "'); window.history.back();</script>";
}
?>

