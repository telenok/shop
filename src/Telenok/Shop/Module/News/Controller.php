<?php namespace Telenok\Shop\Module\Product;

class Controller extends \Telenok\Core\Interfaces\Presentation\TreeTabObject\Controller { 
    
    protected $key = 'product';
    protected $icon = 'fa fa-archive';
    protected $presentation = 'tree-tab-object';
    protected $modelListClass = '\App\Telenok\Shop\Model\Product';
} 