<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Task2A
{
    public function Task2A()
    {
        $currentDate = Carbon::now();
        $thirtyDaysAgo = $currentDate->subDays(30);

        $users = DB::table('users')
            ->join('purchases', 'users.id', '=', 'purchases.user_id')
            ->select('users.name', 'users.email', DB::raw('SUM(purchases.amount) as total_amount'))
            ->where('purchases.created_at', '>=', $thirtyDaysAgo)
            ->groupBy('users.id', 'users.name', 'users.email')
            ->get();

        $arrayOfUsers = [];
        foreach ($users as $user) {
            $userObj = new stdClass();
            $userObj->name = $user->name;
            $userObj->email = $user->email;
            $userObj->total_amount_spent = $user->total_amount;
            $arrayOfUsers[] = $userObj;
        }
        return $arrayOfUsers;
    }

}
