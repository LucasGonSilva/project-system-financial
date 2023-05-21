<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Financial - Cadastro</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/sign-in.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/regular.min.css">
</head>

<body class="bg-dark text-bg-dark">
    <main class="form-signin w-100 m-auto">
        <?php
        session_start();
        ob_start();
        include 'connection.php';

        if (!empty($_GET['key'])) {
            $searchUser = "SELECT 
                        id,
                        user_hash_user_recover,
                        flg_active
                    FROM users 
                    WHERE user_hash_user_recover = :user_hash_user_recover 
                    LIMIT 1";
            $resultSearch = $conn->prepare($searchUser);
            $resultSearch->bindParam(':user_hash_user_recover', $_GET['key'], PDO::PARAM_STR);
            $resultSearch->execute();

            if (($resultSearch) and $resultSearch->rowCount() != 0) {
                $row_user = $resultSearch->fetch(PDO::FETCH_ASSOC);
                //var_dump($row_user);die;
                $flg_active = 1;
                $user_hash_user_recover = NULL;
                $query_usuario = "UPDATE users SET user_hash_user_recover = :user_hash_user_recover, flg_active = :flg_active WHERE id = :id";
                $activeUser = $conn->prepare($query_usuario);
                $activeUser->bindParam(':user_hash_user_recover', $user_hash_user_recover, PDO::PARAM_STR);
                $activeUser->bindParam(':flg_active', $flg_active, PDO::PARAM_BOOL);
                $activeUser->bindParam(':id', $row_user['id'], PDO::PARAM_INT);

                if ($activeUser->execute()) {
                    $return = " <div class='alert alert-success text-center' role='alert'>
                                    <p style='font-size: 60px'>
                                        <i class='fas fa-smile'></i>
                                    </p>
                                    <p class='mb-2'>Usuário ativado com sucesso!</p>
                                    <a href='/system_financial'>
                                        <i class='fas fa-sign-in-alt'></i><br>
                                        Clique aqui para logar
                                    </a>
                                </div>";
                } else {
                    $return = "<div class='alert alert-danger' role='alert'>Error: Usuário não ativado com sucesso!</div>";
                }
            } else {
                $return = " <div class='alert alert-danger text-center' role='alert'>
                                <p style='font-size: 60px'>
                                    <i class='fas fa-frown'></i>
                                </p>
                                <p class='mb-2'>Nenhum usuário encontrado!</p>
                                <a href='/cadastro.php'>
                                    <i class='fas fa-user-plus'></i><br>
                                    Clique aqui para se cadastrar
                                </a>
                            </div>";
            }
            echo $return;
        }
        ?>
    </main>
</body>

</html>