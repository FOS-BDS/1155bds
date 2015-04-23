<?php
namespace App\Libraries;

use Exception;

class APIException extends Exception
{
    private $http_code=0;
    public function __construct($message = "", $code = 400,$httpcode=400)
    {
        parent::__construct($message, $code, null);
        if($httpcode==0) {$httpcode=$code;}
        $this->http_code=$httpcode;
    }
    public function getHttpCode()
    {
        return $this->http_code;
    }
    // error message
    const ERRORCODE_LACK_PARAMETER = 400;
    const ERRORCODE_INVALID_TOKEN = 401;
    //const ERRORCODE_INVALID_FB_TOKEN = 407;
    const ERRORCODE_FORBIDDEN = 403;
    const ERRORCODE_NOTFOUND = 404;
    const ERRORCODE_DONE_ALREADY = 409;
    const ERRORCODE_INVALID_INPUT = 408;
    const ERRORCODE_INTERNAL = 500;
    const ERRORCODE_MAINTENANCE = 503;
    const ERRORCODE_VERSION_INCOMPATIBLE = 505;

    const ERRORCODE_BAD_REQUEST =400;

    const SUBCODE_INVALID_FB_TOKEN=103;
    const SUBCODE_LACK_PUBLIC_PERMISSION=104;
    const SUBCODE_LACK_PUBLISH_PERMISSION=105;
    const SUBCODE_LACK_USER_PHOTO_PERMISSION=106;
    const SUBCODE_LACK_EMAIL_PERMISSION=107;
    const SUBCODE_LACK_USER_FRIEND_PERMISSION=108;
    const SUBCODE_INVALID_IMAGE=109;

    const SUBCODE_RESULT_NOTCHANGE=301;

}
