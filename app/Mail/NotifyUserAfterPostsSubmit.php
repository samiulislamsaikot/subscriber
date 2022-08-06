<?php


use App\Posts;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Class NotifyAdminForNewAppointment.
 */
class NotifyUserAfterPostsSubmit extends Mailable
{
    use Queueable, SerializesModels;


    public $appointment;

    public function __construct(Posts $post)
    {
        $this->post = $post;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data['sendTo']             = User::where('is_subscribed', 1)->pluck('email')->toArray();

        $data['subject'] = $this->post->title;

        return $this->to($data['sendTo'])
            ->with([
                'title' => $this->post,
                ])
            ->subject($data['subject']);
    }
}
