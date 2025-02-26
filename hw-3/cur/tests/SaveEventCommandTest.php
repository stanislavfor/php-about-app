<?php

use PHPUnit\Framework\TestCase;


class SaveEventCommandTest extends TestCase
{
    /**
     * @dataProvider isNeedHelpDataProvider
     */


    public function testIsNeedHelp(array $options, bool $isNeedHelp)
    {
        $saveEventCommand = new \App\Commands\SaveEventCommand(new \App\Application(dirname(__DIR__)));

        $result = $saveEventCommand->isNeedHelp($options);

        self::assertEquals($result, $isNeedHelp);
    }

    public function isNeedHelpDataProvider()
    {
        return [
            [
                [
                    'name' => "some-name",
                    'text' => "some-text",
                    'receiver' => "some-reciver",
                    'cron' => "some-cron",
                ],
                false
            ],
            [
                [
                    'name' => "some-name",
                    'text' => "some-text",
                    'receiver' => "some-reciver",
                    'cron' => "some-cron",
                    'help' => 'some-help',
                    'h' => null,
                ],
                true
            ],
            [
                [
                    'name' => "some-name",
                    'text' => "some-text",
                    'receiver' => "some-reciver",
                    'cron' => "some-cron",
                    'help' => null,
                    'h' => 'some-h',
                ],
                true
            ],
            [
                [
                    'name' => "some-name",
                    'text' => "some-text",
                    'receiver' => "some-reciver",
                    'cron' => null,
                ],
                true
            ],
            [
                [
                    'name' => "some-name",
                    'text' => "some-text",
                    'receiver' => null,
                    'cron' => "some-cron",
                ],
                true
            ],
            [
                [
                    'name' => "some-name",
                    'text' => null,
                    'receiver' => "some-reciver",
                    'cron' => "some-cron",
                ],
                true
            ],
            [
                [
                    'name' => null,
                    'text' => "some-text",
                    'receiver' => "some-reciver",
                    'cron' => "some-cron",
                ],
                true
            ],

        ];
    }
}
