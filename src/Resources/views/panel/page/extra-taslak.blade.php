{{--Örnek kullanımlar--}}
@detailFile(Banner,detail_extras[{!! $pd->id !!}],banner,{!! $pd->banner !!},lfm)
@text(İsim,extras[{!! $pd->id !!}],isim,{!! $page->isim !!})
@file(Banner,extras[banner],{!! $page->banner !!},lfm2)

{{--Filemanager için mutlaka kullanılmalı--}}
@push('js')
    <script>
        $('#lfm').filemanager('image');
        $('#lfm2').filemanager('image');
    </script>
@endpush

