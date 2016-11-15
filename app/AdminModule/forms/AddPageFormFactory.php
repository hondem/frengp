<?php

namespace App\AdminModule\Forms;

use Nette;
class AddPageFormFactory extends Nette\Object{
    
    public $pages;
    public function __construct(\App\Model\Pages $pages){
        $this->pages = $pages;
    }
    
    public function create(){
        $form = new \Nette\Application\UI\Form;
        $form->addText('pageName', 'Název stránky: ')
                ->setRequired();
        $form->addTextArea('content', 'Obsah: ');
        $form->addSubmit('send', 'Send');
        
        $form->onSuccess[] = array($this, 'formSuceeded');
        return $form;
    }
    
    public function formSuceeded($form, $values){
        $this->pages->addPage($values, $form->getPresenter()->getUser()->getId());
        $form->getPresenter()->flashMessage('Novinka úspěšně odeslána');
        $form->getPresenter()->redirect('Pages:default');
    }
}
