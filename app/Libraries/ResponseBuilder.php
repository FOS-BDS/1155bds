<?php

namespace App\Libraries;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Queue;

class ResponseBuilder
{
    //send error message to client
    // Input: Error Message and Error code
    public static function error(\Exception $exception)
    {
        // log
        if($exception->getCode()!=APIException::SUBCODE_RESULT_NOTCHANGE) {
            Log::error($exception->getMessage()."\n ERROR_CODE: ".$exception->getCode()."\n INPUT: ".json_encode(InputHelper::getAllInput())."\n HEADER: ".json_encode(Request::capture()->headers->all())."\n Trace: ".$exception->getTraceAsString());
        }

        if ($exception instanceof APIException) {
            return response()->json(array('error'=>
                    array('message'=>$exception->getMessage(),'code'=> $exception->getCode())),
                                        $exception->getHttpCode());
        } else {
            return response()->json(array('error'=>
                array('message'=>"SERVER ERROR:".$exception->getMessage(),'code'=> 500)),500);
        }

    }
    public static function success($result=null) {
        if($result!=null) {
            $json=json_encode($result);
            $last_result=InputHelper::getInput('last_result',false,'');
            $md5_result=md5($json);
            if($last_result!=$md5_result) {
                $result=(array)$result;
                $result['md5']=$md5_result;
                return response()->json($result);
            } else {
                throw new APIException("DATA NOT CHANGE",APIException::SUBCODE_RESULT_NOTCHANGE,APIException::ERRORCODE_BAD_REQUEST);
            }

        }
    }
}


