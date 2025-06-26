<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - <?= $_ENV['APP_NAME'] ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="src/assets/css/bootstrap.css">
    <link rel="stylesheet" href="src/assets/vendors/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="src/assets/css/app.css">
    <link rel="stylesheet" href="src/assets/css/pages/auth.css">
    <link rel="icon" href="https://sou.montink.com/wp-content/uploads/2021/09/cropped-Design-sem-nome-1-32x32.png" sizes="32x32" />
</head>

<body>
    <div id="auth">
        <div class="row h-100">
            <div class="col-lg-5 col-12 d-flex align-items-center h-100">
                <div id="auth-left" class="w-100">
                    <h1 class="auth-title">Entrar</h1>
                    <p class="auth-subtitle mb-5">Faça login com montink e montink</p>

                    <!-- Mensagem de erro -->
                    <div class="alert alert-danger" role="alert"
                        <?= (isset($_GET['error']) && $_GET['error'] == 1) ? "style='display: block'" : "style='display: none'" ?>>
                        Documento ou senha incorretos. Tente novamente.
                    </div>

                    <form action="/login" method="POST">
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" name="document" value="montink" class="form-control form-control-xl" placeholder="CPF , CNPJ ou E-mail">
                            <div class="form-control-icon">
                                <i class="bi bi-envelope"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" name="password" value="montink" class="form-control form-control-xl" placeholder="Senha">
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                        </div>
                        <div class="form-check form-check-lg d-flex align-items-end">
                            <input class="form-check-input me-2" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label text-gray-600" for="flexCheckDefault">
                                Mantenha-me conectado
                            </label>
                        </div>
                        <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Entrar</button>
                    </form>
                    <div class="text-center mt-5 text-lg fs-4">
                        <p><a class="font-bold" href="auth-forgot-password.html">Esqueceu sua senha?</a></p>
                    </div>
                </div>
            </div>

            <div class="col-lg-7 d-none d-lg-block">
                <div id="auth-right" class="d-flex justify-content-center align-items-center h-100">
                    <a href="/login">
                        <img src="https://sou.montink.com/wp-content/uploads/2024/04/logo.png" alt="Logo" style="max-width: 50%;">
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>