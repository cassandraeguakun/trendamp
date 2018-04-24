<?php

namespace Modules\Account\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Modules\Mailmessenger\Mailer\MailMan;
use Modules\Servermessenger\Messenger\Task\TaskableJob;
use Modules\Users\Repositories\UsersRepository;

class SendWelcomeMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * @var
     */
    private $user_id;


    /**
     * Create a new job instance.
     *
     * @param $user_id
     */
    public function __construct($user_id)
    {

        $this->user_id = $user_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // todo: send welcome email message to the provided user
        $user = app(UsersRepository::class)->getUserById($this->user_id);

        /**
         * @var MailMan $mailman
         */
        $mailman = app(MailMan::class);
        $mailman->prepare('account::emails.welcome', compact('user'))
                ->send($user->email, 'Welcome to TalkStuff');
    }
}
