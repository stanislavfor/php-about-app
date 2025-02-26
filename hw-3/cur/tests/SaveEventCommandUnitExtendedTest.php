<?php

use PHPUnit\Framework\TestCase;

class SaveEventCommandUnitExtendedTest extends TestCase
{
    /**
     * Test getGetoptOptionValues method.
     */

    public function testGetGetoptOptionValues()
    {
        $saveEventCommand = new \App\Commands\SaveEventCommand(new \App\Application(dirname(__DIR__)));

        // Mocking getopt function
        $options = [
            'name' => 'Event Name',
            'text' => 'Event Text',
            'receiver' => 'Receiver ID',
            'cron' => '* * * * *',
        ];

        $getoptMock = $this->getFunctionMock('App\Commands', "getopt");
        $getoptMock->expects($this->any())
            ->willReturn($options);

        $result = $saveEventCommand->getGetoptOptionValues();
        self::assertEquals($options, $result);
    }

    /**
     * Test getCronValues method.
     *
     * @dataProvider getCronValuesDataProvider
     */

    public function testGetCronValues(string $cronString, array $expected)
    {
        $saveEventCommand = new \App\Commands\SaveEventCommand(new \App\Application(dirname(__DIR__)));
        $result = $saveEventCommand->getCronValues($cronString);
        self::assertEquals($expected, $result);
    }

    public function getCronValuesDataProvider()
    {
        return [
            ['* * * * *', [null, null, null, null, null]],
            ['1 2 3 4 5', [1, 2, 3, 4, 5]],
            ['1 * 3 4 *', [1, null, 3, 4, null]],
        ];
    }

    /**
     * Test saveEvent method.
     */


    public function testSaveEvent()
    {
        $appMock = $this->createMock(\App\Application::class);
        $sqliteMock = $this->createMock(\App\Database\SQLite::class);
        $eventMock = $this->getMockBuilder(\App\Models\Event::class)
            ->setConstructorArgs([$sqliteMock])
            ->onlyMethods(['insert'])
            ->getMock();

        $eventMock->expects($this->once())
            ->method('insert')
            ->with(
                'name, text, receiver_id, minute, hour, day, month, day_of_week',
                ['Event Name', 'Event Text', 'Receiver ID', '*', '*', '*', '*', '*']
            );

        $saveEventCommand = new \App\Commands\SaveEventCommand($appMock);

        $params = [
            'name' => 'Event Name',
            'text' => 'Event Text',
            'receiver_id' => 'Receiver ID',
            'minute' => '*',
            'hour' => '*',
            'day' => '*',
            'month' => '*',
            'day_of_week' => '*',
        ];

        $saveEventCommand->saveEvent($params);
    }
}
