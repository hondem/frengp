<?php

namespace App\AdminModule\Forms;

use Nette;
class EditSubPageFormFactory extends Nette\Object{
    
    public $subpages;
    public $subPageId;
    public function __construct(\App\Model\SubPages $subpages){
        $this->subpages = $subpages;
    }
    
    public function create($subpageId){
        $this->subPageId = $subpageId;
        $form = new \Nette\Application\UI\Form;
        $form->addText('subpageName', 'Název stránky: ')
                ->setRequired();
        $form->addTextArea('content', 'Obsah: ');
        $form->addSubmit('send', 'Uložit úpravy');
        
        if($this->subpages->pageEditationExists($subpageId)){
            $form->setDefaults($this->subpages->getPageEditation($subpageId)->toArray());
        } else{
            $form->setDefaults($this->subpages->getPage($subpageId)->toArray());
        }
        
        $form->onSuccess[] = array($this, 'formSuceeded');
        return $form;
    }
    
    public function formSuceeded($form, $values){
        $this->subpages->savePageEditation($this->subPageId, $values, $form->getPresenter()->getUser()->getId());
        $form->getPresenter()->flashMessage('Stránka úspěšně upravena.');
        $form->getPresenter()->redirect('SubPages:default');
    }
}
