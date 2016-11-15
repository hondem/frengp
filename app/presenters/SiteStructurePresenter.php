<?php

namespace App\Presenters;


class SiteStructurePresenter extends BasePresenter{
    public function renderDefault(){
        $this->template->menu = $this->menu->getStructuredMenu();
    }
}
