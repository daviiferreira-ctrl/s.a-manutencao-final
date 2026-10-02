<?php
require_once "conexao.php";

$sql_vets = "SELECT id_vet, nome, especialidade FROM veterinario ORDER BY nome ASC";
$stmt_vets = $pdo->query($sql_vets);
$veterinarios = $stmt_vets->fetchAll(PDO::FETCH_ASSOC);

$sql_vet_automatico = "SELECT id_vet FROM veterinario LIMIT 1";
$stmt_vet_automatico = $pdo->query($sql_vet_automatico);
$vet_encontrado = $stmt_vet_automatico->fetch(PDO::FETCH_ASSOC);

$id_vet_padrao = $vet_encontrado ? $vet_encontrado['id_vet'] : 1;
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VetKet - Agendamento</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="wrapper">
        <!-- Cabeçalho -->
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

        <!-- Conteudo -->
        <main class="container">
            <div class="agendamento-card">
                <div class="titulo-agendamento">
                    <h2>Dados do agendamento</h2>
                    <p>Preencha os dados abaixo para realizar o agendamento da consulta do seu pet.</p>
                </div>

                <form method="POST" action="salvar-agendamento.php" enctype="multipart/form-data">
                    <input type="hidden" name="id_vet" value="<?php echo $id_vet_padrao; ?>">
                    <input type="hidden" name="locall" value="Clínica Principal">

                    <!--Dado do responsavel-->
                    <div class="form-section">
                        <h3>👤 Dados do responsável</h3>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="nome">Nome do Responsável:</label>
                                <input type="text" name="nome" id="nome" required>
                            </div>

                            <div class="form-group">
                                <label for="email">E-mail:</label>
                                <input type="email" name="email" id="email" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="telefone">Telefone:</label>
                                <input type="text" name="telefone" id="telefone" required>
                            </div>

                            <div class="form-group vazio"></div>
                        </div>
                    </div>

                    <!--Dados do pet-->
                    <div class="form-section">
                        <h3>🐾 Dados do pet</h3>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="pet_nome">Nome do Pet:</label>
                                <input type="text" name="pet_nome" id="pet_nome" required>
                            </div>

                            <div class="form-group">
                                <label for="especie">Espécie:</label>
                                <input type="text" name="especie" id="especie" placeholder="Ex: Cachorro, Gato" required>
                            </div>
                        </div>

                        <div class="form-group foto-group">
                            <label for="foto">Foto do Pet:</label>
                            <input type="file" name="foto" id="foto" accept="image/*" required>
                        </div>

                        <div class="preview" id="preview">
                            <span>🐾 Preview da imagem</span>
                        </div>
                    </div>

                    <!-- Data e horário -->
                    <div class="form-section">
                        <h3>Data e horário</h3>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="dataa">Data de agendamento:</label>
                                <input type="date" name="dataa" id="dataa" required>
                            </div>

                            <div class="form-group">
                                <label for="hora">Horário de agendamento:</label>
                                <input type="time" name="hora" id="hora" required>
                            </div>
                        </div>
                    </div>

                    <!--Botão-->
                    <button type="submit" class="btn-agendar">Agendar consulta</button>
                </form>
            </div>
        </main>
    </div>

    <!-- Foto do pet -->
    <script>
        const foto = document.getElementById('foto');
        const preview = document.getElementById('preview');

        foto.addEventListener('change', function () {
            const arquivo = this.files[0];

            if (arquivo) {
                const leitor = new FileReader();

                leitor.onload = function (e) {
                    preview.innerHTML = `<img src="${e.target.result}" alt="Preview do Pet">`;
                };

                leitor.readAsDataURL(arquivo);
            } else {
                preview.innerHTML = '<span>Preview da imagem</span>';
            }
        });
    </script>
</body>
</html>

