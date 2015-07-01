<?php

namespace Screecher\Tests\Services;

use Screecher\Service\ApiLogParser;

class ApiLogParserTest extends \PHPUnit_Framework_TestCase
{
    public function testParseSuccess()
    {
        $apiLogParser = new ApiLogParser(__DIR__ . '/../Mocks/apiUsageLogMock.log');
        $result = $apiLogParser->parse();

        //check have found AppleAPI errors
        $this->assertArrayHasKey('AppleAPI', $result);
        $this->assertEquals(4, count($result['AppleAPI']));
    }

    public function testWrongPathException()
    {
        $apiLogParser = new ApiLogParser(__DIR__ . '/../Mocks/wrongpath.log');
        $this->setExpectedException('Screecher\Exception\ApiLogWrongPathException');
        $apiLogParser->parse();
    }
}