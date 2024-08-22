<?php

namespace App\Service;

use App\Models\User;

class PointService
{
    public function addPoint($userId, $total)
    {
        $point = $total / 100;

        $user = User::where('id', $userId)->first();
        $user->update(['point' => $user->point + $point]);
        $user->save();

        return $point;
    }

    public function payWithPoint(User $user, $total, $usingPoint)
    {
        if ($usingPoint != "true") return;

        $point = $user->point;
        $pointUsed = 0;
        $newTotal = 0;

        if ($total > $point) {
            $pointUsed = $point;
            $newTotal = $total - $point;
            $user->update(['point' => 0]);
            return [
                'pointUsed' => $pointUsed,
                'newTotal' => $newTotal
            ];
        } elseif ($total <= $point) {
            $pointUsed = $total;
            $user->update(['point' => $point - $total]);

            return [
                'pointUsed' => $pointUsed,
                'newTotal' => $newTotal
            ];
        }
    }
}
