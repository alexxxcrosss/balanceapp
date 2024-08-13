<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Balance;
use App\Models\Operation;
use Exception;
use Illuminate\Support\Facades\Log;

class BalanceOperationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        protected string $email,
        protected int|float $amount,
        protected string $description,
        protected string $type,
        public $tries = 1
    ) {}

    /**
     * handle
     * 
     * @return void
     */
    public function handle()
    {
        DB::transaction(function () {
            $user = User::where('email', $this->email)->first();

            if (!$user) {
                $message = "Пользователь {$this->email} не найден";
                Log::error($message);
                throw new Exception($message);
            }

            $balance = $user->balance;
            if (!$balance) {
                $balance = Balance::create([
                    'user_id' => $user->id,
                    'amount' => 0,
                ]);
            }

            if ($this->type === 'increase') {
                $balance->amount += $this->amount;
            } elseif ($this->type === 'decrease') {

                if ($balance->amount < $this->amount) {
                    $message = 'Не достаточно средств';
                    Log::error($message);
                    throw new Exception($message );
                }
                $balance->amount -= $this->amount;
            }
            $balance->save();

            Operation::create([
                'user_id' => $user->id,
                'amount' => $this->amount,
                'description' => $this->description,
                'type' => $this->type,
            ]);
        });
    }
}
