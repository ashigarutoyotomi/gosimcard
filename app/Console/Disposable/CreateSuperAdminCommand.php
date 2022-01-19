<?php

namespace App\Console\Disposable;

use App\Domains\User\Actions\UserAction;
use App\Domains\User\Models\User;
use Illuminate\Console\Command;
use App\Domains\User\DTO\UserDTO\CreateUserData;

class CreateSuperAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'super_user:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create super user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info("Starting create super user");
        $this->info("");

        try {
            (new UserAction())->create(new CreateUserData([
                'name' => 'Anakin Skywalker',
                'email' => 'skywalker@mail.com',
                'password' => bcrypt('!I666am222DARth999VADer!'),
                'role' => User::USER_ROLE_ADMIN,
            ]));

            $this->info("Super user successfully created!");
        } catch (\Exception $e) {
            $this->info($e->getMessage());
        }
    }
}
