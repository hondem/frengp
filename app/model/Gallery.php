<?php
namespace App\Model;

use Nette\Neon\Exception;
use Nette\Utils\Image;

class Gallery extends BaseModel{
    public function getGallerys(){
        return $this->database->table(DatabaseStructure::GALLERY)->fetchAll();
    }

    public function getGallery($galleryId){
        return $this->database->table(DatabaseStructure::GALLERY)->where('id', $galleryId)->fetch();
    }

    public function getFolders($galleryId){
        return $this->database->table(DatabaseStructure::GALLERY_FOLDERS)->where('galleryId', $galleryId)->fetchAll();
    }
    
    public function getFoldersForView($galleryId){
        $folders = $this->getArrayFromActiveRow($this->database->table(DatabaseStructure::GALLERY_FOLDERS)->where('galleryId', $galleryId)->fetchAll());
        for($i = 0; $i < count($folders); $i++){
            $folders[$i]['thumb'] = $this->getFirstImageOfFolder($folders[$i]['id']);
        }
        return $folders;
    }

    public function getFolder($folderId){
        return $this->database->table(DatabaseStructure::GALLERY_FOLDERS)->where('id', $folderId)->fetch();
    }
    
    public function getFolderContent($folderId){
        return $this->database->table(DatabaseStructure::GALLERY_PHOTOS)->where('folderId', $folderId)->order('id DESC')->fetchAll();
    }
    
    public function addFolder($galleryId, $folderName){
        if(!$this->folderExists($folderName)){
            $this->database->table(DatabaseStructure::GALLERY_FOLDERS)->insert(array(
                'galleryId' => $galleryId,
                'name' => $folderName
            ));
        } else{
            throw new Exception('Složka s tímto názvem již existuje.');
        }
    }

    public function editFolder($folderId, $values){
        if($this->folderIdExists($folderId)){
            $this->database->table(DatabaseStructure::GALLERY_FOLDERS)->where('id', $folderId)->update(array(
                'name' => $values['name']
            ));
        } else{
            throw new Exception('Tato složka neexistuje.');
        }
    }

    public function deleteFolder($folderId){
        if($this->folderIdExists($folderId)){
            $this->database->table(DatabaseStructure::GALLERY_FOLDERS)->where('id', $folderId)->delete();
        } else{
            throw new Exception('Tato složka neexistuje');
        }
    }

    public function folderExists($folderName){
        if($this->database->table(DatabaseStructure::GALLERY_FOLDERS)->where('name', $folderName)->fetch()){
            return true;
        } else{
            return false;
        }
    }

    public function folderIdExists($folderId){
        if($this->database->table(DatabaseStructure::GALLERY_FOLDERS)->where('id', $folderId)->fetch()){
            return true;
        } else{
            return false;
        }
    }

    public function addImage($image, $basePath, $folderId){
        if($image->getSize() != null){
            $ending = pathinfo($image->getName(), PATHINFO_EXTENSION);
            $stockFileName = pathinfo($image->getName(), PATHINFO_FILENAME);
            $fileName = $stockFileName . \Nette\Utils\Strings::random() . '.' . $ending;
            $urlWithoutBasePath = '/images/upload/gallery/' . $fileName;
            $fileUrl = $basePath . '/images/upload/gallery/' . $fileName;
            $image->move($fileUrl);
            
            $thumbImage = Image::fromFile($fileUrl);
            
            if($thumbImage->getWidth() < $thumbImage->getHeight()){
                $thumbImage->resize(340, NULL);
            } else{
                $thumbImage->resize(NULL, 340);
            }
            
            $thumbImage->sharpen();
            $thumbImageUrl = '/images/upload/gallery/thumbs/' . $fileName;
            $thumbImageFileUrl = $basePath . '/images/upload/gallery/thumbs/' . $fileName;
            $thumbImage->save($thumbImageFileUrl);
            
            $this->database->table(DatabaseStructure::GALLERY_PHOTOS)->insert(array(
                'folderId' => $folderId,
                'url' => $urlWithoutBasePath,
                'thumbUrl' => $thumbImageUrl
            ));
        } else{
            throw new Exception('Nahrávání obrázku selhalo.');
        }
    }

    public function editImage($imageId, $values){
        if($this->imageExists($imageId)){
            $this->database->table(DatabaseStructure::GALLERY_PHOTOS)->where('id', $imageId)->update(array(
                'description' => $values['description']
            ));
        } else{
            throw new Exception('Obrázek neexistuje');
        }
    }
    
    public function deleteImage($imageId, $basePath){
        if($this->imageExists($imageId)){
            $image = $this->database->table(DatabaseStructure::GALLERY_PHOTOS)->where('id', $imageId)->fetch();
            unlink($basePath . $image['url']);
            unlink($basePath . $image['thumbUrl']);
            $this->database->table(DatabaseStructure::GALLERY_PHOTOS)->where('id', $imageId)->delete();
        } else{
            throw new Exception('Obrázek neexistuje.');
        }
    }
    
    public function getImage($imageId){
        return $this->database->table(DatabaseStructure::GALLERY_PHOTOS)->where('id', $imageId)->fetch();
    }
    
    public function imageExists($imageId){
        if($this->database->table(DatabaseStructure::GALLERY_PHOTOS)->where('id', $imageId)->fetch()){
            return true;
        } else{
            return false;
        }
    }
    
    public function getFirstImageOfFolder($folderId){
        return $this->database->table(DatabaseStructure::GALLERY_PHOTOS)->where('folderId', $folderId)->limit(1)->fetch();
    }
}
