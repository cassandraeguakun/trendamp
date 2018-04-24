<?php
/**
 * Created by PhpStorm.
 * User: dennis
 * Date: 11/04/2018
 * Time: 02:23 PM
 */

namespace Modules\System\Http\Resources;


use Illuminate\Http\Resources\Json\Resource;

class UserResource extends Resource
{
    public function toArray($request)
    {
        return[
            'id' => $this->id,
            'email' => $this->email
        ];
    }

}