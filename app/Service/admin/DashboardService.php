<?php

namespace App\Service\admin;

use App\Models\Bill;
use Carbon\Carbon;

class DashboardService
{

    public function getAll()
    {
        $bill = Bill::orderByDesc('created_at')->get();
        return $bill;
    }
    public function getDashboard()
    {
        $day = $this->getRevenueByDay();
        $week = $this->getRevenueByWeek();
        $month = $this->getRevenueByMonth();
        $years = $this->getRevenueByYear();
        return [
            'billDay' => $day,
            'billWeek' => $week,
            'billMonth' => $month,
            'billYears' => $years
        ];
    }

    public function getRevenueByDay() {
        $totalRevenue = Bill::whereDate('created_at', now()->toDateString())
                            ->where('status', 1)->sum('total');
        return number_format($totalRevenue);
    }

    public function getRevenueByWeek() {
        $startOfWeek = now()->startOfWeek();
        $endOfWeek = now()->endOfWeek();

        $totalRevenue = Bill::whereBetween('created_at', [$startOfWeek, $endOfWeek])
                            ->where('status', 1)->sum('total');

        return number_format($totalRevenue);
    }

    public function getRevenueByMonth() {
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();

        $totalRevenue = Bill::whereBetween('created_at', [$startOfMonth, $endOfMonth])
                            ->where('status', 1)->sum('total');

        return number_format($totalRevenue);
    }

    public function getRevenueByYear() {
        $startOfYear = now()->startOfYear();
        $endOfYear = now()->endOfYear();

        $totalRevenue = Bill::whereBetween('created_at', [$startOfYear, $endOfYear])
                            ->where('status', 1)->sum('total');

        return number_format($totalRevenue);
    }
}
