<?phpnamespace App\AdminModule\Forms;use Nette;class AddNewsFormFactory extends Nette\Object{    public $news;    public $basePath;    private $factory;            public function __construct(\App\Model\News $news, \App\Forms\FormFactory $formFactory){        $this->news = $news;        $this->factory = $formFactory;    }        public function create($basePath){        $this->basePath = $basePath;        $form = $this->factory->create();        $form->addText('title', 'Titulek: ')                ->setRequired();        $form->addTextArea('content', 'Obsah: ');        $form->addUpload('newsPicture', 'Obrázek novinky: ')                ->addRule(Nette\Forms\Form::MAX_FILE_SIZE, 'Maximální velikost obrázku je 1024kB', 1024 * 1024)                ->addCondition(Nette\Forms\Form::FILLED)                ->addRule(Nette\Forms\Form::IMAGE, 'Soubor musí být obrázek');				$form->addMultiUpload('pictures', 'Ostatní obrázky: ')                ->addRule(Nette\Forms\Form::MAX_FILE_SIZE, 'Maximální velikost obrázku je 1024kB', 1024 * 1024)                ->addCondition(Nette\Forms\Form::FILLED)                ->addRule(Nette\Forms\Form::IMAGE, 'Soubor musí být obrázek');        $form->addCheckbox('important', 'Důležitá zpráva: ');        $form->addSubmit('send', 'Odeslat');                $form->onSuccess[] = array($this, 'formSucceeded');        return $form;    }        public function formSucceeded($form, $values){        $this->news->addNews($values, $form->getPresenter()->getUser()->getId(), $this->basePath);        $form->getPresenter()->flashMessage('Novinka úspěšně přidána', 'succeed');        $form->getPresenter()->redirect('News:default');    }}