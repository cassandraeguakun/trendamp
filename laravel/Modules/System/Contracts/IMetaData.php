<?php
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 20/02/2018
 * Time: 12:49 PM
 */

namespace Modules\System\Contracts;


interface IMetaData
{
    public function getMetadataAttribute($value);
}