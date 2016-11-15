<?php

namespace App\AdminModule\Forms;

use Nette;
class EditPageFormFactory extends Nette\Object{
    
    public $pages;
    public $pageId;
    public function __construct(\App\Model\Pages $pages){
        $this->pages = $pages;
    }
    
    public function create($pageId){
        $this->pageId = $pageId;
        $form = new \Nette\Application\UI\Form;
        $form->addText('pageName', 'Název stránky: ')
                ->setRequired();
        $form->addTextArea('content', 'Obsah: ');
        $form->addSubmit('send', 'Uložit úpravy');
        
        if($this->pages->pageEditationExists($pageId)){
            $form->setDefaults($this->pages->getPageEditation($pageId)->toArray());
        } else{
            $form->setDefaults($this->pages->getPage($pageId)->toArray());
        }
        
        $form->onSuccess[] = array($this, 'formSuceeded');
        return $form;
    }
    
    public function formSuceeded($form, $values){
        $this->pages->savePageEditation($this->pageId, $values, $form->getPresenter()->getUser()->getId());
        $form->getPresenter()->flashMessage('Novinka úspěšně odeslána');
        $form->getPresenter()->redirect('Pages:default');
    }
}
