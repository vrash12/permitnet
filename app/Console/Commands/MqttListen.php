<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('app:mqtt-listen')]
#[Description('Command description')]
class MqttListen extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
    }
}
