<?php

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

Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
Broadcast::channel('chat', function ($user) {
    return $user;
});
Broadcast::channel('DeanExcuse',function($user){
    return true;
});
Broadcast::channel('AdminExcuse',function($user){
    return true;
});
#StudentExcusePaid
Broadcast::channel('StudentExcusePaid',function($user){
    return true;
});
#StudentExcuseAccepted
Broadcast::channel('StudentExcuseAccepted',function($user){
    return true;
});
#StudentOpenLecture
Broadcast::channel('StudentOpenLecture',function($user){
    return true;
});
Broadcast::channel('SendMessage',function($user){
    return true;
});
#StudentAttendSelf
Broadcast::channel('StudentAttendSelf',function($user){
    return true;
});
