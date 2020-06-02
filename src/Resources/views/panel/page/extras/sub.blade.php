<ul class="nav nav-tabs col-sm-6 hide" id="myTab" role="tablist">
    @foreach( $pageDetails as $pd)
        @if($pd->language)
            <li class="nav-item">
                <a class="nav-link {!! $loop->first ? "active" : "" !!}" id="f{!! $pd->id !!}-tab" data-toggle="tab" href="#f{!! $pd->id !!}" role="tab" aria-controls="{!! $pd->id !!}" aria-selected="{!! $loop->first ? "true" : "" !!}">{!! $pd->language->name !!}</a>
            </li>
        @endif
    @endforeach
</ul>
<div class="tab-content" id="myTabContent2">
    @foreach($pageDetails as $pd)
        @if($pd->language)
            <div class="tab-pane fade  {!! $loop->first ? "show active" : "" !!}" id="f{!! $pd->id !!}" role="tabpanel" aria-labelledby="f{!! $pd->id !!}-tab">
                <div class="card col-sm-12">
                    <div class="card-block">
                        <div class="form-group">
                            <label>isim</label>
                            @textDetailExtra(isim)
                        </div>
                        <div class="form-group">
                            <label>soyisim</label>
                            @textDetailExtra(soyisim)
                        </div>
                        <div class="form-group">
                            <label>kekeresim</label><br/>
                            @filePageDetail(kekeresim)
                        </div>
                        <div class="form-group">
                            <label>tarrrih</label>
                            <input type="date" class="form-control" name="detail_extras[{!! $pd->id !!}][tarrrih]" value="{!! $pd->tarrrih !!}">
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
</div>
<div class="form-group">
    <label>dilsiz extra </label>
    @textExtra(dilsiz_extra_2)
</div>

<div class="form-group page-order">
    <label>{!! trans('cms::panel.order') !!}</label>
    @order()
</div>
<div class="form-group page-status col-sm-7 float-left">
    <label>{!! trans('cms::panel.categories') !!}</label>
    @category
</div>
@push('js')

@endpush
