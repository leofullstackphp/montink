<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - <?= $_ENV['APP_NAME'] ?></title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="src/assets/css/bootstrap.css">

    <link rel="stylesheet" href="src/assets/vendors/iconly/bold.css">

    <link rel="stylesheet" href="src/assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="src/assets/vendors/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="src/assets/css/app.css">
    <link rel="shortcut icon" href="" type="image/x-icon">
    <link rel="icon" href="https://sou.montink.com/wp-content/uploads/2021/09/cropped-Design-sem-nome-1-32x32.png" sizes="32x32" />
</head>

<body>
    <div id="app">
        <?php include __DIR__ . "/layouts/sidebar.php"; ?>
        <div id="main" class='layout-navbar'>
            <?php include __DIR__ . "/layouts/header.php"; ?>
            <div id="main-content">

                <div class="page-heading">
                    <div class="page-title">
                        <div class="row">
                            <div class="col-12 col-md-6 order-md-1 order-last">
                                <h3>Dashboard</h3>
                                <p class="text-subtitle text-muted">
                                    Olá <?= $_SESSION['document'] ?>,
                                    <br><br>

                                    O banco de dados do projeto já está configurado automaticamente e é iniciado junto com o Docker.
                                    <br>
                                    Ele utiliza o arquivo <code>tabelas.sql</code> localizado na raiz do projeto para criar as tabelas iniciais.
                                </p>

                                <br>

                                <h5>📩 Webhook de Atualização de Pedido (POST)</h5>
                                <p class="text-muted">
                                    Você pode testar a atualização de um pedido utilizando uma requisição <strong>POST</strong> autenticada por <strong>Basic Auth</strong>.
                                </p>

                                <pre><code>curl --location 'http://localhost:8080/api/webhook' \
--header 'Authorization: Basic bW9udGluazptb250aW5r' \
--form 'id_pedido="8"' \
--form 'status="pago"'</code></pre>

                                <p class="text-muted mt-2">
                                    🔐 Autenticação:
                                    <br>
                                    <strong>Usuário:</strong> <code>montink</code> &nbsp;&nbsp;&nbsp;
                                    <strong>Senha:</strong> <code>montink</code>
                                </p>

                                <p class="text-muted">
                                    ✅ O status do pedido será atualizado com o valor informado (<code>pago</code>, <code>cancelado</code>, etc).
                                    <br>
                                    ❌ Se o status enviado for <code>cancelado</code>, o pedido será <strong>removido automaticamente</strong>, junto com os itens vinculados (<code>pedidos_itens</code>) via exclusão em cascata.
                                </p>

                                <br>

                                <h5>📦 Migração de Cupons</h5>
                                <p class="text-subtitle text-muted">
                                    Para rodar a <strong>migração de cupons</strong>, siga os passos abaixo:
                                </p>

                                <ol>
                                    <li>
                                        Abra o arquivo <code>cupons.csv</code> localizado na raiz do projeto e insira os cupons no seguinte formato:
                                        <br><br>
                                        <code>codigo,tipo,valor,quantidade_uso,usado,validade</code><br>
                                        <code>DESCONTO10,percentual,10.00,100,0,2025-12-31</code>
                                    </li>

                                    <li>
                                        <strong>⚠️ Atenção:</strong> o campo <code>codigo</code> é <strong>único</strong>.
                                        Se você tentar inserir um cupom com o mesmo código mais de uma vez, ocorrerá erro.
                                    </li>

                                    <li>
                                        Acesse o container do seu projeto PHP com o comando:
                                        <br><br>
                                        <code>docker exec -it CONTAINER_ID bash</code>
                                    </li>

                                    <li>
                                        Execute o script de migração:
                                        <br><br>
                                        <code>php cupons-migrar.php</code>
                                    </li>
                                </ol>

                                <p class="text-muted">
                                    Após a execução, os cupons serão inseridos no banco de dados e você verá mensagens de sucesso no terminal.
                                </p>
                            </div>



                            <div class="col-12 col-md-6 order-md-2 order-first">
                                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                                        <!-- <li class="breadcrumb-item active" aria-current="page">Layout Vertical Navbar -->
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>


                <?php include __DIR__ . "/layouts/footer.php"; ?>
            </div>
        </div>
    </div>
    <script src="src/assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="src/assets/js/bootstrap.bundle.min.js"></script>


    <script src="src/assets/js/main.js"></script>
</body>

</html>