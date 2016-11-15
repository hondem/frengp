<?php

namespace App\AdminModule\Presenters;

class MenuPresenter extends BasePresenter{
    public function renderDefault(){
        $this->template->menu = $this->menu->getStructuredMenu();
    }
}