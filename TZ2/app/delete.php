<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/TZ2/src/UserRepository.php';

try {
    $userRepository = new UserRepository();
    $id = $userRepository->searchId($_POST['login']);
    $remoteUser = $userRepository->delete($id);

    echo json_encode([
        'status' => true,
        'message' => '',
    ]);

} catch(Exception $exception) {
  
    echo json_encode([
        'status' => false,
        'message' => $exception->getMessage()
    ]);
}
