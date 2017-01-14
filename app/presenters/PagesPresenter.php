<?php

namespace App\Presenters;


class PagesPresenter extends BasePresenter{
    public function renderShow($pageId){        $page = $this->pages->getPage($pageId);
        $this->template->page = $this->pages->getPage($pageId);
    }
}