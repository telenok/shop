
@foreach($products as $product)

    <?php
        $categoryShowIn = $product->productShowInProductCategory->first();
    ?>

    @foreach($product->image()->get() as $image)
        <a href="catalog/{!! $categoryShowIn->url_pattern !!}/product/{!! $product->url_pattern !!}">
            <img src="{!! $image->upload->downloadImageLink(
                    380, 630,
                    \App\Telenok\Core\Field\Upload\File::TODO_RESIZE_PROPORTION) !!}" 
                    alt="{{ $image->translate('title') }}"
            />
        </a>
    @endforeach

    <a href="catalog/{!! $categoryShowIn->url_pattern !!}/product/{!! $product->url_pattern !!}">{{$product->translate('title')}}</a>

@endforeach