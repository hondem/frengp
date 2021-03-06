<?php
namespace App;

use Nette;
use Nette\Application\Routers\RouteList;
use Nette\Application\Routers\Route;

class RouterFactory
{
        /**
         * @return Nette\Application\IRouter
         */
        public static function createRouter()

        {
                Route::$defaultFlags = Route::SECURED;
                $router = new RouteList;
                $router[] = new Route('admin/', 'Admin:Homepage:default');
                $router[] = new Route('novinka/<newsId>', 'Homepage:showNews');
                $router[] = new Route('stranka/<pageId>', 'Pages:show');
                $router[] = new Route('podstranka/<subpageId>', 'SubPages:show');
                $router[] = new Route('galerie/<galleryId>', 'Gallery:showGallery');
                $router[] = new Route('galerie/slozka/<folderId>', 'Gallery:showFolder');
                $router[] = new Route('rubrika/<sectionId>', 'Sections:show');
                $router[] = new Route('mapa/', 'SiteStructure:default');
                $router[] = new Route('<presenter>/<action>[/<id>]', 'Homepage:default');
                return $router;
        }
}
