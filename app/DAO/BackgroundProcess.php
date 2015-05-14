<?php
/**
 * Created by PhpStorm.
 * User: hajime3333
 * Date: 5/31/14
 * Time: 3:49 AM
 */

namespace App\DAO;

use App\DAO\base\CollectionBase;
use App\Libraries\APIException;
use App\Libraries\Constants;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Session;
use Illuminate\Support\Facades\Log;

class BackgroundProcess extends CollectionBase
{
    private static $bgp;
    const NUMBER_LIMIT_PROCESS = 6;

    public function __construct()
    {
        $this->initialize();
        parent::__construct('process');
    }

    public function initialize()
    {
        set_time_limit(30);
        if (Request::capture()->server('HTTP_HOST') != env("SITE_HOST","localhost") && $_ENV['APP_ENV'] != 'local') {
            // only report error when running on real hot, not in localhost
            throw new APIException("Invalid Session", APIException::ERRORCODE_FORBIDDEN);
        }
    }

    public static function getInstance()
    {
        if (self::$bgp == null) {
            self::$bgp = new BackgroundProcess();
        }
        return self::$bgp;
    }

    public function process($process_id)
    {
        if ($this->countActiveProcess() < self::NUMBER_LIMIT_PROCESS) {

            $r = $this->findOne(array('_id' => $process_id));
            if (isset($r) && $r['status'] == Constants::PROCESS_WAITING) {
                $this->update(array('_id' => $process_id), array('$set'=>array('process' => Constants::PROCESS_PROCESSING)));
                $this->run($r['process']);

                $this->remove(array('_id' => $process_id));
            }
        }
    }

    public function throwProcess($command, $parameter = array(),$priority="hight")
    {
        try {

            $param_query = http_build_query($parameter);
            $url = $command . "?" . $param_query;

            $values = array(
                'process' => $url,
                'priority' => $priority,
                'status' => Constants::PROCESS_WAITING,
                'started_at' => new \MongoDate(0, 0)
            );
            $this->insert($values);

            $this->process($values['_id']);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * @return mixed
     * Get count process is available in 2 minutes
     */
    public function countActiveProcess()
    {
        $cur = $this->find(array('status' => Constants::PROCESS_PROCESSING, 'started_at' => array('$lt' => 1000 * (time() - 2 * 60))));
        return $cur->count();
    }

    private function run($command)
    {
        try {
            if ($this->getPathBase() == null) {
                $process = "http://".env("SITE_HOST","localhost"). $command;
            } else {
                $process = "http://".env("SITE_HOST","localhost"). $this->getPathBase() . "/" . $command;
            }
            exec("wget -O- '" . $process . "' > /dev/null");
            //Test on window
            //exec('cmd /c start '.$process);
            /*if (strncasecmp(PHP_OS, 'WIN', 3) == 0) {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $process);
                curl_exec($ch);
            }*/
        } catch (Exception $e) {
            Log::error("Process Error:" . $e->getTraceAsString());
        }
    }

    /**
     * @return null
     */
    private static function getPathBase()
    {
        $url_component = parse_url(url("/"));
        if (isset($url_component['path'])) {
            return $url_component['path'];
        }
        return null;
    }

    public function getBatchProcess($limit) {
        $cur=$this->find(array('status'=>Constants::PROCESS_WAITING))->sort(array('priority'=>-1))->limit($limit);
        return $cur;
    }
}
