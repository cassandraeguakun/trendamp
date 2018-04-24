<?php

namespace Modules\Account\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;


class PrepUserDataAfterLogin implements ShouldQueue
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
        // echo 'The user with id: ' . $this->user_id . ' has logged in.';
    }

}
