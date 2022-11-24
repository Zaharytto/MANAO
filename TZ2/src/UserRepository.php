<?php

class UserRepository
{
    private const FILE_PATH = '/TZ2/data/repository.json';

    public function __construct()
    {
        if($this->isFileExist() === false){
            throw new Exception('json file empty');
        }
    }

    private function isFileExist(): bool
    {
      return file_exists($_SERVER['DOCUMENT_ROOT'] . self::FILE_PATH);  
    }

    private function getFile()
    {
        return file_get_contents($_SERVER['DOCUMENT_ROOT'] . self::FILE_PATH);
    }

    private function isUserExist($login): bool
    {
        $result = null;

        $file = $this->getFile();
        $users = (array) json_decode($file);

        $result = array_search($login, array_column($users, 'login'));

        if($result !== false) {
            return true;
        } 
        return false;
    }

    public function create(string $login, string $password, string $email, string $name): void
    {   
        if ($this->isUserExist($login) === false) {

            $file = $this->getFile();
            $users = (array) json_decode($file);
            $salt = 'sflprt49fhi2';
                    
            $users[] = [
                'login' => $login,
                'password' => md5($password . $salt),
                'email' => $email,
                'name' => $name
            ];
    
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . self::FILE_PATH, json_encode($users, JSON_FORCE_OBJECT));
    
            return;
        } 

        throw new Exception('Пользователь с таким логином уже существует');
    }

    
    public function searchId($login)
    {
        $file = $this->getFile();
        $users = (array) json_decode($file, true);

        foreach($users as $key => $value) {
            if ($users[$key]['login'] === $login) {
                return $key;
            } 
        }
        return null;
    }

    public function authorization(string $login, string $password)
    {
        $id = $this->searchId($login);
        $salt = 'sflprt49fhi2';

        if ($id === null) {
            throw new Exception('Такого пользователя не существует!!');
        }

        $user = $this->get($id);

        if ($user === null) {
            throw new Exception('Такого пользователя не существует!!');
        }

        if ($user['password'] !== md5($password  . $salt)){
            throw new Exception('Неверный пароль');
        }

        return true;
    }
    

    public function get(int $id): ?array
    {
        $usersJson = $this->getFile();
        $usersJsonArray = (array) json_decode($usersJson, true);
        
        if (!isset($usersJsonArray[$id])) {
            return null;
        }
        
        return $usersJsonArray[$id];
        
    }

    public function delete(int $id): void
    {
        $user = $this->get($id);

        if ($user === null ) {
            throw new Exception('user with id ' . $id . ' not found');
        }

        unset($users[$id]);

        file_put_contents($_SERVER['DOCUMENT_ROOT'] . self::FILE_PATH, json_encode($users, JSON_FORCE_OBJECT));

        return;
    }

    public function update(int $id, string $login, string $password, string $email, string $name): void
    {
        $user = $this->get($id);

        if ($user === null ) {
            throw new Exception('user with id ' . $id . ' not found');
        }

        $file = $this->getFile();
        $users = (array) json_decode($file);

        $users[$id]['login'] = $login;
        $users[$id]['password'] = $password;
        $users[$id]['email'] = $email;
        $users[$id]['name'] = $name;
            
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . self::FILE_PATH, json_encode($users, JSON_FORCE_OBJECT));

        return;
    }
}




