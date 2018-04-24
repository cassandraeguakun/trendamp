<?php
/**
 * Created by PhpStorm.
 * User: dennis
 * Date: 09/04/2018
 * Time: 04:53 PM
 */

namespace Modules\System\Events;


use Modules\System\Models\User;

class UserWasCreated
{
    /**
     * @var User
     */
    public $user;
    /**
     * @var array
     */
    public $data;


    /**
     * UserWasCreated constructor.
     * @param User $user
     * @param array $data
     */
    public function __construct(User $user, array $data = [])
    {
        $this->user = $user;
        $this->data = $data;
    }
}