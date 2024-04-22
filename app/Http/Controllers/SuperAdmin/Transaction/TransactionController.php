<?php

namespace App\Http\Controllers\SuperAdmin\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Membership;
use App\Models\Transaction;
use App\Models\User;
use App\Repositories\SuperAdmin\Transaction\TransactionRepository;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $transactionRepository;

    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->middleware('permission:transaction-index|transaction-store|transaction-update|transaction-destroy', ['only' => ['index', 'show', 'data']]);
        $this->middleware('permission:transaction-store', ['only' => ['store']]);
        $this->middleware('permission:transaction-update', ['only' => ['edit', 'update']]);
        $this->middleware('permission:transaction-destroy', ['only' => ['destroy']]);
        $this->transactionRepository = $transactionRepository;
   
    }

    public function index(Request $request)
    {
        
        $transaction = Transaction::with(['membership', 'user'])->get();
        $users = User::all();
        $memberships = Membership::all();

        $dataTransaksi = $this->transactionRepository->getDataTransaksi();
        $dataMember = $this->transactionRepository->getDataMember();
        $totalTransactions = $this->transactionRepository->getDataTransaksi();
        // $silverTransactions = Transaction::where('membership_id', '5')->count();
        return view('master.dashboard.transaksi.detail-transaksi.index', compact( 'dataTransaksi','dataMember','totalTransactions'), ['transaction' => $transaction, 'users' => $users, 'memberships' => $memberships, 'request' => $request, 'dataTransaksi']);
    }


    public function data(Request $request)
    {
        $perPage = 10;
        $search = $request->input('search');
        $transaction = $this->transactionRepository->searchByName($search, $perPage);

        return response()->json($transaction);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $userId = Auth::id();

        $validator = Validator::make($request->all(), [
            'membership_id' => 'required|exists:memberships,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        if ($request->filled('id')) {
            $this->update($request);
            return response()->json(['message' => 'Transaction updated successfully']);
        } else {
            $existingTransaction = Transaction::where('user_id', $userId)
                ->where('membership_active', true)
                ->first();
            if ($existingTransaction) {
                return response()->json(['message' => 'User already has an active membership!'], 422);
            }
            $this->transactionRepository->create($request->all());
            return response()->json(['message' => 'Transaction added successfully']);
        }
    }

    public function callback(Request $request)
    {
        $this->transactionRepository->handleCallback($request);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $transaction = $this->transactionRepository->findOrFail($id);
        return response()->json(['data' => $transaction]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $this->transactionRepository->update($request->all(), $request->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $this->transactionRepository->destroy($id);
            return response()->json(['message' => 'Transaction deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function nonActiveMembership(Request $request)
    {
        $this->transactionRepository->nonActiveMembership($request->id);
        return response()->json(['message' => 'Lepas Membership successfully']);
    }

    public function loadTransaksi(Request $request)
{
    $search = $request->input('search');
    $status = $request->input('status'); // Mengambil status dari request

    $query = Transaksi::query();

    // Filter data transaksi berdasarkan status 'pending' jika diperlukan
    if ($status && $status === 'pending') {
        $query->where('status', 'pending');
    }

    // Sisipkan logika pencarian jika diperlukan
    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('nama_mitra', 'like', "%$search%")
              ->orWhere('membership', 'like', "%$search%");
        });
    }

    // Lanjutkan dengan logika lainnya seperti pengaturan pagination dan lain-lain
    $transactions = $query->paginate(10); // Misalnya, disini saya menggunakan pagination dengan batasan 10 item per halaman

    return response()->json($transactions);
}


}
