<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Repositories\HomeRepository;

class HomeController extends Controller
{
    protected $homeRepository;

    public function __construct(HomeRepository $homeRepository)
    {
        // $this->middleware('auth');
        $this->homeRepository = $homeRepository;
    }

    public function index(Request $request)
    {
        $month = $request->input('bulan');
        $year = $request->input('tahun');
        $membershipName = $request->input('membership');

        $memberships = $this->homeRepository->getMembership();
        $totalTransactions = $this->homeRepository->getTotalTransactions($month, $year, $membershipName);
        $membershipTransactions = $this->homeRepository->getMembershipTransaction();
        $membershipActive = $this->homeRepository->getMembershipActive($month, $year, $membershipName);
        $transactionsPerMonth = $this->homeRepository->totalTransactionsPerMonth();
        $dataTransaksi = $this->homeRepository->getDataTransaksi($month, $year, $membershipName);

        return view('master.dashboard.index', compact('totalTransactions', 'membershipTransactions', 'membershipActive', 'transactionsPerMonth', 'memberships', 'dataTransaksi'));
    }

    // public function getDataTransaksi(){
    //     $successCount = Transaction::where('status', 'success')->count();
    //     $pendingCount = Transaction::where('status', 'pending')->count();
    //     $failedCount = Transaction::where('status', 'failed')->count();
    
    //     $data = [
    //         'success' => $successCount,
    //         'pending' => $pendingCount,
    //         'failed' => $failedCount
    //     ];
    
    //     return response()->json($data);
    // }
}
