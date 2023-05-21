<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Financial - Redefinir senha</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/sign-in.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/regular.min.css">
</head>

<body class="bg-dark text-bg-dark">
    <main class="form-signin w-100 m-auto">
        <h1 class="h3 mb-3 fw-normal text-center">System Financial</h1>
        <h1 class="h6 mb-3 fw-normal text-center">Redefina aqui sua senha para acessar o sistema</h1>
        <form method="POST" class="row g-3" name="resetUserForm" id="resetUserForm">
            <div id="msgAlertaErrorReset"></div>
            <div id="msgAlerta"></div>
            <div class="col-md-12">
                <label for="txtEmail" class="form-label">Seu E-mail</label>
                <input type="email" name="txtEmail" class="form-control" id="txtEmail">
            </div>
            <div class="col-md-12 mt-4">
                <input class="w-100 btn btn-xs btn-secondary" type="submit" name="sendReset" id="sendReset" value="Redefinir">
            </div>
            <p class="text-center">Lembrou sua senha? <a href="/index.php">Logue aqui</a></p>
            <p class="mt-5 mb-3 text-center">&copy; 2023 - <?= date('Y'); ?></p>
        </form>
    </main>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/jquery-3.5.1.js"></script>
    <script src="assets/js/resetUserCustom.js"></script>
</body>

</html>