<?php
namespace App\AdminModule\Forms;

use Nette;
use Nette\Neon\Exception;

class EditFolderFormFactory extends Nette\Object{
    private $factory;
    public $folderId;
    public $gallery;

    public function __construct(\App\Forms\FormFactory $formFactory, \App\Model\Gallery $gallery){
        $this->gallery = $gallery;
        $this->factory = $formFactory;
    }

    public function create($folderId){
        $this->folderId = $folderId;
        $form = $this->factory->create();
        $form->addText('name', 'Název složky: ')
                ->setRequired();
        $form->addSubmit('send', 'Přidat');
        $form->setDefaults($this->gallery->getFolder($folderId)->toArray());
        $form->onSuccess[] = array($this, 'formSucceeded');
        return $form;
    }

    public function formSucceeded($form, $values){
        try{
            $this->gallery->editFolder($this->folderId, $values);
            $form->getPresenter('Úspěšně provedeno.');
            $form->getPresenter()->redirect('this');
        } catch(Exception $e){
            $form->getPresenter()->flashMessage($e->getMessage());
            $form->getPresenter()->redirect('this');
        }
    }
}
