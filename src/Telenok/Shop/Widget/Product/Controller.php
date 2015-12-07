<?php namespace Telenok\Shop\Widget\Product;

class Controller extends \App\Telenok\Core\Interfaces\Widget\Controller {

    protected $key = 'shop';
    protected $parent = 'shop';
	protected $defaultFrontendView = "shop::widget.shop.widget-frontend";
	protected $shopProductUrlPattern;
	protected $shopProductUrlId; 

    public function setConfig($config = [])
    {
        parent::setConfig($config);

        if (($m = $this->getWidgetModel()) 
                && ($structure = $m->structure) 
                && ($this->shopProductUrlId = array_get($structure, 'product_id'))) {}
        else 
        {
            $this->shopProductUrlId = app('router')->getCurrentRoute()->getParameter('product_id');
            $this->shopProductUrlPattern = app('router')->getCurrentRoute()->getParameter('shop_product_url_pattern');
        }

        return $this;
    }

    public function preProcess($model, $type, $input)
    { 
        $structure = $input->get('structure');

        $structure['product_id'] = (int)array_get($structure, 'product_id');

        $input->put('structure', $structure);

        return parent::preProcess($model, $type, $input);
    }
    
	public function getNotCachedContent()
	{
        $product = \Cache::remember(
            $this->getCacheKey('shopProduct'), 
            $this->getCacheTime(), 
            function()
            {   
                $model = app('\App\Telenok\Shop\Model\Product');

                return $model
                    ->active()
                    ->with('productShowInProductCategory')
                    ->withPermission()
                    ->where(function($query) use ($model)
                    {
                        $query->where($model->getTable() . '.url_pattern', $this->shopProductUrlPattern);
                        $query->orWhere($model->getTable() . '.id', $this->shopProductUrlId);
                    })
                    ->first();
            });

        return view($this->getFrontendView(), [
                'controller' => $this, 
                'product' => $product,
            ])->render();
	}

	public function getCacheKey($additional = '')
	{
        if ($key = parent::getCacheKey($additional))
        {
            return $key . ($this->shopProductUrlId ?: 0);
        }
        else
        {
            return false;
        }
	}
}