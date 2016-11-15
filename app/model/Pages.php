<?php

namespace App\Model;

class Pages extends BaseModel{
    public function getPage($pageId){
        return $this->database->table(DatabaseStructure::PAGES)->where('id', $pageId)->fetch();
    }
    
    public function getPages(){
        $pages = $this->getArrayFromActiveRow($this->database->table(DatabaseStructure::PAGES)->order('date DESC')->fetchAll());
        for($i=0; $i<count($pages); $i++){
            $pages[$i]['editedByName'] = $this->database->table(DatabaseStructure::USERS)->where('id', $pages[$i]['editedBy'])->fetch()['username'];
        }
        return $pages;
    }
    
    public function getPagesForPaginator($length, $offset){
        $pages = $this->getArrayFromActiveRow($this->database->table(DatabaseStructure::PAGES)->order('date DESC')->limit($length, $offset)->fetchAll());
        for($i=0; $i<count($pages); $i++){
            $pages[$i]['editedByName'] = $this->database->table(DatabaseStructure::USERS)->where('id', $pages[$i]['editedBy'])->fetch()['username'];
        }
        return $pages;
    }
    
    public function addPage($values, $userId){
        $this->database->table(DatabaseStructure::PAGES)->insert(array(
            'pageName' => $values->pageName,
            'content' => $values->content,
            'editedBy' => $userId
        ));
    }
    
    public function editPage($pageId, $values){
        $this->database->table(DatabaseStructure::PAGES)->where('id', $pageId)->update(array(
            'pageName' => $values->pageName,
            'content' => $values->content
        ));
    }
    
    public function getPageEditations(){
        $pages = $this->getArrayFromActiveRow($this->database->table(DatabaseStructure::PAGES_EDIT)->order('date DESC')->fetchAll());
        for($i=0; $i<count($pages); $i++){
            $pages[$i]['editedByName'] = $this->database->table(DatabaseStructure::USERS)->where('id', $pages[$i]['editedBy'])->fetch()['username'];
        }
        return $pages;
    }
    
    public function getEditedPage($pageId){
        return $this->database->table(DatabaseStructure::PAGES_EDIT)->where('pageId', $pageId)->fetch();
    }
    
    public function savePageEditation($pageId, $values, $userId){
        if($this->pageEditationExists($pageId)){
            $this->database->table(DatabaseStructure::PAGES_EDIT)->where('pageId', $pageId)->update(array(
                'pageName' => $values->pageName,
                'content' => $values->content,
                'editedBy' => $userId,
                'date' => date('Y-m-d H:i:s')
            ));
        } else{
            $this->database->table(DatabaseStructure::PAGES_EDIT)->insert(array(
                'pageId' => $pageId,
                'pageName' => $values->pageName,
                'content' => $values->content,
                'editedBy' => $userId,
                'date' => date('Y-m-d H:i:s')
            ));
        }
    }
    
    public function getPageEditation($pageId){
        return $this->database->table(DatabaseStructure::PAGES_EDIT)->where('pageId', $pageId)->fetch();
    }
    
    public function pageEditationExists($pageId){
        if($this->database->table(DatabaseStructure::PAGES_EDIT)->where('pageId', $pageId)->fetch()){
            return true;
        } else{
            return false;
        }
    }
    
    public function approveChanges($pageId){
        $newValues = $this->database->table(DatabaseStructure::PAGES_EDIT)->where('pageId', $pageId)->fetch();
        $this->database->table(DatabaseStructure::PAGES)->where('id', $pageId)->update(array(
            'pageName' => $newValues['pageName'],
            'content' => $newValues['content'],
            'editedBy' => $newValues['editedBy'],
            'date' => $newValues['date']
        ));
    }
    
    public function deleteEditation($pageId){
        $this->database->table(DatabaseStructure::PAGES_EDIT)->where('pageId', $pageId)->delete();
    }
}
