@php
    $bannerText = setting('banner.text');

    $bannerImage = null;

    if (setting('banner.image_id')) {
        $bannerImage = \App\Domains\Images\Models\Image::find(
            setting('banner.image_id')
        );
    }
@endphp

<section
    class="banner" id="banner"
    @if($bannerImage)
        style="background-image: url('{{ $bannerImage->url }}')"
    @endif
>
    <div class="banner-overlay">
        <div class="banner-content">
            <h1>{{ $bannerText }}</h1>
        </div>
    </div>
</section>