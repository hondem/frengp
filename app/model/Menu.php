<?php

namespace App\Model;

class Menu extends BaseModel{
    public function getMenu(){
        return $this->database->table(DatabaseStructure::MENU)->fetchAll();
    }
    
    public function getStructuredMenu(){
        $menu = $this->getArrayFromActiveRow($this->database->table(DatabaseStructure::MENU)->where('subMenuId', 0)->fetchAll());
        for($i = 0; $i < count($menu); $i++){
            $menu[$i]['subMenu'] = $this->getArrayFromActiveRow($this->database->table(DatabaseStructure::MENU)->where('subMenuId', $menu[$i]['id'])->fetchAll());
            
            $explodedLink = explode(" ", $menu[$i]['link']);
            $menu[$i]['presenter'] = $explodedLink[0];
            if(isset($explodedLink[1])){
                $menu[$i]['params'] = $explodedLink[1];
            } else{
                $menu[$i]['params'] = '';
            }
            
            for($y = 0; $y < count($menu[$i]['subMenu']); $y++){
                $explodedLink = explode(" ", $menu[$i]['subMenu'][$y]['link']);
                $menu[$i]['subMenu'][$y]['presenter'] = $explodedLink[0];
                if(isset($explodedLink[1])){
                    $menu[$i]['subMenu'][$y]['params'] = $explodedLink[1];
                } else{
                    $menu[$i]['subMenu'][$y]['params'] = '';
                }
            }
        }
        
        return $menu;
    }
    
    public function deleteMenu($menuId){
        $this->database->table(DatabaseStructure::MENU)->where('id', $menuId)->delete();
    }
}