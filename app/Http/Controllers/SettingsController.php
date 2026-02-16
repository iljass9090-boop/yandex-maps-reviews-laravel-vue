<?php

namespace App\Http\Controllers;

use App\Models\YandexIntegration;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SettingsController extends Controller
{
    public function edit(Request $request)
    {
        $user = $request->user();

        $integration = YandexIntegration::firstOrCreate(
            ['user_id' => $user->id],
            ['place_url' => '', 'place_id' => null]
        );

        return Inertia::render('Settings/Edit', [
            'integration' => [
                'place_url' => $integration->place_url,
            ],
        ]);
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'place_url' => ['required', 'string', 'max:255'],
        ]);

        YandexIntegration::updateOrCreate(
            ['user_id' => $user->id],
            ['place_url' => $data['place_url']]
        );

        return redirect()->back()->with('success', 'Настройки сохранены.');
    }
}
