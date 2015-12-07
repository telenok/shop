<?php namespace Telenok\Shop\Widget\Product;

class Controller extends \App\Telenok\Core\Interfaces\Widget\Controller {

    protected $key = 'product';
    protected $parent = 'shop';
	protected $defaultFrontendView = "shop::widget.product.widget-frontend";
	protected $shopProductUrlPattern;

    public function setConfig($config = [])
    {
        parent::setConfig($config);

        $this->shopProductUrlPattern = app('router')->getCurrentRoute()->getParameter('shop_product_url_pattern');

        return $this;
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
                            ->where($model->getTable() . '.url_pattern', $this->shopProductUrlPattern)
                            ->first();
                    });

        return view($this->getFrontendView(), [
                        'controller' => $this, 
                        'product' => $product,
                    ])->render();
	}
}