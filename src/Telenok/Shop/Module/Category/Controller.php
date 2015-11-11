<?php namespace Telenok\Shop\Module\ProductCategory;

class Controller extends \Telenok\Core\Interfaces\Presentation\TreeTabObject\Controller { 
    
    protected $key = 'product-category';
    protected $icon = 'fa fa-newspaper-o';
    protected $presentation = 'tree-tab-object';
    protected $modelListClass = '\App\Telenok\Shop\Model\ProductCategory';
}