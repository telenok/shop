<?php

\Event::listen('telenok.repository.package', function($list)
{
    $list->push('Telenok\Shop\PackageInfo');
});
