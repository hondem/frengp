<?phpnamespace App\Model;class SubPages extends BaseModel{    public function getPage($subpageId){        return $this->database->table(DatabaseStructure::SUBPAGES)->where('id', $subpageId)->fetch();    }        public function getPages(){        $pages = $this->getArrayFromActiveRow($this->database->table(DatabaseStructure::SUBPAGES)->order('date DESC')->fetchAll());        for($i=0; $i<count($pages); $i++){            $pages[$i]['editedByName'] = $this->database->table(DatabaseStructure::USERS)->where('id', $pages[$i]['editedBy'])->fetch()['username'];        }        return $pages;    }        public function getPagesForPaginator($length, $offset){        $pages = $this->getArrayFromActiveRow($this->database->table(DatabaseStructure::SUBPAGES)->order('date DESC')->limit($length, $offset)->fetchAll());        for($i=0; $i<count($pages); $i++){            $pages[$i]['editedByName'] = $this->database->table(DatabaseStructure::USERS)->where('id', $pages[$i]['editedBy'])->fetch()['username'];        }        return $pages;    }        public function addPage($values, $userId){        $this->database->table(DatabaseStructure::SUBPAGES)->insert(array(            'subpageName' => $values->subpageName,            'content' => $values->content,            'editedBy' => $userId        ));    }        public function editPage($subpageId, $values){        $this->database->table(DatabaseStructure::SUBPAGES)->where('id', $subpageId)->update(array(            'subpageName' => $values->pageName,            'content' => $values->content        ));    }        public function getPageEditations(){        $pages = $this->getArrayFromActiveRow($this->database->table(DatabaseStructure::SUBPAGES_EDIT)->order('date DESC')->fetchAll());        for($i=0; $i<count($pages); $i++){            $pages[$i]['editedByName'] = $this->database->table(DatabaseStructure::USERS)->where('id', $pages[$i]['editedBy'])->fetch()['username'];        }        return $pages;    }        public function getEditedPage($subpageId){        return $this->database->table(DatabaseStructure::SUBPAGES_EDIT)->where('subpageId', $subpageId)->fetch();    }        public function savePageEditation($subpageId, $values, $userId){        if($this->pageEditationExists($subpageId)){            $this->database->table(DatabaseStructure::SUBPAGES_EDIT)->where('subpageId', $subpageId)->update(array(                'subpageName' => $values->subpageName,                'content' => $values->content,                'editedBy' => $userId,                'date' => date('Y-m-d H:i:s')            ));        } else{            $this->database->table(DatabaseStructure::SUBPAGES_EDIT)->insert(array(                'subpageId' => $subpageId,                'subpageName' => $values->subpageName,                'content' => $values->content,                'editedBy' => $userId,                'date' => date('Y-m-d H:i:s')            ));        }    }        public function getPageEditation($subpageId){        return $this->database->table(DatabaseStructure::SUBPAGES_EDIT)->where('subpageId', $subpageId)->fetch();    }        public function pageEditationExists($subpageId){        if($this->database->table(DatabaseStructure::SUBPAGES_EDIT)->where('subpageId', $subpageId)->fetch()){            return true;        } else{            return false;        }    }        public function approveChanges($subpageId){        $newValues = $this->database->table(DatabaseStructure::SUBPAGES_EDIT)->where('subpageId', $subpageId)->fetch();        $this->database->table(DatabaseStructure::SUBPAGES)->where('id', $subpageId)->update(array(            'subpageName' => $newValues['subpageName'],            'content' => $newValues['content'],            'editedBy' => $newValues['editedBy'],            'date' => $newValues['date']        ));    }        public function deleteEditation($subpageId){        $this->database->table(DatabaseStructure::SUBPAGES_EDIT)->where('subpageId', $subpageId)->delete();    }        public function getSearchResults($searchQuerry){        $words = explode(' ', $searchQuerry);        $results = [];        foreach($words as $row){            $data = $this->getWordResults($row);            foreach($data as $row){                if(!array_key_exists($row['id'], $results)){                    $results[$row['id']] = $row;                }            }        }                $data = [];        foreach($results as $row){            $data[] = $row;        }                for($i=0; $i < count($data); $i++){            $data[$i]['editedByName'] = $this->database->table(DatabaseStructure::USERS)->where('id', $data[$i]['editedBy'])->fetch()['username'];        }                return $data;    }    public function getWordResults($word){        $results = $this->database->query('SELECT * FROM ' . DatabaseStructure::SUBPAGES . ' WHERE subpageName LIKE "%' . $word . '%"')->fetchAll();        return $results;    }}