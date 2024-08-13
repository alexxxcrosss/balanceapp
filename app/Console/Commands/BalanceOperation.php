<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\BalanceOperationJob;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\DB;

class BalanceOperation extends Command
{
    protected $signature = 'balance:process {email} {amount} {description} {type}';
    protected $description = 'Обновление баланса пользователя';

    public function handle()
    {
        $email = $this->argument('email');
        $amount = (float) $this->argument('amount');
        $description = $this->argument('description');
        $type = $this->argument('type');

        if (!in_array($type, ['increase', 'decrease'])) {
            $this->error('Недопустимый аргумент type');
            return;
        }

        $job = new BalanceOperationJob($email, $amount, $description, $type);
        Queue::push($job);

        $this->info('Операция помещена в очередь');
    }
}
