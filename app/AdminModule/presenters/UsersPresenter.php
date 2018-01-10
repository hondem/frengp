<?php

namespace App\AdminModule\Presenters;

use App\AdminModule\Forms\AddUserFormFactory;

class UsersPresenter extends BasePresenter{
    
    /** @var AddUserFormFactory @inject */
    public $addUserFF;
    
    public function renderDefault(){
        $this->template->users = $this->users->getUsers();
        $this->users->changePassword(1, 'Fofolakrabice98');
        $this->users->changePassword(7, 'Frengp.1492');
    }
    
    public function createComponentAddUserForm(){
        return $this->addUserFF->create();
    }
    
}
