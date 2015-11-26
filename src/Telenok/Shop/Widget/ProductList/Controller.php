<?php namespace Telenok\Shop\Widget\ProductList;

class Controller extends \Telenok\Core\Interfaces\Widget\Controller {

    protected $key = 'product-list';
    protected $parent = 'shop';
	protected $defaultFrontendView = "shop::widget.product-list.widget-frontend";

    protected $perPage = 30;
    protected $categoryIds;
    protected $page = 0;
    protected $ignorePage = false;
    protected $orderBy = 'price';
    protected $shopCategoryUrlPattern;
    protected $closureQuery;

    public function setConfig($config = [])
    {
        parent::setConfig($config);
        
        if ($m = $this->getWidgetModel())
        {
            $structure = $m->structure;

            $this->perPage = array_get($structure, 'per_page', $this->perPage);
            $this->category = array_get($structure, 'category_ids');
            $this->ignorePage = (bool)array_get($structure, 'ignore_page', $this->ignorePage);
            $this->orderBy = array_get($structure, 'order_by', $this->orderBy);
        }
        else 
        {
            $this->perPage = $this->getConfig('per_page', $this->perPage);
            $this->categoryIds = $this->getConfig('category_ids', $this->categoryIds);
            $this->ignorePage = (bool)$this->getConfig('ignore_page', $this->ignorePage);
            $this->orderBy = $this->getConfig('order_by', $this->orderBy);
            $this->closureQuery = $this->getConfig('closure_query', $this->closureQuery);
        }

        $this->page = $this->getRequest()->get('p', $this->page);
        $this->shopCategoryUrlPattern = app('router')->getCurrentRoute()->getParameter('shop_category_url_pattern');
        
        return $this;
    }

    public function getPage()
    {
        return $this->page;
    }

    public function getPerPage()
    {
        return $this->perPage;
    }

    public function getCategoryIds()
    {
        return $this->categoryIds;
    }

    public function getIgnorePage()
    {
        return $this->ignorePage;
    }

    public function getOrderBy()
    {
        return $this->orderBy;
    }

    public function getShopCategoryUrlPattern()
    {
        return $this->shopCategoryUrlPattern;
    }

    public function getCacheKey()
	{
        if ($key = parent::getCacheKey())
        {
            return $key . $this->getCategoryIds() . $this->getPerPage() . $this->getPage() . $this->getIgnorePage();
        }
        else
        {
            return false;
        }
	}

	public function getNotCachedContent()
	{
        $productModel = app('\App\Telenok\Shop\Model\Product');
        
        $query = $productModel->withPermission()->with('productShowInProductCategory');
        
        if ($catIds = $this->getCategoryIds())
        {
            $ids = (array)json_decode('[' . $catIds . ']'); 

            $productCategoryModel = app('\App\Telenok\Shop\Model\ProductCategory');

            $categoryIds = $productCategoryModel->withPermission()
                    ->active()
                    ->whereIn($productCategoryModel->getTable() . '.id', $ids)
                    ->lists('id');

            $query->whereHas('productProductCategory', function($query) use ($categoryIds)
            {
                $query->whereIn('id', $categoryIds);
            });
        }
        else if ($catUrl = $this->getShopCategoryUrlPattern())
        {
            $query->whereHas('productProductCategory', function($query) use ($catUrl)
            {
                $query->where('url_pattern', $catUrl);
            });
        }
        
        if (($orderBy = $this->getOrderBy()) == 'title')
        {
            $query->translateField($query, $productModel->getTable(), 'translate_table', 'title', config('app.locale'));

            $query->orderBy('translate_table.title');
        }
        else if (($cl = $this->closureQuery) instanceof \Closure)
        {
            $cl($query, $this);
        }
        else
        {
            $query->orderBy($productModel->getTable() . '.' . $orderBy);
        }

        $products = $query->skip($this->getPage() * $this->getPerPage())
                    ->take($this->getPerPage())
                    ->get();

        return view($this->getFrontendView(), [
                        'controller' => $this, 
                        'products' => $products,
                    ])->render();
	}
}