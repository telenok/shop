<?php namespace Telenok\Shop\Widget\ProductCategory;

class Controller extends \App\Telenok\Core\Interfaces\Widget\Controller {

    protected $key = 'product-category';
    protected $parent = 'shop';
	protected $defaultFrontendView = "shop::widget.product-category.widget-frontend";
    protected $shopCategory;
    
    public function setConfig($config = [])
    {
        parent::setConfig($config);

        if ($m = $this->getWidgetModel() && ($structure = $m->structure) && ($searchBy = array_get($structure, 'category_id')))
        {
        }
        else 
        {
            $searchBy = app('router')->getCurrentRoute()->getParameter('shop_category_url_pattern');
        }

        $this->shopCategory = \Cache::remember(
                $this->getCacheKey('shopCategory'), 
                $this->getCacheTime(), 
                function() use ($searchBy)
                {
                    $categoryModel = app('\App\Telenok\Shop\Model\ProductCategory');

                    return $categoryModel::active()
                        ->withPermission()
                        ->where(function($query) use ($categoryModel, $searchBy)
                        {
                            $query->where($categoryModel->getTable() . '.url_pattern', $searchBy);
                            $query->orWhere($categoryModel->getTable() . '.id', $searchBy);
                        })
                        ->active()
                        ->first();
                });

        return $this;
    }

    public function preProcess($model, $type, $input)
    { 
        $structure = $input->get('structure');

        $structure['category_id'] = (int)array_get($structure, 'category_id');

        $input->put('structure', $structure);
        
        return parent::preProcess($model, $type, $input);
    }
    
	public function getNotCachedContent()
	{        
        return view($this->getFrontendView(), [
                    'controller' => $this, 
                    'category' => $this->shopCategory,
                ])->render();
	}

	public function getCacheKey($additional = '')
	{
        if ($key = parent::getCacheKey($additional))
        {
            return $key . ($this->shopCategory ? $this->shopCategory->getKey() : 0);
        }
        else
        {
            return false;
        }
	}
}