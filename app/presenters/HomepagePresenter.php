<?phpnamespace App\Presenters;class HomepagePresenter extends BasePresenter{    public function renderDefault($page = 1){        $paginator = new \Nette\Utils\Paginator();        $paginator->setItemCount(count($this->news->getUnPinnedNews()));        $paginator->setItemsPerPage(5);        $paginator->setPage($page);        $this->template->paginator = $paginator;        $this->template->pinnedNews = $this->news->getPinnedNews();        $this->template->unPinnedNews = $this->news->getUnPinnedNewsForPaginator($paginator->getLength(), $paginator->getOffset());        $this->template->mDescription = "Staňte se studenty Gymnázia a Střední průmyslové školy elektrotechniky a informatiky ve Frenštátě pod Radhoštěm.";    }    public function renderShowNews($newsId){        $news = $this->news->getSingleNews($newsId);        $this->template->news = $news;        $this->template->pictures = $this->news->getAdditionalImages($newsId);    }}