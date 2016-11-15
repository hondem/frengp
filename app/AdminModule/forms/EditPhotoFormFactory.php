<?php

namespace App\AdminModule\Forms;

use Nette;

class EditPhotoFormFactory extends Nette\Object{
    public $imageId;
    public $gallery;
    
    public function __construct(\App\Model\Gallery $gallery){
        $this->gallery = $gallery;
    }
    
    public function create($imageId){
        $this->imageId = $imageId;
        $form = new Nette\Application\UI\Form;
        $form->addText('description', 'Popis:');
        $form->addSubmit('send', 'Uložit');
        $form->setDefaults($this->gallery->getImage($this->imageId)->toArray());
        
        $form->onSuccess[] = array($this, 'formSucceeded');
        return $form;
    }
    
    public function formSucceeded($form, $values){
        try{
            $this->gallery->editImage($this->imageId, $values);
            $form->getPresenter()->flashMessage('Editace proběhla úspěšně');
            $form->getPresenter()->redirect('this');
        } catch(Nette\Neon\Exception $e){
            $form->getPresenter()->flashMessage($e->getMessage(), 'danger');
            $form->getPresenter()->redirect('this');
        }
    }
}
