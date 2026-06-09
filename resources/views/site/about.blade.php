@php
    $aboutTitle = setting('about.title');
    $aboutText = setting('about.text');

    $aboutImage = null;

    if (setting('about.image_id')) {
        $aboutImage = \App\Domains\Images\Models\Image::find(
            setting('about.image_id')
        );
    }
@endphp

<section class="about-section" id="about">
    <div class="about-container">

        <div class="about-image">
            @if($aboutImage)
                <img
                    src="{{ $aboutImage->url }}"
                    alt="{{ $aboutTitle }}"
                >
            @endif
        </div>

        <div class="about-content">
            <span class="about-subtitle">
                Quem Somos
            </span>

            <h2>
                {{ $aboutTitle }}
            </h2>

            <p>
                {!! nl2br(e($aboutText)) !!}
            </p>
        </div>

    </div>
</section>