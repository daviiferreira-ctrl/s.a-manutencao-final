<?php

require "conexao.php";

$consultas = [];

try {

    $sql = "SELECT c.data, c.hora, c.local, c.descricao,
                   p.especie, p.foto_pet,
                   u.nome AS responsavel_nome
            FROM consulta c
            LEFT JOIN pet p ON c.id_pet = p.id_pet
            LEFT JOIN usuario u ON p.id_usuario = u.id_usuario
            WHERE (c.descricao NOT LIKE '%Adoção%'
              AND c.descricao NOT LIKE '%Adotado%')
              AND LOWER(c.descricao) NOT IN ('mia', 'thor', 'pipoca', 'bolinha', 'pompom',
               'mel', 'algodão', 'max', 'luna', 'fred')
              OR c.descricao IS NULL
            ORDER BY c.data DESC, c.hora DESC";

    $stmt = $pdo->query($sql);
    $consultas = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {

    $consultas = [];
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VetKet - Consultas Agendadas</title>
    <link rel="stylesheet" href="css/style.css">

</head>

<body>
    <div class="wrapper">

        <header>

            <nav class="navbar">
            <a href="base.html" class="logo"><img src="img/logo.png" alt="Vetket"></a>

                <ul class="menu">
                    <li><a href="agendamento.php">Agendamento</a></li>
                    <li><a href="listar.php">Consultas</a></li>
                    <li><a href="adocao.php">Adotar</a></li>
                    <li><a href="sobre.html">Sobre</a></li>
                    <li><a href="login.php">Sair</a></li>
                </ul>
            </nav>

        </header>
        <main class="consultas-container">
            <section class="consultas-card">
                <div class="consultas-titulo">
                    <h2>Consultas Agendadas</h2>
                    <p>Confira as consultas que estão agendadas na VetKet.</p>
                </div>
                <div class="tabela-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Data</th>
                                <th>Horário</th>
                                <th>Pet</th>
                                <th>Responsável</th>
                                <th>Local</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($consultas)): ?>
                                <?php foreach ($consultas as $con):
                                    $especie_texto = !empty($con['especie']) ? $con['especie'] : 'Não informada';
                                    $foto_nome = $con['foto_pet'] ?? null;
                                    $caminho_final = null;
                                    if (!empty($foto_nome)) {

                                        if (file_exists("uploads/" . $foto_nome)) {
                                            $caminho_final = "uploads/" . $foto_nome;
                                        } elseif (file_exists("img/" . $foto_nome)) {
                                            $caminho_final = "img/" . $foto_nome;
                                        }
                                    }
                                ?>
                                    <tr>

                                        <td><?php echo date('d/m/Y', strtotime($con['data'])); ?></td>

                                        <td><?php echo date('H:i', strtotime($con['hora'])); ?></td>

                                        <td>

                                            <div class="pet-mini-container">

                                                <?php if ($caminho_final !== null): ?>

                                                    <img src="<?php echo $caminho_final; ?>" class="pet-foto-renderizada" alt="Foto do Pet">

                                                <?php else: ?>
                                                    <span class="pet-foto-placeholder">🐾</span>
                                                <?php endif; ?>
                                                <span><?php echo htmlspecialchars($especie_texto); ?></span>
                                            </div>
                                        </td>
                                        <td><?php echo htmlspecialchars($con['responsavel_nome'] ?? 'Não informado'); ?></td>
                                        <td><?php echo htmlspecialchars($con['local']); ?></td>

                                    </tr>

                                <?php endforeach; ?>

                            <?php else: ?>
                                <tr><td colspan="5" class="sem-consultas">🐾 Nenhuma consulta médica agendada no momento.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
