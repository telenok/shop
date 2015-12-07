
<?php

    $jsUnique = str_random();

    $newsId = $model->structure->get('product_id');

	$news = ['<option></option>'];

	foreach(\App\Telenok\Shop\Model\Product::active()->take(100)->orderBy('id', 'desc')->get() as $v)
	{
		$news[] = "<option value='" . $v->getKey() . "' " . ($v->getKey() == $newsId ? 'selected' : '') . ">" . e($v->translate('title')) . "</option>";
	}
?>

<div class="form-group">
	{!! Form::label('product_id', $controller->LL('title.product_id'), array('class' => 'col-sm-3 control-label no-padding-right')) !!}
	<div class="col-sm-9">
		<select id="product_id_{{$jsUnique}}" name="structure[product_id]">
		 {!! implode('', $news) !!}
		 </select>
		 <script type="text/javascript">

            jQuery("#product_id_{{$jsUnique}}").ajaxChosen(
                {
                    keepTypingMsg: "{{$controller->LL('notice.typing')}}",
                    lookingForMsg: "{{$controller->LL('notice.looking-for')}}",
                    type: "GET",
                    url: "{!! route("telenok.module.objects-lists.list.json", ['treeId' => app('\App\Telenok\Shop\Model\Product')->type()->getKey()]) !!}",
                    dataType: "json",
                    minTermLength: 1,
                    afterTypeDelay: 1000
                },
                function (data)
                {
                    var results = [];
                        jQuery.each(data, function (i, val) {
                            results.push({ value: val.id, text: val.title });
                        });
                    return results;
                },
                {
                    width: "200px",
                    no_results_text: "{{$controller->LL('notice.not-found')}}",
                    allow_single_deselect: true
                });
		 </script>
	</div>
</div>

<div class="widget-box transparent">
	<div class="widget-header widget-header-small">
		<h4 class="row">
			<span class="col-sm-12">
				<i class="ace-icon fa fa-list-ul"></i>
				{{ $controller->LL('title.view') }}
			</span>
		</h4>
	</div>
	<div class="widget-body"> 
		<div class="widget-main form-group field-list">
            
            <div class="form-group">
                <div class="col-sm-12"> 
                    {!!  Form::textarea("template_content", $controller->getTemplateContent(), ['class' => 'form-control']) !!}
                </div>
            </div>
		</div>
	</div>
</div>