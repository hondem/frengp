<?php

namespace App\Presenters;

use Nette;
use App\Model;
use App\Model\Menu;
use App\Model\Pages;
use App\Model\SubPages;
use App\Model\News;
use App\Model\Sections;
use App\Model\Gallery;


/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{
    /** @var Menu @inject*/
    public $menu;
    
    /** @var Pages @inject*/
    public $pages;
    
    /** @var SubPages @inject*/
    public $subPages;
    
    /** @var News @inject*/
    public $news;
    
    /** @var Sections @inject*/
    public $sections;
    
    /** @var Gallery @inject*/
    public $gallery;
    
    public function startup(){
        parent::startup();
        $this->template->menu = $this->menu->getStructuredMenu();
    }
}
