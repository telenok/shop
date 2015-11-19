<?php namespace Telenok\Shop\Widget\ProductCategory;

class Controller extends \Telenok\Core\Interfaces\Widget\Controller {

    protected $key = 'product-category';
    protected $parent = 'shop';
	protected $defaultFrontendView = "shop::widget.product-category.widget-frontend";
    protected $shopCategoryUrlPattern;
    
    public function setConfig($config = [])
    {
        parent::setConfig($config);
        
        $this->shopCategoryUrlPattern = app('router')->getCurrentRoute()->getParameter('shop_category_url_pattern');

        return $this;
    }

    public function getShopCategoryUrlPattern()
    {
        return $this->shopCategoryUrlPattern;
    }
    
	public function getNotCachedContent()
	{
        $category = \App\Telenok\Shop\Model\ProductCategory::withPermission()->where(function($query)
        {
            $query->where('url_pattern', $this->getShopCategoryUrlPattern());
        })
        ->active()
        ->first();

        return view($this->getFrontendView(), [
                    'controller' => $this, 
                    'frontendController' => $this->getFrontendController(),
                    'category' => $category,
                ])->render();
	}
    
	public function getCacheKey()
	{
        if ($key = parent::getCacheKey())
        {
            return $key . $this->getShopCategoryUrlPattern();
        }
        else
        {
            return false;
        }
	}
}