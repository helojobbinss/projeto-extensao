@extends('layouts.app')

@section('content')

<div class="container">
    <div class="card">

        <div class="card-header">
            <h2>Configurações do Site</h2>
        </div>

        <div class="card-body">

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @php
                $bannerImage = null;
                $aboutImage = null;

                if (!empty($settings['banner.image_id'])) {
                    $bannerImage = \App\Domains\Images\Models\Image::find(
                        $settings['banner.image_id']
                    );
                }

                if (!empty($settings['about.image_id'])) {
                    $aboutImage = \App\Domains\Images\Models\Image::find(
                        $settings['about.image_id']
                    );
                }
            @endphp

            <form
                method="POST"
                action="{{ route('settings.update') }}"
                enctype="multipart/form-data"
            >
                @csrf
                @method('PUT')

                {{-- Banner --}}
                <h4>Banner</h4>

                <div class="mb-3">
                    <label class="form-label">
                        Imagem do Banner
                    </label>

                    <input
                        type="file"
                        name="banner_image"
                        class="form-control"
                        accept="image/*"
                    >

                    @if($bannerImage)
                        <div class="mt-3">
                            <p class="mb-2">
                                <strong>Imagem atual:</strong>
                            </p>

                            <img
                                src="{{ $bannerImage->url }}"
                                alt="Banner"
                                class="img-thumbnail"
                                style="max-height: 200px;"
                            >
                        </div>
                    @endif
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Texto do Banner
                    </label>

                    <textarea
                        name="banner_text"
                        rows="4"
                        class="form-control"
                    >{{ old('banner_text', $settings['banner.text'] ?? '') }}</textarea>
                </div>

                <hr>

                {{-- Sobre Nós --}}
                <h4>Sobre Nós</h4>

                <div class="mb-3">
                    <label class="form-label">
                        Título
                    </label>

                    <input
                        type="text"
                        name="about_title"
                        class="form-control"
                        value="{{ old('about_title', $settings['about.title'] ?? '') }}"
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Imagem do Sobre Nós
                    </label>

                    <input
                        type="file"
                        name="about_image"
                        class="form-control"
                        accept="image/*"
                    >

                    @if($aboutImage)
                        <div class="mt-3">
                            <p class="mb-2">
                                <strong>Imagem atual:</strong>
                            </p>

                            <img
                                src="{{ $aboutImage->url }}"
                                alt="Sobre Nós"
                                class="img-thumbnail"
                                style="max-height: 200px;"
                            >
                        </div>
                    @endif
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Texto do Sobre Nós
                    </label>

                    <textarea
                        name="about_text"
                        rows="8"
                        class="form-control"
                    >{{ old('about_text', $settings['about.text'] ?? '') }}</textarea>
                </div>

                <hr>

                {{-- Contato --}}
                <h4>Contato</h4>

                <div class="mb-3">
                    <label class="form-label">
                        Endereço
                    </label>

                    <textarea
                        name="address"
                        rows="3"
                        class="form-control"
                    >{{ old('address', $settings['site.address'] ?? '') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Telefone
                    </label>

                    <input
                        type="text"
                        name="phone"
                        class="form-control"
                        value="{{ old('phone', $settings['site.phone'] ?? '') }}"
                    >
                </div>

                <hr>

                {{-- Redes Sociais --}}
                <h4>Redes Sociais</h4>

                <div class="mb-3">
                    <label class="form-label">
                        Instagram
                    </label>

                    <input
                        type="url"
                        name="instagram"
                        class="form-control"
                        value="{{ old('instagram', $settings['social.instagram'] ?? '') }}"
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Facebook
                    </label>

                    <input
                        type="url"
                        name="facebook"
                        class="form-control"
                        value="{{ old('facebook', $settings['social.facebook'] ?? '') }}"
                    >
                </div>

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    Salvar Configurações
                </button>

            </form>

        </div>
    </div>
</div>

@endsection