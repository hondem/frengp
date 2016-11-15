<?php
namespace App\AdminModule\Forms;

use Nette;

class EditNewsFormFactory extends Nette\Object{
    public $news;
    public $newsId;
    private $factory;
    
    public function __construct(\App\Model\News $news, \App\Forms\FormFactory $formFactory){
        $this->news = $news;
        $this->factory = $formFactory;
    }
    
    public function create($newsId){
        $this->newsId = $newsId;
        $form = $this->factory->create();
        $form->addText('title', 'Titulek: ')
                ->setRequired();
        $form->addTextArea('content', 'Obsah: ');
        $form->addCheckbox('important', 'Důležitá zpráva: ');
        $form->addSubmit('send', 'Uložit úpravy');
        
        if($this->news->editationExists($newsId)){
            $form->setDefaults($this->news->getNewsEditation($newsId)->toArray());
        } else{
            $form->setDefaults($this->news->getSingleNews($newsId)->toArray());
        }
        
        $form->onSuccess[] = array($this, 'formSucceeded');
        return $form;
    }
    
    public function formSucceeded($form, $values){
        $this->news->saveNewsEditation($this->newsId, $values, $form->getPresenter()->getUser()->getId());
        $form->getPresenter()->flashMessage('Novinka úspěšně upravena', 'succeed');
        $form->getPresenter()->redirect('News:default');
    }
}
