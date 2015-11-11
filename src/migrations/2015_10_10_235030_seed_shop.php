<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedShop extends Migration {

	public function up()
	{
        try
        {
            // Off permission validator
            \App\Telenok\Core\Model\System\Setting::where('code', 'app.acl.enabled')
                    ->update(['value' => 0]);
            
            $folderShop = (new \App\Telenok\Core\Model\System\Folder())->storeOrUpdate([
                'title' => ['en' => 'Shop', 'ru' => 'Магазин'],
                'active' => 1,
                'code' => 'shop',
            ])->makeRoot();
            
            $typeProduct = (new \App\Telenok\Core\Model\Object\Type())->storeOrUpdate(
                [
                    'title' => ['ru' => "Товар", 'en' => "Product"], 
                    'title_list' => ['ru' => "Товар", 'en' => "Product"],
                    'code' => 'product',
                    'active' => 1,
                    'class_model' => '\App\Telenok\Shop\Model\Product',
                    'class_controller' => '\App\Telenok\Shop\Module\Product\Controller',
                ]
            );
            
            $typeProduct->makeLastChildOf($folderShop);

            (new \App\Telenok\Core\Model\Object\Field())->storeOrUpdate([
                'title' => ['en' => 'Url', 'ru' => 'Url'],
                'title_list' => ['en' => 'Url', 'ru' => 'Url'],
                'key' => 'string',
                'code' => 'url_pattern',
                'active' => 1,
                'field_object_type' => 'product',
                'field_object_tab' => 'main',
                'multilanguage' => 0,
                'show_in_form' => 1,
                'show_in_list' => 1,
                'allow_search' => 1,
                'allow_create' => 1,
                'allow_update' => 1,
                'field_order' => 6,
                'string_unique' => 1,
            ]);

            (new \App\Telenok\Core\Model\Object\Field())->storeOrUpdate([
                'title' => ['en' => 'Announcement', 'ru' => 'Анонс'],
                'title_list' => ['en' => 'Announcement', 'ru' => 'Анонс'],
                'key' => 'text',
                'code' => 'description_short',
                'active' => 1,
                'field_object_type' => 'product',
                'field_object_tab' => 'main',
                'multilanguage' => 0,
                'show_in_form' => 1,
                'show_in_list' => 1,
                'allow_search' => 1,
                'allow_create' => 1,
                'allow_update' => 1,
                'field_order' => 7,
                'text_rte' => 1,
            ]);

            (new \App\Telenok\Core\Model\Object\Field())->storeOrUpdate([
                'title' => ['en' => 'Description', 'ru' => 'Описание'],
                'title_list' => ['en' => 'Description', 'ru' => 'Описание'],
                'key' => 'text',
                'code' => 'description',
                'active' => 1,
                'field_object_type' => 'product',
                'field_object_tab' => 'main',
                'multilanguage' => 0,
                'show_in_form' => 1,
                'show_in_list' => 1,
                'allow_search' => 1,
                'allow_create' => 1,
                'allow_update' => 1,
                'field_order' => 8,
                'text_rte' => 1,
            ]);

            (new \App\Telenok\Core\Model\Object\Field())->storeOrUpdate([
                'title' => ['en' => 'Pictures', 'ru' => 'Изображения'],
                'title_list' => ['en' => 'Pictures', 'ru' => 'Изображения'],
                'key' => 'file-many-to-many',
                'code' => 'image',
                'active' => 1,
                'field_object_type' => 'product',
                'field_object_tab' => 'main',
                'multilanguage' => 0,
                'show_in_form' => 1,
                'show_in_list' => 1,
                'allow_search' => 0,
                'allow_create' => 1,
                'allow_update' => 1,
                'field_order' => 9,
            ]);

            
            $shopCategory = (new \App\Telenok\Core\Model\Object\Type())->storeOrUpdate(
                [
                    'title' => ['ru' => "Категория товара", 'en' => "Product category"], 
                    'title_list' => ['ru' => "Категория товара", 'en' => "Product category"],
                    'code' => 'shop_category',
                    'active' => 1,
                    'treeable' => 1,
                    'class_model' => '\App\Telenok\Shop\Model\Category',
                    'class_controller' => '\App\Telenok\Shop\Module\Category\Controller',
                ]
            );

            $shopCategory->makeLastChildOf($folderShop);
            
            (new \App\Telenok\Core\Model\Object\Field())->storeOrUpdate([
                'title' => ['en' => 'Url', 'ru' => 'Url'],
                'title_list' => ['en' => 'Url', 'ru' => 'Url'],
                'key' => 'string',
                'code' => 'url_pattern',
                'active' => 1,
                'field_object_type' => 'shop_category',
                'field_object_tab' => 'main',
                'multilanguage' => 0,
                'show_in_form' => 1,
                'show_in_list' => 1,
                'allow_search' => 1,
                'allow_create' => 1,
                'allow_update' => 1,
                'field_order' => 6,
                'string_unique' => 1,
            ]);

            (new \App\Telenok\Core\Model\Object\Field())->storeOrUpdate([
                'title' => ['en' => 'Picture', 'ru' => 'Изображение'],
                'title_list' => ['en' => 'Picture', 'ru' => 'Изображение'],
                'key' => 'upload',
                'code' => 'image',
                'active' => 1,
                'field_object_type' => 'shop_category',
                'field_object_tab' => 'main',
                'multilanguage' => 0,
                'show_in_form' => 1,
                'show_in_list' => 1,
                'allow_search' => 1,
                'allow_create' => 1,
                'allow_update' => 1,
                'field_order' => 8,
            ]);

            (new \App\Telenok\Core\Model\Object\Field())->storeOrUpdate([
                'title' => ['en' => 'Product', 'ru' => 'Товар'],
                'title_list' => ['en' => 'Product', 'ru' => 'Товар'],
                'key' => 'relation-many-to-many',
                'code' => 'product',
                'active' => 1,
                'field_object_type' => 'shop_category',
                'field_object_tab' => 'main',
                'relation_many_to_many_has' => 'product',
                'multilanguage' => 0,
                'show_in_form' => 1,
                'show_in_list' => 0,
                'allow_search' => 1,
                'allow_create' => 1,
                'allow_update' => 1,
                'field_order' => 10,
            ]);
            
            // Widget group
            (new \App\Telenok\Core\Model\Web\WidgetGroup())->storeOrUpdate([
                'title' => ['en' => 'Shop', 'ru' => 'Магазин'],
                'active' => 1,
                'controller_class' => '\App\Telenok\Shop\WidgetGroup\Shop\Controller',
            ]);

            // Widget
            (new \App\Telenok\Core\Model\Web\Widget())->storeOrUpdate([
                'title' => ['en' => 'Category', 'ru' => 'Категория'],
                'active' => 1,
                'controller_class' => '\App\Telenok\Shop\Widget\Category\Controller',
            ]);

            (new \App\Telenok\Core\Model\Web\Widget())->storeOrUpdate([
                'title' => ['en' => 'Product', 'ru' => 'Товар'],
                'active' => 1,
                'controller_class' => '\App\Telenok\Shop\Widget\Product\Controller',
            ]);
        }
        finally
        {
            // On permission validator
            \App\Telenok\Core\Model\System\Setting::where('code', 'app.acl.enabled')
                    ->update(['value' => 1]);
        }
    }
}
