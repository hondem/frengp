<?php

namespace App\AdminModule\Presenters;

use App\AdminModule\Forms\AddPageFormFactory;
use App\AdminModule\Forms\EditPageFormFactory;

class PagesPresenter extends BasePresenter{
    /** @var AddPageFormFactory @inject */
    public $addPageFormFactory;
    
    /** @var EditPageFormFactory @inject */
    public $editPageFormFactory;
    
    public function renderDefault($page = 1){
        $paginator = new \Nette\Utils\Paginator();
        $paginator->setItemCount(count($this->pages->getPages()));
        $paginator->setItemsPerPage(15);
        $paginator->setPage($page);
        
        $this->template->paginator = $paginator;
        $this->template->pages = $this->pages->getPagesForPaginator($paginator->getLength(), $paginator->getOffset());
        $this->template->editedPages = $this->pages->getPageEditations();
    }
    
    public function renderEditPage($pageId){
        if($this->pages->pageEditationExists($pageId)){
            $this->flashMessage('Upravujete úpravu stránky, která čeká na zveřejnění.', 'warning');
        }
    }
    
    public function renderEditedPage($pageId){
        $this->template->page = $this->pages->getEditedPage($pageId);
    }
    
    public function actionApproveChanges($pageId){
        $this->pages->approveChanges($pageId);
        $this->pages->deleteEditation($pageId);
        $this->flashMessage('Úpravy úspěšně schváleny.');
        $this->redirect('Pages:default');
    }
    
    public function createComponentAddPageForm(){
        return $this->addPageFormFactory->create();
    }
    
    public function createComponentEditPageForm(){
        return $this->editPageFormFactory->create($this->getParameter('pageId'));
    }
}
