<?php

namespace Screecher\Service;

use Screecher\Exception\ApiLogWrongPathException;
use Screecher\Service\Interfaces\LogParserInterface;

/**
 * Class ApiLogParser
 * @package Screecher\Service
 */
class ApiLogParser implements LogParserInterface
{
    const API_LOG_ERROR = 'error';

    const API_LOG_STATUS_INDEX = '3';

    const API_LOG_API_INDEX = '2';

    const API_LOG_MESSAGE_INDEX = '4';

    /**
     * @var string
     */
    private $apiLogPath;

    /**
     * @param string $apiLogPath
     */
    public function __construct($apiLogPath)
    {
        $this->apiLogPath = $apiLogPath;
    }

    /**
     * @return array
     * @throws ApiLogWrongPathException
     */
    public function parse()
    {
        if (!file_exists($this->apiLogPath)) {
            throw new ApiLogWrongPathException('Wrong api_usage log path');
        }

        $csv = array_map('str_getcsv', file($this->apiLogPath));

        if (!empty($csv)) {
            return $this->findErrors($csv);

        }

        return [];
    }

    /**
     * @param $csv
     * @return array
     */
    private function findErrors($csv)
    {
        $errorsMap = [];

        foreach ($csv as $line) {
            if ($line[self::API_LOG_STATUS_INDEX] == self::API_LOG_ERROR)
            {
                $errorsMap[$line[self::API_LOG_API_INDEX]][] = $line[self::API_LOG_MESSAGE_INDEX];
            }
        }

        unset($csv);

        return $errorsMap;
    }

}