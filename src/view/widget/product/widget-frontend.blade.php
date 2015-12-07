<?php

$controller->setCacheEnabled(false);

$controllerRequest->setPageMetaTitle($product->translate('title'));

?>


<?php echo \Cache::remember(
        $controller->getCacheKey('content'), 
        $controller->getCacheTime(), 
        function() use ($product) { ?>

{{$product->translate('title')}}
{!! $product->translate('description') !!}

<?php }); ?>