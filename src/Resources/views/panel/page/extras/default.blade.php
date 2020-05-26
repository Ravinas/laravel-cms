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
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                                    Choose Uploaded Files
                                </button>
                                @if(isset($pd->getImage('banner')->path))
                                <img src="{!! asset("/storage/".$pd->getImage('banner')->path) !!}" style="width:100px;height: 100px;"/>
                                @endif
                                <div class="form-group">
                                    <label>Banner Picture</label>
                                    <input type="hidden" name="detail_picture" value="{!! $pd->id !!}"/>
                                    <input type="file" class="form-control" name="detail_picture[{!! $pd->id !!}]"/>
                                </div>
                                <div class="form-group">
                                    <label>File Name</label>
                                    <input type="text" class="form-control" name="detail_picture[{!! $pd->id !!}][file_name]" value="{!! $pd->getImage('banner')->name ?? '' !!}" />
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
                                @if(isset($pd->getImage('banner')->path))
                                <img src="{!! asset("/storage/".$pd->getImage('banner')->path) !!}" style="width:100px;height: 100px;"/>
                                @endif
                                <div class="form-group">
                                    <label>Banner Picture</label>
                                    <input type="hidden" name="detail_picture" value="{!! $pd->id !!}"/>
                                    <input type="file" class="form-control" name="detail_picture[{!! $pd->id !!}]"/>
                                </div>
                                <div class="form-group">
                                    <label>File Name</label>
                                    <input type="text" class="form-control" name="detail_picture[{!! $pd->id !!}][file_name]" value="{!! $pd->getImage('banner')->name ?? '' !!}" />
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
            <div class="modal" tabindex="-1" id="exampleModalCenter" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Sunucudaki Resimler</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @if($files)
                                @foreach($files as $file)
                                    <div class="form-group float-left">
                                        <input type="radio" class="ajax_image" key="aras" page_detail_id="{!! $pd->id !!}" aria-label="Radio button for following text input" id="{!! $file->id !!}" name="file_id" value="{!! $file->id !!}">
                                        <label  for="{!! $file->id !!}"></label>
                                        @if(isset($pd->getImage('banner')->path))
                                         <img src="{!! asset("/storage/".$pd->getImage('banner')->path) !!}" style="width:100px;height: 100px;"/>
                                        @endif
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary ajax_post">Save changes</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#nolang">
                    Choose Uploaded Files
                </button>
                <img src="{!! asset($pd->getImage('banner')) !!}" style="width:100px;height: 100px;"/>
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
<div class="modal" tabindex="-1" id="nolang" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Sunucudaki Resimler</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if($files)
                    @foreach($files as $file)
                        <div class="form-group float-left">
                            <input type="radio" class="ajax_image_anan" key="aras" page_id="{!! $page->id !!}"  name="file_i" value="{!! $file->id !!}">
                            <label  for="{!! $file->id !!}"></label>
                            <img src="{!! asset("/storage/".$file->path) !!}" style="width: 50px;height:50px;"/>
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary ajax_post">Save changes</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@push('js')
<script>
    $('.ajax_post').click(function () {
        var file_id = $("input[name='file_id']:checked").val();
        var key = $("input[name='file_id']:checked").attr("key");
        var page_detail_id = $("input[name='file_id']:checked").attr("page_detail_id");
        var page_id = $("input[name='file_id']:checked").attr("page_id");

        $.ajax({
            url:'{!! route('file.ajax') !!}',
            method:'POST',
            data:{"_token": "{{ csrf_token() }}", "file_id" : file_id , "key" : key , "page_detail_id" : page_detail_id , "page_id" : page_id},
            success: function (response) {
                console.log(response.message);
            }
        });
    });
</script>
@endpush
