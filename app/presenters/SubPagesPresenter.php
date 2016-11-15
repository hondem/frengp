<?php

namespace App\Presenters;


class SubPagesPresenter extends BasePresenter{
    public function renderShow($subpageId){
        $this->template->page = $this->subPages->getPage($subpageId);
    }
}
