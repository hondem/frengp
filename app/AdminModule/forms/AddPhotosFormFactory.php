<?php

namespace App\AdminModule\Forms;

use Nette;

class AddPhotosFormFactory extends Nette\Object{
    public $folderId;
    public $basePath;
    public $gallery;
    
    public function __construct(\App\Model\Gallery $gallery){
        $this->gallery = $gallery;
    }
    
    public function create($folderId, $basePath){
        $this->basePath = $basePath;
        $this->folderId = $folderId;
        $form = new Nette\Application\UI\Form;
        $form->addMultiUpload('files', 'Obrázky: ')
                ->setRequired();
        $form->addSubmit('send', 'Nahrát');
        
        $form->onSuccess[] = array($this, 'formSucceeded');
        return $form;
    }
    
    public function formSucceeded($form, $values){
        try{
            for($i=0; $i<count($values['files']); $i++){
                $this->gallery->addImage($values['files'][$i], $this->basePath, $this->folderId);
            }
            $form->getPresenter()->flashMessage('Nahrání obrázků bylo úspěšné.');
            $form->getPresenter()->redirect('this');
        } catch(\Nette\Neon\Exception $e){
            $form->getPresenter()->flashMessage($e->getMessage());
            $form->getPresenter()->redirect('this');
        }
    }
}
