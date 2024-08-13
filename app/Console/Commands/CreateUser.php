<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CreateUser extends Command
{
    protected $signature = 'user:create {email} {password}';

    protected $description = 'Создание нового пользователя';

    public function handle()
    {
        $email = $this->argument('email');
        $password = bcrypt($this->argument('password'));

        $existsUser = User::where('email', $email)->first();
        if($existsUser) {
            return $this->info("Пользователь с email {$email} уже существует");
        }

        $user = User::create(['name' => $email, 'email' => $email, 'password' => $password]);
        $this->info("Пользователь {$user->email} успешно создан");
    }
}
