<?php

    $jsUnique = str_random();

    $categoryIds = (array)$model->structure->get('category_ids');

	$categories = ['<option></option>'];

	foreach(\App\Telenok\Shop\Model\ProductCategory::active()->get() as $v)
	{
		$categories[] = "<option value='" . $v->getKey() . "' " . (in_array($v->getKey(), $categoryIds) ? 'selected' : '') . ">" . e($v->translate('title')) . "</option>";
	}
?>

<div class="form-group">
	{!! Form::label('category_ids', $controller->LL('title.category_ids'), array('class' => 'col-sm-3 control-label no-padding-right')) !!}
	<div class="col-sm-9">
		<select id="category_ids_{{$jsUnique}}" multiple name="structure[category_ids][]">
		 {!! implode('', $categories) !!}
		 </select>
		 <script type="text/javascript">
			 jQuery("#category_ids_{{$jsUnique}}").chosen({
				 create_option: true,
				 keepTypingMsg: "{{ $controller->LL('notice.typing') }}",
				 lookingForMsg: "{{ $controller->LL('notice.looking-for') }}",
				 width: '350px',
				 search_contains: true,
                 allow_single_deselect: true,
                 placeholder_text_single: "{{ $controller->LL('title.category_ids') }}"
			 });
		 </script>
	</div>
</div>

<div class="form-group">
	{!! Form::label('per_page', $controller->LL('title.per_page'), array('class' => 'col-sm-3 control-label no-padding-right')) !!}
	<div class="col-sm-9">
        {!!  Form::text("structure[per_page]", (int)$model->structure->get('per_page') ?: $controller->getPerPage(), ['class' => 'form-control']) !!}
	</div>
</div>

<div class="form-group">
	{!! Form::label('structure[ignore_page]', $controller->LL('title.ignore_page'), array('class' => 'col-sm-3 control-label no-padding-right')) !!}
	<div class="col-sm-9">
        <div>
            <div class="btn-group btn-overlap" data-toggle="buttons">
                <label class="btn btn-white btn-sm btn-primary @if ($model->structure->get('ignore_page')==0) active @endif">
                    {!! Form::radio('structure[ignore_page]', 0, $model->structure->get('ignore_page')==1) !!} {{ $controller->LL('btn.no') }}
                </label>
                <label class="btn btn-white btn-sm btn-primary @if ($model->structure->get('ignore_page')==1) active @endif">
                    {!! Form::radio('structure[ignore_page]', 1, $model->structure->get('ignore_page')==1) !!} {{ $controller->LL('btn.yes') }}
                </label>
            </div>
        </div>
    </div>
</div>

<?php

    $orderBy = $model->structure->get('order_by');

	$fields = ['<option></option>'];

	foreach(\App\Telenok\Core\Model\Object\Field::active()
            ->whereIn('code', ['id', 'title', 'sort', 'price', 'active_at'])
            ->where('field_object_type', app('\App\Telenok\Shop\Model\Product')->type()->getKey())
            ->get() as $v)
    {
        $fields[] = "<option value='" . $v->code . "' " . ($v->code == $orderBy ? 'selected' : '') . ">" . e($v->translate('title')) . "</option>";
    }
?>

<div class="form-group">
	{!! Form::label('order_by', $controller->LL('title.order_by'), array('class' => 'col-sm-3 control-label no-padding-right')) !!}
	<div class="col-sm-9">
		<select id="order_by{{$jsUnique}}" name="structure[order_by]">
		 {!! implode('', $fields) !!}
		 </select>
		 <script type="text/javascript">
            jQuery("#order_by{{$jsUnique}}").chosen({
                create_option: true,
                keepTypingMsg: "{{ $controller->LL('notice.typing') }}",
                lookingForMsg: "{{ $controller->LL('notice.looking-for') }}",
                width: '350px',
                search_contains: true,
                allow_single_deselect: true,
                placeholder_text_single: "{{ $controller->LL('title.order_by') }}"
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