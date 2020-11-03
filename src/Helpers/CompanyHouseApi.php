<?php

namespace App\Helpers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Usage get company by company number:
 * CompanyHouseApi::getInstance()->get('company', 12482555);
 *
 * Usage get company by company name:
 * CompanyHouseApi::getInstance()->get('search/companies', '?q=PROJEKTIF+DIGITAL');
 *
 * Class CompanyHouseApi
 * @package App\Helpers
 */
class CompanyHouseApi
{
    private static $instance;
    private $apiConf;

    /**
     * @return mixed
     */
    public static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * @param string $endpoint
     * @param string $parameter
     * @return array|mixed
     */
    public function get(string $endpoint, string $parameter)
    {
        $this->initializeApiConf();

        if (!empty($parameter)) {
            $parameter = "/" . $parameter;
        }

        try {
            $client = new Client();

            $headers = [
                'Authorization' => "Basic " . base64_encode($this->apiConf['api']['key'] . ":"),
            ];

            $response = $client->request(
                'GET',
                sprintf('%s%s%s', $this->apiConf['api']['url'], $endpoint, $parameter),
                ['headers' => $headers,
                'verify' => $this->apiConf['ssl']['verify'] ? true : false,
                ]
            );

            Logger::getInstance("CompanyHouseApi.log")->info(
                'status',
                [$response->getStatusCode()]
            );

            return json_decode(
                $response->getBody()->getContents(),
                true
            );
        } catch (GuzzleException $e) {
            Logger::getInstance("CompanyHouseApi.log")->error(
                'failed',
                [
                    'line' => $e->getLine(),
                    'message' => $e->getMessage()
                ]
            );
            return [];
        }
    }

    private function initializeApiConf(): void
    {
        $this->apiConf = Config::getInstance()->get('company_house');
    }
}
