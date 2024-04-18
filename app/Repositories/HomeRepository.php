<?php

namespace App\Repositories;

use App\Models\Membership;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class HomeRepository
{
    public function getAllTransaction()
    {
        return Transaction::all();
    }

    public function getMembership()
    {
        return Membership::all();
    }

    public function getTotalTransactions($month = null, $year = null, $membershipName = null)
    {
        $transactions = $this->filterTransactions($month, $year, $membershipName);

        $totalPrice = $transactions->where('status', 'success')->sum(function ($transaction) {
            return $transaction->membership->price;
        });

        $formattedPrice = 'Rp ' . number_format($totalPrice, 0, ',', '.');

        return $formattedPrice;
    }


    public function getMembershipTransaction()
    {
        $allMemberships = Membership::all();

        $groupedTransactions = Transaction::with('membership')->where('status', 'success')->get()->groupBy('membership_id');

        $membershipTotalTransactions = [];

        foreach ($allMemberships as $membership) {
            $memberId = $membership->id;
            $memberName = $membership->name;

            if (isset($groupedTransactions[$memberId])) {
                $totalTransactions = $groupedTransactions[$memberId]->count();
            } else {
                $totalTransactions = 0;
            }

            $membershipTotalTransactions[] = [
                'name' => $memberName,
                'totalTransactions' => $totalTransactions
            ];
        }

        return $membershipTotalTransactions;
    }

    public function getMembershipActive($month = null, $year = null, $membershipName = null)
    {
        $transactions = $this->filterTransactions($month, $year, $membershipName);

        $membershipActiveCount = $transactions->where('membership_active', 1)->count();

        return $membershipActiveCount;
    }


    public function totalTransactionsPerMonth()
    {
        $transactionsPerMonth = Transaction::select(
            DB::raw('YEAR(start_date) as year'),
            DB::raw('MONTH(start_date) as month'),
            DB::raw('SUM(memberships.price) as total_amount')
        )
            ->rightJoin('memberships', 'transactions.membership_id', '=', 'memberships.id')
            ->groupBy(DB::raw('YEAR(start_date), MONTH(start_date)'))
            ->orderBy(DB::raw('YEAR(start_date), MONTH(start_date)'))
            ->get();

        $result = [];

        $year = date('Y');
        $month = 1;

        for ($i = 1; $i <= 12; $i++) {
            $currentMonthData = $transactionsPerMonth->where('year', $year)->where('month', $month)->first();

            if (!$currentMonthData) {
                $result[] = (object)[
                    'year' => $year,
                    'month' => $month,
                    'total_amount' => 0
                ];
            } else {
                $result[] = $currentMonthData;
            }

            $month++;
            if ($month > 12) {
                $month = 1;
                $year++;
            }
        }

        return $result;
    }


    public function filterTransactions($month, $year, $membershipName)
    {
        $query = Transaction::query();

        if ($month == null && $year == null && $membershipName == null) {
            return $query->get();
        }

        if ($month !== null && $year !== null) {
            $query->whereMonth('created_at', $month)
                ->whereYear('created_at', $year);
        } elseif ($year != null) {
            $query->whereYear('created_at', $year);
        } elseif ($month != null) {
            $query->whereMonth('created_at', $month);
        }

        if ($membershipName !== null) {
            $query->whereHas('membership', function ($query) use ($membershipName) {
                $query->where('name', $membershipName);
            });
        }

        return $query->get();
    }

    public function getDataTransaksi($month = null, $year = null, $membershipName = null){
        $transactions = $this->filterTransactions($month, $year, $membershipName);

        $successCount = $transactions->where('status', 'success')->count();
        $pendingCount = $transactions->where('status', 'pending')->count();
        $failedCount = $transactions->where('status', 'failed')->count();
    
        $data = [
            'success' => $successCount,
            'pending' => $pendingCount,
            'failed' => $failedCount
        ];
    
        return $data;
    }
}
