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
        $users = User::with('life_insurance','vehicle_insurance','mutual_fund','mediclaim','roles')->whereHas('roles', function($query) {
            $query->where('name','member');
        })->get();
        foreach($users[0]->vehicle_insurance as $us){
            $created_at = $us->created_at;
            $futureDate=date($created_at, strtotime('+1 year'));
            if(strtotime($created_at)==strtotime($futureDate)){
                $user_update = User::whereId($us->user_id)->update([
                    'isActive' => 1,
                ]);
            }
        }
        
        foreach($users[0]->life_insurance as $life_ins){
            $created_at = $life_ins->created_at;
            $futureDate=date($created_at, strtotime('+1 year'));
            if(strtotime($created_at)==strtotime($futureDate)){
                $user_update = User::whereId($life_ins->user_id)->update([
                    'isActive' => 1,
                ]);
            }
        }

        foreach($users[0]->mediclaim as $medi){
            $created_at = $medi->created_at;
            $futureDate=date($created_at, strtotime('+1 year'));
            if(strtotime($created_at)==strtotime($futureDate)){
                $user_update = User::whereId($medi->user_id)->update([
                    'isActive' => 1,
                ]);
            }
        }
        foreach($users[0]->mutual_fund as $mf){
            $created_at = $mf->created_at;
            $futureDate=date($created_at, strtotime('+1 year'));
            if(strtotime($created_at)==strtotime($futureDate)){
                $user_update = User::whereId($mf->user_id)->update([
                    'isActive' => 1,
                ]);
            }
        }
    }
}
