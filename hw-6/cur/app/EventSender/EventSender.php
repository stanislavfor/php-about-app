<?php

namespace App\EventSender;

use App\Queue\Queue;
use App\Queue\Queueable;
use App\Telegram\TelegramApi;

class EventSender implements Queueable
{
//    private TelegramApi $telegram;
    private string $receiver;
    private string $message;


    public function __construct(
        TelegramApi $telegram,
        private Queue   	$queue
    )
    {
//        $this->telegram = $telegram;
    }

    public function sendMessage(string $receiver, string $message)
    {
//        $this->telegram->sendMessage($receiver, $message);
//        echo date('d.m.y H:i') . " Я отправил сообщение $message получателю с id $receiver\n";
        $this->toQueue($receiver, $message);

    }

    public function handle(): void
    {
//        var_dump(4444, $this->receiver,$this->message);
        $this->telegram->sendMessage($this->receiver, $this->message);
    }

    public function toQueue(...$args): void
    {
        $this->receiver = $args[0];
        $this->message = $args[1];

        $this->queue->sendMessage(serialize($this));
    }



}