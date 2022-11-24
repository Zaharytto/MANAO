<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/TZ2/src/UserRepository.php';

try {
    $userRepository = new UserRepository();
    $user = $userRepository->authorization($_POST['login'], $_POST['password']);
    session_start();
    setcookie('login', $_POST['login'], time() + 60 * 60 * 24 * 30, '/TZ2');
    $_SESSION['login'] = $_POST['login'];
    
    echo json_encode([
        'status' => true,
        'message' => 'Вы авторизовались'
    ]);

} catch(Exception $exception) {
  
    echo json_encode([
        'status' => false,
        'message' => $exception->getMessage()
    ]);
}

