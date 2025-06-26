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
    <link rel="stylesheet" href="src/assets/vendors/simple-datatables/style.css">
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
                                <h3>Pedidos</h3>
                                <p class="text-subtitle text-muted">Olá <?= $_SESSION['document'] ?> ,

                                </p>
                            </div>
                            <div class="col-12 col-md-6 order-md-2 order-first">
                                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Cupons
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="page-content">
                    <section id="multiple-column-form">
                        <div class="row">
                            <div class="col-12">

                                <!-- LISTAGEM PEDIDOS -->
                                <div class="card shadow-sm rounded">
                                    <div class="card-header ">
                                        <h4 class="mb-0">📦 Lista de Pedidos</h4>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-hover align-middle" id="pedidos-table">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Status</th>
                                                    <th>Data</th>
                                                    <th>Itens</th>
                                                    <th class="text-center">Ações</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($pedidos as $pedido): ?>
                                                    <tr>
                                                        <td><span class="badge bg-dark"><?= $pedido['id'] ?></span></td>
                                                        <td>
                                                            <span class="badge 
                                <?= $pedido['status'] === 'pago' ? 'bg-success' : ($pedido['status'] === 'cancelado' ? 'bg-danger' : 'bg-secondary') ?>">
                                                                <?= ucfirst($pedido['status']) ?>
                                                            </span>
                                                        </td>
                                                        <td><?= date('d/m/Y H:i', strtotime($pedido['criado_em'])) ?></td>
                                                        <td>
                                                            <ul class="mb-0 ps-3 small">
                                                                <?php foreach ($pedido['itens'] as $item): ?>
                                                                    <li>
                                                                        <?= $item['produto_nome'] ?> —
                                                                        <?= $item['quantidade'] ?> un —
                                                                        R$ <?= number_format($item['preco_unitario'], 2, ',', '.') ?>
                                                                    </li>
                                                                <?php endforeach; ?>
                                                            </ul>
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="btn-group">
                                                                <button class="btn btn-sm btn-outline-success" onclick="verPedido(<?= $pedido['id'] ?>)">
                                                                    <i class="bi bi-eye"></i> Ver
                                                                </button>
                                                                <button class="btn btn-sm btn-outline-danger" onclick="cancelarPedido(<?= $pedido['id'] ?>)">
                                                                    <i class="bi bi-x-circle"></i> Cancelar
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <script>
                                    function cancelarPedido(id) {
                                        if (confirm("Tem certeza que deseja cancelar o pedido #" + id + "?")) {
                                            alert("Pedido " + id + " cancelado! (simulação)");
                                        }
                                    }
                                    function verPedido(id) {
                                        alert("Pedido " + id );
                                        
                                    }
                                </script>

                            </div>
                        </div>
                    </section>
                </div>

                <?php include __DIR__ . "/layouts/footer.php"; ?>
            </div>
        </div>
    </div>
    <script src="src/assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="src/assets/js/bootstrap.bundle.min.js"></script>

    <script src="src/assets/vendors/simple-datatables/simple-datatables.js"></script>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="src/assets/js/main.js"></script>

    <script>
        let tabelaPeidos = new simpleDatatables.DataTable("#pedidos-table");
    </script>

</body>

</html>