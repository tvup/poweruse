<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Crypt;
use Symfony\Component\Console\Output\ConsoleOutput;

/**
 * @property ConsoleOutput $consoleOutput
 */
return new class extends Migration
{
    private ConsoleOutput $consoleOutput;

    public function __construct()
    {
        $this->consoleOutput = new ConsoleOutput();
    }


    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $users = DB::table('users')
            ->get();
        $affected = 0;
        /** @var User $user */
        foreach ($users as $user) {
            $affected = $affected + DB::table('users')
                ->where('id', $user->id)
                ->update(['refresh_token' => Crypt::encryptString($user->refresh_token)]);
        }
        $this->consoleOutput->writeln($affected . ' users have had their refresh_token encrypted');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $users = DB::table('users')
            ->get();
        $affected = 0;
        /** @var User $user */
        foreach ($users as $user) {
            $affected = $affected + DB::table('users')
                    ->where('id', $user->id)
                    ->update(['refresh_token' => Crypt::decryptString($user->refresh_token)]);
        }
        $this->consoleOutput->writeln($affected . ' users have had their refresh_token decrypted');
    }
};
