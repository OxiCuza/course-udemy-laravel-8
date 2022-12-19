<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class Counter
{
    public function increment(string $key, array $tags = null): int
    {
        /**
         * For counting currently show this blogpost +- 1 minutes
         */
        # define key for counter and listing users
        $counterKey = "{$key}-counter";
        $usersKey = "{$key}-users";

        # get cache listing users with default value is array if null
        $users = Cache::get($usersKey, array());

        # define counter initiate is 0
        $usersUpdate = array();

        # get session id user
        $sessionUser = session()->getId();

        # if cache listing users is null the result cache listing is 1 user
        if (!Cache::has($counterKey)) {
            Cache::forever($counterKey, 1);
            $usersUpdate[$sessionUser] = now();
        }

        # loop cache listing has users
        foreach ($users as $sessionId => $timeUser) {
            if (($sessionUser == $sessionId) && now()->diffInMinutes($timeUser) >= 1) {
                # if key current user is exist && time different >= 1 the result is counter--
                Cache::decrement($counterKey);
            } elseif (($sessionUser != $sessionId) && now()->diffInMinutes($timeUser) <= 1) {
                # else if key current user is not exist && time different <= 1 the result is counter++
                $usersUpdate[$sessionUser] = now();
                Cache::increment($counterKey);
            } else {
                # else create new array for temporary
                $usersUpdate[$sessionId] = $timeUser;
            }
        }

        # update cache listing users
        Cache::forever($usersKey, $usersUpdate);

        return Cache::get($counterKey);
    }
}
