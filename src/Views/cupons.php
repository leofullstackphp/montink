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
                                <h3>Cupons</h3>
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

                                
                                <!-- LISTAGEM PRODUTOS -->
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Lista de Cupons</h4>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-striped" id="cupons-table">
                                            <thead>
                                                <tr class="">
                                                    <th>CÓDIGO</th>
                                                    <th>TIPO</th>
                                                    <th>VALOR</th>
                                                    <th>VALIDADE</th>
                                                </tr>
                                            </thead>
                                            <tbody class="">
                                                <?php foreach ($cupons as $cupom) :?>
                                                    <tr>
                                                        <td><?= $cupom['codigo'] ?></td>
                                                        <td><?= $cupom['tipo'] ?></td>
                                                        <td><?= $cupom['valor'] ?></td>
                                                        <td><?= $cupom['validade'] ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                

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
        let tabelaCupons = new simpleDatatables.DataTable("#cupons-table");
        
    </script>

</body>

</html>