<?php

namespace App\AdminModule\Presenters;

use App\AdminModule\Forms\AddUserFormFactory;

class UsersPresenter extends BasePresenter{
    
    /** @var AddUserFormFactory @inject */
    public $addUserFF;
    
    public function renderDefault(){
        $this->template->users = $this->users->getUsers();
    }
    
    public function createComponentAddUserForm(){
        return $this->addUserFF->create();
    }
    
}
