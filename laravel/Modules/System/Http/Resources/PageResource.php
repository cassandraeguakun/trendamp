<?php
/**
 * Created by PhpStorm.
 * User: dennis
 * Date: 14/04/2018
 * Time: 09:23 AM
 */

namespace Modules\System\Http\Resources;


use Illuminate\Http\Resources\Json\Resource;

class PageResource extends Resource
{
    public function toArray($request)
    {
        return [
            'name' => $this->getPageName(),
            'title' => $this->getConfig()['title'],
            'url' => $this->getConfig()['url'],
            'content' => $this->getRawContent()
        ];
    }


}