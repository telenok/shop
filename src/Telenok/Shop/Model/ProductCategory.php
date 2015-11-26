<?php namespace Telenok\Shop\Model;

class ProductCategory extends \App\Telenok\Core\Interfaces\Eloquent\Object\Model {

	protected $table = 'product_category';
    
    public function setUrlPatternAttribute($value)
    {
        $this->attributes['url_pattern'] = preg_replace("![^a-z0-9]+!i", "-", $value);
    }
}