<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/TZ2/src/UserRepository.php';

try {
    $userRepository = new UserRepository();
    $id = $userRepository->searchId($_POST['login']);
    $userRepository->update($id, $_POST['login'], $_POST['password'], $_POST['email'], $_POST['name']);
    
    echo json_encode([
        'status' => true,
        'message' => '',
        'name' => $user['name']
    ]);

} catch(Exception $exception) {
  
    echo json_encode([
        'status' => false,
        'message' => $exception->getMessage()
    ]);
}
