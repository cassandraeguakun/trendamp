<?php

namespace Modules\Account\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class UserAccountProfileResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'registeredAt' => $this->registered_date->format('Y-m-d'),
            'displayName' => $this->getDisplayName(),
            'firstName' => $this->getProfileValue('FIRST_NAME'),
            'lastName' => $this->getProfileValue('LAST_NAME'),
            'profileImage' => [
                'extra_small' => $this->getProfileImage('extra_small'),
                'small' => $this->getProfileImage('small'),
                'medium' => $this->getProfileImage('medium'),
                'original' => $this->getProfileImage(),
            ],
            'totalPosts' => $this->posts()->count(),
            'totalFollowers' => $this->followers()->count(),
            'totalFriends' => $this->friends()->count(),
        ];
    }
}
