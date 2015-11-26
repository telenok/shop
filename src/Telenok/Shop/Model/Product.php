<?php namespace Telenok\Shop\Model;

class Product extends \App\Telenok\Core\Interfaces\Eloquent\Object\Model {

	protected $table = 'product';
    
    public function setUrlPatternAttribute($value)
    {
        $this->attributes['url_pattern'] = preg_replace("![^a-z0-9]+!i", "-", $value);
    }
}