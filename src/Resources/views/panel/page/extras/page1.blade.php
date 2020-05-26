<-- Dile bağlı olan değişkenler -->
<ul class="nav nav-tabs col-sm-6" id="myTab" role="tablist">
    @foreach( $pageDetails as $pd)
        @if($pd->language)
            <li class="nav-item">
                <a class="nav-link {!! $loop->first ? "active" : "" !!}" id="f{!! $pd->id !!}-tab" data-toggle="tab" href="#f{!! $pd->id !!}" role="tab" aria-controls="{!! $pd->id !!}" aria-selected="{!! $loop->first ? "true" : "" !!}">{!! $pd->language->name !!}</a>
            </li>
        @endif
    @endforeach
</ul>
<div class="tab-content" id="myTabContent">
    @foreach($pageDetails as $pd)
        @if($pd->language)
            <div class="tab-pane fade  {!! $loop->first ? "show active" : "" !!}" id="f{!! $pd->id !!}" role="tabpanel" aria-labelledby="f{!! $pd->id !!}-tab">
                <div class="card col-sm-12">
                    <div class="card-block">
                        <div class="form-group">
                            <input type="checkbox" value="1" class="form-control-user" @if($pd->status == 1) checked @endif /> <label>Extra Data from {!! $pd->language->name !!}</label>
                        </div>
                        <div class="form-group">
                            <label>Test</label>
                            <input type="text" class="form-control" name="detail_extras[{!! $pd->id !!}][isim]" value="{!! $pd->isim !!} " required/>
                        </div>
                        <div class="form-group">
                            <label>Test</label>
                            <input type="text" class="form-control" name="detail_extras[{!! $pd->id !!}][soyisim]" value="{!! $pd->soyisim !!}" required/>
                        </div>
                        <div class="card col-6 float-left">
                            <div class="card-block">
                                <div class="form-group">
                                    <label>Banner Resmi</label>
                                </div>
                                <div id="lfm"></div>
                                <button onclick="window.open('/filemanager');return false;">filemanager</button>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                                    Choose Uploaded Files
                                </button>

                                <div class="form-group">
                                    <label>Banner Picture</label>
                                    <input type="hidden" name="detail_picture" value="{!! $pd->id !!}"/>
                                    <input type="file" class="form-control" name="detail_picture[{!! $pd->id !!}]"/>
                                </div>
                                <div class="form-group">
                                    <label>File Name</label>
                                </div>
                                <input type="hidden" class="form-control" name="detail_picture[{!! $pd->id !!}][file_page_detail]" value="{!! $pd->id !!}"/>
                                <input type="hidden" class="form-control" name="detail_picture[{!! $pd->id !!}][file_key]]" value="aras"/>
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="card col-6 float-left">
                            <div class="card-block">
                                <div class="form-group">
                                    <label>İçerik Resmi</label>
                                </div>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                                    Choose Uploaded Files
                                </button>
                                <div class="form-group">
                                    <label>Banner Picture</label>
                                    <input type="hidden" name="detail_picture" value="{!! $pd->id !!}"/>
                                    <input type="file" class="form-control" name="detail_picture[{!! $pd->id !!}]"/>
                                </div>
                                <div class="form-group">
                                    <label>File Name</label>
                                </div>
                                <input type="hidden" class="form-control" name="detail_picture[{!! $pd->id !!}][file_page_detail]" value="{!! $pd->id ?? '' !!}"/>
                                <input type="hidden" class="form-control" name="detail_picture[{!! $pd->id !!}][file_key]]" value="annen"/>
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        @endif
    @endforeach
</div>
<-- Dile bağlı olmayan değişkenler -->
<div class="card col-sm-12 float-left">
        <div class="card-block">
            <div class="form-group">
                <label>Static Data</label>
            </div>
            <div class="form-group">
                <label>Test Extras</label>
                <input type="text" class="form-control" name="extras[isim]" value="{!! $page->mert !!}" required/>
            </div>
            <div class="form-group">
                <label>Test Extras</label>
                <input type="text" class="form-control" name="extras[soyisim]" value="{!! $page->mert !!}" required/>
            </div>
            <div class="card col-6 float-left">
            <div class="card-block">
                <div class="form-group">
                    <label>{!! $pd->name !!} Files</label>
                </div>

                aras @filePage(aras)

                mert @filePage(mert)

                arasdetail @filePageDetail(aras,3)

                <img src="{!! $pd->getImage('aras') !!}" style="width:100px;"/>
                <div class="form-group">
                    <label>Banner Picture</label>
                    <input type="file" class="form-control" name="picture[aras]"/>
                </div>
                <div class="form-group">
                    <label>File Name</label>
                    <input type="text" class="form-control" name="picture[aras][file_name]" value="" />
                </div>
                <input type="hidden" class="form-control" name="picture[aras][file_key]" value="aras"/>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
        </div>

    </div>




@push('js')

@endpush
