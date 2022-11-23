<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/TZ2/src/UserRepository.php';




try {
    $userRepository = new UserRepository();
    $user = $userRepository->get($id);
    
    echo json_decode([
        'status' => true,
        'message' => '',
        'user' => $user
    ]);

} catch(Exception $exception) {
  
    echo json_decode([
        'status' => false,
        'message' => $exception->getMessage()
    ]);
}

