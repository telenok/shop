<?php namespace Telenok\Shop\Module\Category;

class Controller extends \Telenok\Core\Interfaces\Presentation\TreeTabObject\Controller { 
    
    protected $key = 'shop-category';
    protected $icon = 'fa fa-newspaper-o';
    protected $presentation = 'tree-tab-object';
    protected $modelListClass = '\App\Telenok\Shop\Model\Category';
}