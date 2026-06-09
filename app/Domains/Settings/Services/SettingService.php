<?php

namespace App\Domains\Settings\Services;

use App\Domains\Images\Services\ImageService;
use App\Domains\Settings\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SettingService
{
    public function __construct(
        protected ImageService $imageService
    ) {}

    public function all()
    {
        return Setting::pluck('value', 'key');
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return Setting::where('key', $key)
            ->value('value') ?? $default;
    }

    public function set(string $key, mixed $value): void
    {
        Setting::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );

        Cache::forget("setting.{$key}");
    }

    public function saveSettings(Request $request): void
    {
        // Banner
        $this->set('banner.text', $request->banner_text);

        // Sobre Nós
        $this->set('about.title', $request->about_title);
        $this->set('about.text', $request->about_text);

        // Contato
        $this->set('site.address', $request->address);
        $this->set('site.phone', $request->phone);

        // Redes sociais
        $this->set('social.instagram', $request->instagram);
        $this->set('social.facebook', $request->facebook);

        // Imagem do banner
        if ($request->hasFile('banner_image')) {

            $image = $this->imageService->store(
                $request->file('banner_image'),
                'settings/banner'
            );

            $this->set(
                'banner.image_id',
                $image->id
            );
        }

        // Imagem do Sobre Nós
        if ($request->hasFile('about_image')) {

            $image = $this->imageService->store(
                $request->file('about_image'),
                'settings/about'
            );

            $this->set(
                'about.image_id',
                $image->id
            );
        }
    }
}