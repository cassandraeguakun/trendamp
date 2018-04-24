<?php
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 20/02/2018
 * Time: 01:04 PM
 */

namespace Modules\System\Contracts;


trait MetaDataTrait
{

    public function getMetadataAttribute($value){
        if($value){
            return json_decode($value, true);
        } else {
            return [];
        }
    }

}