<?php

namespace App\Console\Commands;

use App\Events\EmailSending;
use App\Posts;
use Illuminate\Console\Command;

class PostEmailSending extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-email-to-subscriber';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return mixed
     */
    public function handle()
    {
        $posts= Posts::where('is_mail_sent',0)->get();
        foreach ($posts as $post) {
            event(new EmailSending($post));
            $post->is_mail_sent = 1;
            $post->save();
        }
    }
}
