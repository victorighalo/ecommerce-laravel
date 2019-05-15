<?php

namespace App\Jobs;

use App\Mail\SendPasswordChangeEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 5;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        dd('wqweqe');
        $when = now()->addMinutes(1);
        $email = new SendPasswordChangeEmail();
        dd($this->details['email']);
        \Mail::to($this->details['email'])->send(new SendPasswordChangeEmail);

    }
}
