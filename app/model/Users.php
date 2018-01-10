<?php

namespace App\Model;

class Users extends BaseModel{
    public function getUsers(){
        return $this->database->table(DatabaseStructure::USERS)->fetchAll();
    }
    
    public function getUser($userId){
        return $this->database->table(DatabaseStructure::USERS)->where('id', $userId)->fetch();
    }
    
    public function addUser($values){
        $this->database->table(DatabaseStructure::USERS)->insert(array(
            'username' => $values['username'],
            'password' => \Nette\Security\Passwords::hash($values['password']),
            'role' => 'user'
        ));
    }

    public function changePassword($userId, $newPassword){
        $this->database->table(DatabaseStructure::USERS)->where('id', $userId)->update(array(
            'password' => \Nette\Security\Passwords::hash($newPassword)
        ));
    }
}
