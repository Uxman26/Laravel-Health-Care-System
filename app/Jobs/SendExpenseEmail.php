<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\ExpenseAdded;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class SendExpenseEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $expense_detail_id;
    public $user_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($expense_detail_id, $user_id)
    {
        $this->expense_detail_id = $expense_detail_id;
        $this->user_id = $user_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = User::where('id',$this->user_id)->first();
        if ($user && $user->pro_email) {
            Mail::to($user->pro_email)->send(new ExpenseAdded($this->expense_detail_id, $this->user_id));
        } else {
            Log::error("User not found for ID: {$this->user_id}");
        }
    }

    /**
     * Handle a job failure.
     *
     * @return void
     */
    public function failed(\Exception $exception)
    {
        Log::error('Job failed: ' . $exception->getMessage());
    }
}
