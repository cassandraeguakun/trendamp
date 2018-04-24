<?php

use Symfony\Component\Debug\Exception\FatalThrowableError;
const YEAR_GENERATOR_CENTER = 'CENTER';
const YEAR_GENERATOR_TOP = 'TOP';
const YEAR_GENERATOR_BOTTOM = 'BOTTOM';

function publish($job){
    if(method_exists($job, 'handle')){
        $job->handle();
    } else {
        event($job);
    }
}

function generate_years($startAt = null, $count = 20, $format = YEAR_GENERATOR_CENTER){
    if(!$startAt) $startAt = date('Y');

    $years = [];

    switch (strtoupper($format)){
        case YEAR_GENERATOR_CENTER:
            $halves = round($count / 2);

            for($i = 0; $i < $halves; $i++){
                $years[] = $startAt + $halves - $i;
            }

            for($i = 0; $i < $halves; $i++){
                $years[] = $startAt - $i;
            }

            break;
        case YEAR_GENERATOR_TOP:
            for($i = 0; $i < $count; $i++){
                $years[] = $startAt - $i;
            }
            break;

        case YEAR_GENERATOR_BOTTOM:
            for($i = 0; $i < $count; $i++){
                $years[] = $startAt + $count - $i;
            }
            break;
    }
    return $years;
}

function isPath($path){
    return $path == currentRoutePath();
}

function currentRoutePath(){
    return currentRoute()->uri;
}

function currentRoute(){
    return \Route::current();
}

function to_db_date($string){
    $timestamp = strtotime($string);

    return date('Y-m-d', $timestamp);
}
function to_db_datetime($string){
    $timestamp = strtotime($string);

    return date('Y-m-d H:i:s', $timestamp);
}

function from_db_datetime($dateTime){
    $timestamp = strtotime($dateTime);

    return date('Y-m-d h:i:s A',$timestamp);
}

function strToDbTime($timeString)
{
    $timestamp = strtotime($timeString);

    return date('H:i:s',$timestamp);
}

function dbTimeToStr($time){
    $timestamp = strtotime($time);

    return date('h:i A',$timestamp);
}


function setMetaData(\Modules\System\Contracts\iMetaData &$entity, array $metaDataValue, bool $shouldSave = false){

    $return = null;
    $data = $entity->metadata;

    if(empty($data)){ // no configuration value
        $return = json_encode($metaDataValue);
    } else {
        foreach($metaDataValue as $field => $val){ // update configuration value
            $data[$field] = $metaDataValue[$field];
        }
        $return = json_encode($data);
    }

    if($shouldSave) $entity->save();

    return $return;
}

function getMetaDataValue(array $meta, $searchField){

    if(!empty($meta)){ //
        foreach($meta as $f => $val){ //
            if ($f == $searchField) return $val;
        }

    }

    return;
}

function inPercentage($numerator, $denominator){
    return round(($numerator / $denominator) * 100,2);
}

function errorResponse($message){
    return response()->json($message, 401);
}