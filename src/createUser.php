<?php

include_once "../connection.php";
include '../uteis/uteis.php';

$uteis = new Uteis();

$host = $_SERVER['HTTP_HOST'];

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

if (empty($dados['txtNome'])) {
    $retorna = [
        'error' => true,
        'msg' => "<div class='alert alert-danger' role='alert'>Error: Necessário preencher o campo nome!</div>"
    ];
} elseif (empty($dados['txtEmail'])) {
    $retorna = [
        'error' => true,
        'msg' => "<div class='alert alert-danger' role='alert'>Error: Necessário preencher o campo email!</div>"
    ];
} elseif (empty($dados['txtSenha'])) {
    $retorna = [
        'error' => true,
        'msg' => "<div class='alert alert-danger' role='alert'>Error: Necessário preencher o campo senha!</div>"
    ];
} else {

    $dateAtual = date("Y-m-d H:i:s");

    $passwordHash = password_hash($dados['txtSenha'], PASSWORD_DEFAULT);

    $hash_user_recover = password_hash('123456', PASSWORD_DEFAULT);

    $profile_id_default = 3;

    $flg_active = 0;

    $query_usuario = "  INSERT INTO users (user_full_name, user_email, user_password, user_profile_id, user_hash_user_recover, flg_active) 
                        VALUES (:user_full_name, :user_email, :user_password, :user_profile_id, :user_hash_user_recover, :flg_active)";
    $cadUsuario = $conn->prepare($query_usuario);
    
    $cadUsuario->bindParam(":user_full_name", utf8_decode($dados['txtNome']), PDO::PARAM_STR);
    $cadUsuario->bindParam(':user_email', $dados['txtEmail'], PDO::PARAM_STR);
    $cadUsuario->bindParam(':user_password', $passwordHash, PDO::PARAM_STR);
    $cadUsuario->bindParam(':user_profile_id', $profile_id_default, PDO::PARAM_INT);
    $cadUsuario->bindParam(':user_hash_user_recover', $hash_user_recover, PDO::PARAM_STR);
    $cadUsuario->bindParam(':flg_active', $flg_active, PDO::PARAM_INT);

    $dados['link'] = "$host/system_financial/ativar-conta.php?key=$hash_user_recover";

    if ($cadUsuario->execute()) {
        $response = $uteis->sendEmailNewUser($dados);
        if (!$response['error']) {
            $retorna = [
                'error' => false,
                'msg' => "<div class='alert alert-success' role='alert'>
                            <p style='font-size: 30px' class='text-center'>
                                <i class='fas fa-smile'></i>
                            </p>
                            <p class='fw-bold text-center'>Usuário cadastrado com sucesso!</p>
                            <p>Foi encaminhado um e-mail de confirmação para o e-mail cadastrado. <br>Confirme e acesse o sistema.</>
                        </div>"
            ];
        }
    }

    // if ($cadUsuario->rowCount()) {
    //     $retorna = [
    //         'error' => false,
    //         'msg' => "<div class='alert alert-success' role='alert'>Usuário cadastrado com sucesso!</div>"
    //     ];
    // } else {
    //     $retorna = [
    //         'error' => true,
    //         'msg' => "<div class='alert alert-danger' role='alert'>Error: Usuário não cadastrado com sucesso!</div>"
    //     ];
    // }
}

echo json_encode($retorna);
