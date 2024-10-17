<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\User;
/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/
// In routes/channels.php

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {

    return (int) $user->id === (int) $id;
});
Broadcast::channel('chat.{recipientId}', function (User $user, int $recipientId) {
    logger('Channel authorization logic reached for user ID ' . $user->id);
    return true;  // This should give a 403 forbidden error
});
