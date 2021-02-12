@php
    $version = "";
    $packages = json_decode(file_get_contents('../vendor/composer/installed.json'));
    foreach ($packages->packages as $package)
        {
            if ($package->name == "revise/prime-cms")
                {
                    $version = $package->version;
                    break;
                }
        }
@endphp
<footer>
    <div class="footer clearfix mb-0 text-muted">
        <div class="float-right">
            <p>2020 &copy; Webarme İçerik Yönetim Sistemi Versiyon ({!! $version !!})</p>
        </div>
    </div>
</footer>
