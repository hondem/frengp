<?php

namespace App\AdminModule\Presenters;

use App\AdminModule\Forms\AddFolderFormFactory;
use App\AdminModule\Forms\AddPhotosFormFactory;
use App\AdminModule\Forms\EditFolderFormFactory;
use App\AdminModule\Forms\EditPhotoFormFactory;
use Nette\Neon\Exception;

class GalleryPresenter extends BasePresenter{

    /** @var AddFolderFormFactory @inject */
    public $addFolder;
    
    /** @var AddPhotosFormFactory @inject */
    public $addPhotos;
    
    /** @var EditFolderFormFactory @inject */
    public $editFolder;
    
    /** @var EditPhotoFormFactory @inject */
    public $editPhoto;

    public function renderDefault(){
        $this->template->gallerys = $this->gallery->getGallerys();
    }

    public function renderShowGallery($galleryId){
        $this->template->folders = $this->gallery->getFolders($galleryId);
        $this->template->gallery = $this->gallery->getGallery($galleryId);
    }
    
    public function renderShowFolder($folderId){
        $this->template->folder = $this->gallery->getFolder($folderId);
        $this->template->files = $this->gallery->getFolderContent($folderId);
    }
    
    public function renderEditImage($imageId){
        $this->template->image = $this->gallery->getImage($imageId);
    }
    
    public function actionDeleteFolder($folderId){
        $folder = $this->gallery->getFolder($folderId);
        try{
            $this->gallery->deleteFolder($folderId);
            $this->flashMessage('Složka byla úspěšně smazána.');
            $this->redirect('Gallery:showGallery', array('galleryId' => $folder['galleryId']));
        } catch(Exception $e){
            $this->flashMessage($e->getMessage());
            $this->redirect('Gallery:default');
        }
    }
    
    public function actionDeleteImage($imageId){
        try{
            $image = $this->gallery->getImage($imageId);
            $this->gallery->deleteImage($imageId, $this->context->parameters['wwwDir']);
            $this->flashMessage('Obrázek byl úspěšně smazán.');
            $this->redirect('Gallery:showFolder', array('folderId' => $image->folderId));
        } catch(Nette\Neon\Exception $e){
            $this->flashMessage($e->getMessage());
            $this->redirect('this');
        }
    }

    public function createComponentAddFolderForm(){
        return $this->addFolder->create($this->getParameter('galleryId'));
    }
    
    public function createComponentAddPhotosForm(){
        return $this->addPhotos->create($this->getParameter('folderId'), $this->context->parameters['wwwDir']);
    }
    
    public function createComponentEditFolderForm(){
        return $this->editFolder->create($this->getParameter('folderId'));
    }
    
    public function createComponentEditImageForm(){
        return $this->editPhoto->create($this->getParameter('imageId'));
    }
}