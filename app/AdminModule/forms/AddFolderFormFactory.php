<?php
namespace App\AdminModule\Forms;

use Nette;
use Nette\Neon\Exception;

class AddFolderFormFactory extends Nette\Object{
    private $factory;
    public $galleryId;
    public $gallery;

    public function __construct(\App\Forms\FormFactory $formFactory, \App\Model\Gallery $gallery){
        $this->gallery = $gallery;
        $this->factory = $formFactory;
    }

    public function create($galleryId){
        $this->galleryId = $galleryId;
        $form = $this->factory->create();
        $form->addText('folderName', 'Název složky: ')
                ->setRequired();
        $form->addSubmit('send', 'Přidat');
        $form->onSuccess[] = array($this, 'formSucceeded');
        return $form;
    }

    public function formSucceeded($form, $values){
        try{
            $this->gallery->addFolder($this->galleryId, $values['folderName']);
            $form->getPresenter('Úspěšně provedeno.');
            $form->getPresenter()->redirect('this');
        } catch(Exception $e){
            $form->getPresenter()->flashMessage($e->getMessage());
            $form->getPresenter()->redirect('this');
        }
    }
}
