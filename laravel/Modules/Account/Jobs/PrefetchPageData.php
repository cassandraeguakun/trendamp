<?php

namespace Modules\Account\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Modules\Posts\Http\Resources\PostResource;
use Modules\Posts\Repositories\PostsRepository;
use Modules\Servermessenger\Messenger\Clients\MessageSender;
use Modules\Users\Models\User;

class PrefetchPageData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var User
     */
    private $user;
    /**
     * @var
     */
    private $address;
    /**
     * @var string
     */
    private $page;


    /**
     * Create a new job instance.
     *
     * @param User $user
     * @param $address
     * @param string $page
     */
    public function __construct(User $user, $address, $page = '/')
    {
        //
        $this->user = $user;
        $this->address = $address;
        $this->page = $page;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        switch ($this->page){
            case 'home' :
                // todo:: prefetch anticipated data for home page

                $this->prefetchHomePageData();

                break;

            case 'user_profile_wall' :
                $this->prefetchFeeds($this->user->id, $this->address);

                break;
        }
    }

    private function prefetchHomePageData()
    {
        $this->prefetchFeeds($this->user->id, $this->address);
    }

    private function prefetchFeeds($user_id, $user_address)
    {
        /**
         * @var PostsRepository $postsRepo
         */
        $postsRepo = app(PostsRepository::class);
        $data = $postsRepo->getUserFeeds($user_id);

        $posts = PostResource::collection($data, $user_id);

        $response = [
            'data' => $posts,
            'meta' => [
                'emit_event' => 'prefetch.feeds'
            ]
        ];

        MessageSender::sendMessage(json_encode($response),$user_address,true);
    }
}
