<?php
/**
 * Created by PhpStorm.
 * User: chris
 * Date: 18/01/17
 * Time: 20:34
 */

namespace LittleGuru\Guru;


class ErrorNotifier
{

    private $url;

    protected $username;

    protected $password;

    protected $lastError;

    protected $domain;

    protected $lastResponse;

    /**
     * ErrorNotifier constructor.
     * @param $domain
     * @param $password
     * @param $username
     * @param $url
     */
    public function __construct($domain, $password, $username, $url)
    {
        $this->domain = $domain;
        $this->password = $password;
        $this->username = $username;
        $this->url = $url;
    }


    public function error($title, $info = array(), $type = '', $request = '', $code = 0)
    {

        $params = [
            'domain' => $this->domain,
            'title' => $title,
            'info' => $info,
            'type' => $type,
            'request' => $request,
            'code' => $code,
            'error' => 1
        ];

        $this->call($params);

    }

    public function log($title, $info = array(), $type = '', $request = '', $code = 0)
    {

        $params = [
            'domain' => $this->domain,
            'title' => $title,
            'info' => $info,
            'type' => $type,
            'request' => $request,
            'code' => $code,
            'error' => 1
        ];

        $this->call($params);

    }

    private function call($params)
    {

        try {

            $ch = curl_init($this->url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($params));
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
            $this->lastResponse = curl_exec($ch);
            $info = curl_getinfo($ch);
            curl_close($ch);




        }catch(\Exception $e)
        {
            $this->lastError = $e->getMessage();
        }

    }




}