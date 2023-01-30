<?php
session_start();
ob_start();
include 'connection.php';
$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
if (!empty($dados['sendLogin'])) {
    $searchUser = "SELECT id, user_name, user_email, user_password FROM users WHERE user_email = :user_email LIMIT 1";
    $resultSearch = $conn->prepare($searchUser);
    $resultSearch->bindParam(':user_email', $dados['txtEmail'], PDO::PARAM_STR);
    $resultSearch->execute();

    if (($resultSearch) and $resultSearch->rowCount() != 0) {
        $row_user = $resultSearch->fetch(PDO::FETCH_ASSOC);
        if (password_verify($dados['txtSenha'], $row_user['user_password'])) {
            $_SESSION['id'] = $row_user['id'];
            $_SESSION['user_name'] = $row_user['user_name'];
            $_SESSION['user_email'] = $row_user['user_email'];
            header("Location: dashboard.php");
        } else {
            $_SESSION['msg'] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    Error: Login ou Senha inválido!
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>';
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

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        .b-example-divider {
            height: 3rem;
            background-color: rgba(0, 0, 0, .1);
            border: solid rgba(0, 0, 0, .15);
            border-width: 1px 0;
            box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
        }

        .b-example-vr {
            flex-shrink: 0;
            width: 1.5rem;
            height: 100vh;
        }

        .bi {
            vertical-align: -.125em;
            fill: currentColor;
        }

        .nav-scroller {
            position: relative;
            z-index: 2;
            height: 2.75rem;
            overflow-y: hidden;
        }

        .nav-scroller .nav {
            display: flex;
            flex-wrap: nowrap;
            padding-bottom: 1rem;
            margin-top: -1px;
            overflow-x: auto;
            text-align: center;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
        }
    </style>
    <link href="assets/css/sign-in.css" rel="stylesheet">
</head>

<body class="text-center">
    <main class="form-signin w-100 m-auto">
        <form method="POST">
            <!-- <img class="mb-4" src="/docs/5.3/assets/brand/bootstrap-logo.svg" alt="" width="72" height="57"> -->
            <h1 class="h3 mb-3 fw-normal">System Financial</h1>
            <?php
            if (isset($_SESSION['msg'])) {
            ?>
                <?= $_SESSION['msg']; ?>
            <?php
                unset($_SESSION['msg']);
            }
            ?>

            <div class="form-floating">
                <input type="email" name="txtEmail" class="form-control" id="txtEmail" placeholder="usuario@systemfinancial.com">
                <label for="txtEmail">E-mail</label>
            </div>
            <div class="form-floating">
                <input type="password" name="txtSenha" class="form-control" id="txtSenha" placeholder="********">
                <label for="txtSenha">Senha</label>
            </div>

            <div class="checkbox mb-3">
                <label>
                    <input type="checkbox" value="remember-me"> Remember me
                </label>
            </div>
            <input class="w-100 btn btn-lg btn-primary" type="submit" name="sendLogin" id="sendLogin" value="Acessar">
            <p class="mt-5 mb-3 text-muted">&copy; 2023 - <?= date('Y'); ?></p>
        </form>
    </main>
</body>

</html>