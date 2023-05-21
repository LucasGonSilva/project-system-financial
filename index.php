<?php
session_start();
ob_start();
include 'connection.php';
$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
if (!empty($dados['sendLogin'])) {
    $searchUser = "SELECT id, user_full_name, user_email, user_password, user_hash_user_recover FROM users WHERE user_email = :user_email LIMIT 1";
    $resultSearch = $conn->prepare($searchUser);
    $resultSearch->bindParam(':user_email', $dados['txtEmail'], PDO::PARAM_STR);
    $resultSearch->execute();

    if (($resultSearch) and $resultSearch->rowCount() != 0) {
        $row_user = $resultSearch->fetch(PDO::FETCH_ASSOC);
        //var_dump($row_user);die;
        if ($row_user['user_hash_user_recover'] && !$row_user['flg_active']) {
            $_SESSION['msg'] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    Usuário não confirmado!
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>';
        } else {
            if (password_verify($dados['txtSenha'], $row_user['user_password'])) {
                $_SESSION['id'] = $row_user['id'];
                $_SESSION['user_full_name'] = $row_user['user_full_name'];
                $_SESSION['user_email'] = $row_user['user_email'];
                header("Location: dashboard.php");
            } else {
                $_SESSION['msg'] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    Error: Login ou Senha inválido!
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>';
            }
        }
    } else {
        $_SESSION['msg'] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                Error: Login ou Senha inválido!
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Financial - Login</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/sign-in.css" rel="stylesheet">
</head>

<body class="bg-dark text-bg-dark">
    <main class="form-signin w-100 m-auto">
        <h1 class="h3 mb-3 fw-normal text-center">System Financial</h1>
        <h1 class="h6 mb-3 fw-normal text-center">Acesse aqui seu controle financeiro</h1>
        <form method="POST" class="row g-3">
            <!-- <img class="mb-4" src="/docs/5.3/assets/brand/bootstrap-logo.svg" alt="" width="72" height="57"> -->
            <?php
            if (isset($_SESSION['msg'])) {
            ?>
                <?= $_SESSION['msg']; ?>
            <?php
                unset($_SESSION['msg']);
            }
            ?>

            <div class="col-md-12">
                <label for="txtEmail">Seu E-mail</label>
                <input type="email" name="txtEmail" class="form-control" id="txtEmail">
            </div>
            <div class="col-md-12">
                <label for="txtSenha">Sua Senha</label>
                <input type="password" name="txtSenha" class="form-control" id="txtSenha">
            </div>
            <div class="col-md-12 mt-4">
                <input class="w-100 btn btn-xs btn-secondary" type="submit" name="sendLogin" id="sendLogin" value="Acessar">
            </div>
            <p class="text-center">Esqueceu sua senha? <a href="/redefinir-senha.php">Redefina aqui</a></p>
            <p class="text-center">Não possui cadastro? <a href="/cadastro.php">Cadastre-se aqui</a></p>
            <p class="mt-5 mb-3 text-center text-bg-dark">&copy; 2023 - <?= date('Y'); ?></p>
        </form>
    </main>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/jquery-3.5.1.js"></script>
</body>

</html>