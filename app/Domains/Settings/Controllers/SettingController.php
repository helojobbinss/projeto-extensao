<?php

namespace App\Domains\Settings\Controllers;

use App\Http\Controllers\Controller;
use App\Domains\Settings\Services\SettingService;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function __construct(
        protected SettingService $service
    ) {}

    public function edit()
    {
        return view('settings.edit', [
            'settings' => $this->service->all(),
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            // Banner
            'banner_image' => 'nullable|image|max:5120',
            'banner_text'  => 'nullable|string',

            // Sobre Nós
            'about_title'  => 'nullable|string|max:255',
            'about_text'   => 'nullable|string',
            'about_image'  => 'nullable|image|max:5120',

            // Contato
            'address'      => 'nullable|string',
            'phone'        => 'nullable|string|max:50',

            // Redes sociais
            'instagram'    => 'nullable|url',
            'facebook'     => 'nullable|url',
        ]);

        $this->service->saveSettings($request);

        return redirect()
            ->back()
            ->with(
                'success',
                'Configurações atualizadas com sucesso.'
            );
    }
}