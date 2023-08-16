<?php

namespace App\Http\Controllers\Callbacks;

use Azate\LaravelTelegramLoginAuth\TelegramLoginAuth;
use Illuminate\Http\Request;


class TelegramController
{
    public function __invoke(TelegramLoginAuth $validator, Request $request)
    {
        $data = $validator->validate($request);

        $user = auth()->user();

        //ToDo refactor to use service
        $user->telegram_id = $data->getId();
        $user->save();

        notify()->success('You were added to our telegram bot', position: 'topRight');
        return redirect()->route('profile.edit');
    }
}
