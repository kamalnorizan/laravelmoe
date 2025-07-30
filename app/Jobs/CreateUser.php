<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Str;
use Illuminate\Support\Facades\Hash;
use App\Notifications\UserRegistered;
class CreateUser implements ShouldQueue
{
    use Queueable;
    protected $name;
    protected $email;
    protected $sekolah_id;
    /**
     * Create a new job instance.
     */
    public function __construct($name, $email, $sekolah_id)
    {
        $this->name = $name;
        $this->email = $email;
        $this->sekolah_id = $sekolah_id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $user = new User();
        $user->name = $this->name;
        $user->email = $this->email;
        $user->sekolah_id = $this->sekolah_id;
        $pass = Str::random(12);
        $user->password = Hash::make($pass);
        $user->save();

        $user->notify(new UserRegistered($pass));
    }
}
