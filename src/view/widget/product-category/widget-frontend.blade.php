<?php

$controller->setCacheEnabled(false);

$controllerRequest->setPageMetaTitle($category->translate('title'));

?>


<?php echo \Cache::remember(
        $controller->getCacheKey('content'), 
        $controller->getCacheTime(), 
        function() use ($category) { ?>

@if ($category)
    {{ $category->translate('title') }}
@endif

<?php }); ?>