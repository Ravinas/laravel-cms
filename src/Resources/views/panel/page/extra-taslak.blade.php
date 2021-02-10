{{--Örnek kullanımlar--}}
@detailFile(Banner,detail_extras[{!! $pd->id !!}],banner,{!! $pd->banner !!},lfm)
@file(Banner,detail_extras[{!! $pd->id !!}],{!! $pd->banner !!},lfm2)
@text(İsim,extras[{!! $pd->id !!}],isim,{!! $page->isim !!})
{{--Filemanager için mutlaka kullanılmalı--}}
@push('js')
    <script>
        $('#lfm').filemanager('image');
        $('#lfm2').filemanager('image');
    </script>
@endpush