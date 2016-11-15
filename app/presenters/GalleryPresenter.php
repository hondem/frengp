<?php

namespace App\Presenters;

class GalleryPresenter extends BasePresenter{
    public function renderShowGallery($galleryId){
        $this->template->folders = $this->gallery->getFoldersForView($galleryId);
        $this->template->gallery = $this->gallery->getGallery($galleryId);
    }
    
    public function renderShowFolder($folderId){
        $this->template->folder = $this->gallery->getFolder($folderId);
        $this->template->images = $this->gallery->getFolderContent($folderId);
    }
}
