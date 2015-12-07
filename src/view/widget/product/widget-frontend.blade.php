<?php

$controller->setCacheEnabled(false);

$controllerRequest->setPageMetaTitle($product->translate('title_ceo'));
$controllerRequest->setPageMetaDescription($product->translate('description_ceo'));
$controllerRequest->setPageMetaKeywords($product->translate('keywords_ceo'));

?>


<?php echo \Cache::remember(
        $controller->getCacheKey('content'), 
        $controller->getCacheTime(), 
        function() use ($product) { ?>

{{$product->translate('title')}}
{!! $product->translate('description') !!}

<?php }); ?>