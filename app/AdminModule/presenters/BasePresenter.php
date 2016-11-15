<?php
namespace App\AdminModule\Presenters;

use App\Model\Menu;
use App\Model\News;
use App\Model\Users;
use App\Model\Pages;
use App\Model\SubPages;
use App\Model\Sections;
use App\Model\Gallery;

class BasePresenter extends \Nette\Application\UI\Presenter{

    /** @var Menu @inject*/
    public $menu;

    /** @var News @inject*/
    public $news;

    /** @var Users @inject*/
    public $users;

    /** @var Pages @inject*/
    public $pages;

    /** @var SubPages @inject*/
    public $subPages;
    
    /** @var Sections @inject*/
    public $sections;

    /** @var Gallery @inject*/
    public $gallery;

    public function startup(){
        parent::startup();
        if(!$this->getUser()->isLoggedIn()){
            $this->flashMessage('Musíte být přihlášený/á pro vstup do administrace.', 'warning');
            $this->redirect(':Sign:in');
        }

        $this->template->menuSections = $this->sections->getSections();
    }
}
