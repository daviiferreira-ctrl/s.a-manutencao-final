<?php
require "conexao.php";


$sql_adotados = "SELECT nome_pet FROM historico_adocao";
$stmt_adotados = $pdo->query($sql_adotados);
$adotados = $stmt_adotados->fetchAll(PDO::FETCH_COLUMN);

$adotados = array_map(function($nome) {
    return mb_strtolower(trim($nome));
}, $adotados);


$sql_historico = "SELECT nome_pet, especie, nome_adotante, data_adocao
                  FROM historico_adocao
                  ORDER BY data_adocao DESC";
$stmt_historico = $pdo->query($sql_historico);
$historico = $stmt_historico->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>VetKet - Adoção</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <nav class="navbar">
                <a href="base.html" class="logo">
                    <img src="img/logo.png" alt="Vetket">
                </a>
            <ul class="menu">
                <li><a href="agendamento.php">Agendamento</a></li>
                <li><a href="listar.php">Consultas</a></li>
                <li><a href="adocao.php">Adotar</a></li>
                <li><a href="sobre.html">Sobre</a></li>
                <li><a href="login.php">Sair</a></li>
            </ul>
        </nav>
    </header>

    <main class="container">
        <h1 class="titulo-adocao">Encontre um novo amigo</h1>
        <p class="subtitulo-adocao">Conheça nossos pets disponíveis para adoção.</p>

        <!-- FILTROS -->
        <div class="filtros-adocao">
            <button type="button" onclick="filtrarPets('todos')">Todos</button>
            <button type="button" onclick="filtrarPets('Cachorro')">Cachorros</button>
            <button type="button" onclick="filtrarPets('Gato')">Gatos</button>
            <button type="button" onclick="filtrarPets('Coelho')">Coelhos</button>
        </div>

        <!-- PETS -->
        <div class="adocao-grid">

            <!-- 1. PIPOCA -->
            <div class="pet-card" data-especie="Cachorro">
                <div class="pet-image">
                    <img src="img/cachorro.jpg" alt="Foto do Cachorro">
                    <span class="pet-especie">Cachorro</span>
                </div>
                <div class="pet-info">
                    <h3>Pipoca</h3>
                    <div class="pet-detalhes">
                        <p><strong>Idade:</strong> 2 anos</p>
                        <p><strong>Saúde:</strong> <span class="badge">Excelente</span></p>
                    </div>
                    <?php if (!in_array("pipoca", $adotados)) { ?>
                        <a href="processo-adocao.php?nome=Pipoca&especie=Cachorro" class="btn-adotar">Quero Adotar</a>
                    <?php } else { ?>
                        <span class="pet-adotado">Adotado</span>
                    <?php } ?>
                </div>
            </div>

            <!-- 2. BOLINHA -->
            <div class="pet-card" data-especie="Cachorro">
                <div class="pet-image">
                    <img src="img/cachorro2.jpg" alt="Foto do Cachorro">
                    <span class="pet-especie">Cachorro</span>
                </div>
                <div class="pet-info">
                    <h3>Bolinha</h3>
                    <div class="pet-detalhes">
                        <p><strong>Idade:</strong> 5 meses</p>
                        <p><strong>Saúde:</strong> <span class="badge">Vacinado / Saudável</span></p>
                    </div>
                    <?php if (!in_array("bolinha", $adotados)) { ?>
                        <a href="processo-adocao.php?nome=Bolinha&especie=Cachorro" class="btn-adotar">Quero Adotar</a>
                    <?php } else { ?>
                        <span class="pet-adotado">Adotado</span>
                    <?php } ?>
                </div>
            </div>

            <!-- 3. POMPOM -->
            <div class="pet-card" data-especie="Coelho">
                <div class="pet-image">
                    <img src="img/coelho.jpg" alt="Foto do Coelho">
                    <span class="pet-especie">Coelho</span>
                </div>
                <div class="pet-info">
                    <h3>Pompom</h3>
                    <div class="pet-detalhes">
                        <p><strong>Idade:</strong> 1 ano</p>
                        <p><strong>Saúde:</strong> <span class="badge">Excelente</span></p>
                    </div>
                    <?php if (!in_array("pompom", $adotados)) { ?>
                        <a href="processo-adocao.php?nome=Pompom&especie=Coelho" class="btn-adotar">Quero Adotar</a>
                    <?php } else { ?>
                        <span class="pet-adotado">Adotado</span>
                    <?php } ?>
                </div>
            </div>

            <!-- 4. MEL -->
            <div class="pet-card" data-especie="Gato">
                <div class="pet-image">
                    <img src="img/gato.jpg" alt="Foto do Gato">
                    <span class="pet-especie">Gato</span>
                </div>
                <div class="pet-info">
                    <h3>Mel</h3>
                    <div class="pet-detalhes">
                        <p><strong>Idade:</strong> 3 anos</p>
                        <p><strong>Saúde:</strong> <span class="badge">Excelente</span></p>
                    </div>
                    <?php if (!in_array("mel", $adotados)) { ?>
                        <a href="processo-adocao.php?nome=Mel&especie=Gato" class="btn-adotar">Quero Adotar</a>
                    <?php } else { ?>
                        <span class="pet-adotado">Adotado</span>
                    <?php } ?>
                </div>
            </div>

            <!-- 5. THOR -->
            <div class="pet-card" data-especie="Gato">
                <div class="pet-image">
                    <img src="img/gato2.webp" alt="Foto de Gato">
                    <span class="pet-especie">Gato</span>
                </div>
                <div class="pet-info">
                    <h3>Thor</h3>
                    <div class="pet-detalhes">
                        <p><strong>Idade:</strong> 1 ano e 4 meses</p>
                        <p><strong>Saúde:</strong> <span class="badge">Vacinado</span></p>
                    </div>
                    <?php if (!in_array("thor", $adotados)) { ?>
                        <a href="processo-adocao.php?nome=Thor&especie=Gato" class="btn-adotar">Quero Adotar</a>
                    <?php } else { ?>
                        <span class="pet-adotado">Adotado</span>
                    <?php } ?>
                </div>
            </div>

            <!-- 6. ALGODÃO -->
            <div class="pet-card" data-especie="Gato">
                <div class="pet-image">
                    <img src="img/gato3.jpg" alt="Foto de Gato">
                    <span class="pet-especie">Gato</span>
                </div>
                <div class="pet-info">
                    <h3>Algodão</h3>
                    <div class="pet-detalhes">
                        <p><strong>Idade:</strong> 5 meses</p>
                        <p><strong>Saúde:</strong> <span class="badge">Excelente</span></p>
                    </div>
                    <?php if (!in_array("algodão", $adotados)) { ?>
                        <a ref="processo-adocao.php?nome=Algodão&especie=Gato" class="btn-adotar">Quero Adotar</a>
                    <?php } else { ?>
                        <span class="pet-adotado">Adotado</span>
                    <?php } ?>
                </div>
            </div>

            <!-- 7. MAX -->
            <div class="pet-card" data-especie="Cachorro">
                <div class="pet-image">
                    <img src="img/max.webp" alt="Foto do Cachorro">
                    <span class="pet-especie">Cachorro</span>
                </div>
                <div class="pet-info">
                    <h3>Max</h3>
                    <div class="pet-detalhes">
                        <p><strong>Idade:</strong> 3 anos</p>
                        <p><strong>Saúde:</strong> <span class="badge">Pulgas/span></p>
                    </div>
                    <?php if (!in_array("max", $adotados)) { ?>
                        <a ref="processo-adocao.php?nome=Max&especie=Cachorro" class="btn-adotar">Quero Adotar</a>
                    <?php } else { ?>
                        <span class="pet-adotado">Adotado</span>
                    <?php } ?>
                </div>
            </div>

            <!-- 8. LUNA -->
            <div class="pet-card" data-especie="Gato">
                <div class="pet-image">
                    <img src="img/gatoxp.png" alt="Foto do Gato">
                    <span class="pet-especie"> Gato</span>
                </div>
                <div class="pet-info">
                    <h3>Luna</h3>
                    <div class="pet-detalhes">
                        <p><strong>Idade:</strong> 1 ano</p>
                        <p><strong>Saúde:</strong> <span class="badge"> Castrada</span></p>
                    </div>
                    <?php if (!in_array("luna", $adotados)) { ?>
                        <a ref="processo-adocao.php?nome=Luna&especie=Gato" class="btn-adotar"> Quero Adotar</a>
                    <?php } else { ?>
                        <span class="pet-adotado">Adotado</span>
                    <?php } ?>
                </div>
            </div>

            <!-- 9. FRED -->
            <div class="pet-card" data-especie="Cachorro">
                <div class="pet-image">
                    <img src="img/cachorro3.jpg" alt="Foto do Cachorro">
                    <span class="pet-especie">Cachorro</span>
                </div>
                <div class="pet-info">
                    <h3>Fred</h3>
                    <div class="pet-detalhes">
                        <p><strong>Idade:</strong> 10 meses</p>
                        <p><strong>Saúde:</strong> <span class="badge"> Vacinado</span></p>
                    </div>
                    <?php if (!in_array("fred", $adotados)) { ?>
                        <a href="processo-adocao.php?nome=Fred&especie=Cachorro" class="btn-adotar">Quero Adotar</a>
                    <?php } else { ?>
                        <span class="pet-adotado">Adotado</span>
                    <?php } ?>
                </div>
            </div>

            <!-- 10. MIA -->
            <div class="pet-card" data-especie="Cachorro">
                <div class="pet-image">
                    <img src="img/cachorro4.webp" alt="Foto do cachorro">
                    <span class="pet-especie">Cachorro</span>
                </div>
                <div class="pet-info">
                    <h3>Mia</h3>
                    <div class="pet-detalhes">
                        <p><strong>Idade:</strong> 2 meses</p>
                        <p><strong>Saúde:</strong><span class="badge">Vacinado</span></p>
                    </div>
                    <?php if (!in_array("mia", $adotados)) { ?>
                        <a href="processo-adocao.php?nome=Mia&especie=Cachorro" class="btn-adotar">Quero Adotar</a>
                    <?php } else { ?>
                        <span class="pet-adotado">Adotado</span>
                    <?php } ?>
                </div>
            </div>

        </div>

        <!-- Histórico de adoção -->
        <section class="historico-adocao">
            <h2>Histórico de Adoções</h2>

            <?php if (count($historico) > 0) { ?>
                <div class="tabela-historico">
                    <table>
                        <thead>
                            <tr>
                                <th>Pet</th>
                                <th>Espécie</th>
                                <th>Adotante</th>
                                <th>Data</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($historico as $adocao) { ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($adocao["nome_pet"]); ?></td>
                                    <td><?php echo htmlspecialchars($adocao["especie"]); ?></td>
                                    <td><?php echo htmlspecialchars($adocao["nome_adotante"]); ?></td>
                                    <td>
                                        <?php
                                        echo date(
                                            "d/m/Y",
                                            strtotime($adocao["data_adocao"])
                                        );
                                        ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php } else { ?>
                <p class="sem-adocoes">Ainda não existem adoções registradas.</p>
            <?php } ?>
        </section>
    </main>

    <!-- Filtro -->
    <script>
        function filtrarPets(especie) {
            const pets = document.querySelectorAll(".pet-card");

            pets.forEach(function(pet) {
                if (especie === "todos") {
                    pet.style.display = "block";
                } else if (pet.dataset.especie === especie) {
                    pet.style.display = "block";
                } else {
                    pet.style.display = "none";
                }
            });
        }
    </script>
</body>
</html>
