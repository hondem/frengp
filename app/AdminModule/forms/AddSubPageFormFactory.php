<?php

namespace App\AdminModule\Forms;

use Nette;

class AddSubPageFormFactory extends Nette\Object{
    
    public $subpages;
    public function __construct(\App\Model\SubPages $subpages){
        $this->subpages = $subpages;
    }
    
    public function create(){
        $form = new \Nette\Application\UI\Form;
        $form->addText('subpageName', 'Název stránky: ')
                ->setRequired();
        $form->addTextArea('content', 'Obsah: ');
        $form->addSubmit('send', 'Send');
        
        $form->onSuccess[] = array($this, 'formSuceeded');
        return $form;
    }
    
    public function formSuceeded($form, $values){
        $this->subpages->addPage($values, $form->getPresenter()->getUser()->getId());
        $form->getPresenter()->flashMessage('Stránka úspěšně vytvořena');
        $form->getPresenter()->redirect('SubPages:default');
    }
}
