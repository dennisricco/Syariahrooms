<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Transaction;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;

class UpdateMembershipStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'membership:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update membership status based on finish date';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $expiredTransactions = Transaction::where('finish_date', '<', Carbon::now())->get();

        foreach ($expiredTransactions as $transaction) {
            $transaction->update(['membership_active' => false]);

            if (!$transaction->user) {
                continue;
            }
    
            $roleName = 'Member-' . $transaction->membership->name;
            $role = Role::where('name', $roleName)->first();
            if ($role) {
                $transaction->user->removeRole($role);
            }
        }

        $this->info('Membership status updated successfully.');

        return 0;
    }
}
