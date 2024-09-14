<?php

namespace App\UI\CLI\Command;

use Illuminate\Console\Command;

class DeleteOldPayableCommand extends Command
{
    protected $signature = 'app:delete-payable';

    public function handle()
    {
        $this->call(DeleteOldSubscriptionCommand::class);
        $this->call(DeleteOldOrdersCommand::class);
    }
}
