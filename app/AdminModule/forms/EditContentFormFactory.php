<?php
namespace App\AdminModule\Forms;

use Nette;

class EditContentFormFactory extends Nette\Object{
    public $sections;
    public $contentId;
    private $factory;
    
    public function __construct(\App\Model\Sections $sections, \App\Forms\FormFactory $formFactory){
        $this->sections = $sections;
        $this->factory = $formFactory;
    }
    
    public function create($contentId){
        $this->contentId = $contentId;
        $form = $this->factory->create();
        $form->addText('title', 'Titulek: ')
                ->setRequired();
        $form->addTextArea('content', 'Obsah: ');
        $form->addSubmit('send', 'Uložit úpravy');
        $form->setDefaults($this->sections->getContent($this->contentId)->toArray());
        $form->onSuccess[] = array($this, 'formSucceeded');
        return $form;
    }
    
    public function formSucceeded($form, $values){
        $this->sections->editContent($values, $this->contentId);
        $form->getPresenter()->flashMessage('Příspěvek úspěšně upraven', 'succeed');
        $form->getPresenter()->redirect('Sections:default');
    }
}
