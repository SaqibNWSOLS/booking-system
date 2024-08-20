<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;

use Illuminate\Http\Response;

class ResponseHelper
{

    public static function returnReponse($responseCode, $responseMessage, $responseData, $sqlState)
    {
        if ($sqlState == 23000) {
            $responseMessage = "Cannot delete the record. Before deleting the record. Kindly delete it's child rackets.";
        }
       return response()->json(['statusCode' => $responseCode, "message" => $responseMessage, 'data' => $responseData,'sqlState'=>$sqlState])->setEncodingOptions(JSON_NUMERIC_CHECK)->setStatusCode($responseCode);
    }

}
