<?php

namespace Krishnawijaya\DodiUkirReport\Commands;

use Krishnawijaya\DodiUkirReport\Http\Controllers\VoyagerAuthController;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use TCG\Voyager\Facades\Voyager;

class AdminCommand extends Command
{
    protected $authService;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dodiukirreport:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Membuat akun admin dengan akses penuh ke sistem.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(VoyagerAuthController $authService)
    {
        parent::__construct();
        $this->authService = $authService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Membuat tabel-tabel di database...');
        Artisan::call("migrate");

        $this->info('Menyiapkan data-data yang diperlukan...');
        Artisan::call("db:seed");
        
        $this->info('Membuat akun admin pertama kali..');
        $user = $this->getUser();

        // the user not returned
        if (!$user) {
            exit;
        }

        // Get or create role
        $role = $this->getAdministratorRole();

        // Get all permissions
        $permissions = Voyager::model('Permission')->all();

        // Assign all permissions to the admin role
        $role->permissions()->sync(
            $permissions->pluck('id')->all()
        );

        // Ensure that the user is admin
        $user->role_id = $role->id;
        $user->save();

        $this->info('Sekarang user sudah memiliki akses penuh ke sistem.');
    }

    /**
     * Get the administrator role, create it if it does not exists.
     *
     * @return mixed
     */
    protected function getAdministratorRole()
    {
        $role = Voyager::model('Role')->firstOrNew([
            'name' => 'admin',
        ]);

        if (!$role->exists) {
            $role->fill([
                'display_name' => 'Admin',
            ])->save();
        }

        return $role;
    }

    /**
     * Get or create user.
     *
     * @param bool $create
     *
     * @return \App\User
     */
    protected function getUser()
    {
        $model = Auth::guard(app('VoyagerGuard'))->getProvider()->getModel();
        $model = Str::start($model, '\\');

        $username = $this->ask('Masukan username admin');

        // check if user with given username exists
        if ($model::where($this->authService->username(), $username)->exists()) {
            $this->info("Gagal membuat user baru, karena username " . $username . ' sudah terpakai.');

            return;
        }

        $name = $this->ask('Masukan nama admin');
        $password = $this->ask('Masukan password admin');
        $alamat = $this->ask('Masukan alamat admin');
        $telepon = $this->ask('Masukan telepon admin');

        $this->info('Membuat akun admin...');

        return call_user_func($model . '::forceCreate', [
            'name'                          => $name,
            'password'                      => Hash::make($password),
            $this->authService->username()  => $username,
            'alamat'                        => $alamat,
            'telepon'                       => $telepon,
        ]);
    }
}
