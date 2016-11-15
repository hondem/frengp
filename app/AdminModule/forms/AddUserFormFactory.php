<?php
namespace App\AdminModule\Forms;

use Nette;

class AddUserFormFactory extends Nette\Object{
    private $factory;
    public $users;
    
    public function __construct(\App\Forms\FormFactory $formFactory, \App\Model\Users $users){
        $this->factory = $formFactory;
        $this->users = $users;
    }
    
    public function create(){
        $form = $this->factory->create();
        $form->addText('username', 'Email: ')
                ->addRule(Nette\Forms\Form::EMAIL, 'Musí být email')
                ->setRequired();
        $form->addPassword('password', 'Heslo: ')
                ->setRequired();
        $form->addPassword('passVer', 'Heslo: ')
                ->setRequired();
        $form->addSubmit('send', 'Vytvořit');
        
        $form->onSuccess[] = array($this, 'formSucceeded');
        return $form;
    }
    
    public function formSucceeded($form, $values){
        if($values['password'] == $values['passVer']){
            $this->users->addUser($values);
            $form->getPresenter()->flashMessage('Uživatel úspěšně přidán', 'succeed');
            $form->getPresenter()->redirect('Users:default');
        } else{
            $form->getPresenter()->flashMessage('Hesla se neshodují', 'warning');
            $form->getPresenter()->redirect('this');
        }
    }
}