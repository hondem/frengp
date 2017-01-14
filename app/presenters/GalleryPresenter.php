<?phpnamespace App\Presenters;class GalleryPresenter extends BasePresenter{    public function renderShowGallery($galleryId){        $this->template->folders = $this->gallery->getFoldersForView($galleryId);        $gallery = $this->gallery->getGallery($galleryId);        $this->template->gallery = $gallery;        $this->template->mDescription = "Náhled galérie " . $gallery['name'];    }    public function renderShowFolder($folderId){        $folder = $this->gallery->getFolder($folderId);        $this->template->folder = $folder;        $this->template->images = $this->gallery->getFolderContent($folderId);                $this->template->mDescription = "Náhled složky v galérii " . $folder['name'];    }}