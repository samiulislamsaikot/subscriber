<?php

namespace App\Jobs;

use App\Posts;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Mail\Mailable;

class MailSend implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Posts $posts)
    {
        $this->post= $posts;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {

            \Mail::queue(new \NotifyUserAfterPostsSubmit($this->post));

        } catch (\Exception $exception) {

            $logMessage = 'Mail to could not be sent : '. $this->post. ' at '. $this->post. '. due to exception : '. $exception->getMessage();
        }
    }
}
