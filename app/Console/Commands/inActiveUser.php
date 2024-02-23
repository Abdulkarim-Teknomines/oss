<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

use App\Models\User;
class inActiveUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:in-active-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    
    public function handle()
    {
        $data = User::with('life_insurance','vehicle_insurance','mutual_fund','mediclaim','roles')->whereHas('roles', function($query) {
            $query->where('name','member');
        })->get();
        
    }
}
