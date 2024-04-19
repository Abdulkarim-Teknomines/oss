<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
Use Carbon;
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
        
        // foreach($users[0]->vehicle_insurance as $us){
        //     $created_at = strtotime($us->created_at);
        //     $time = date('Y-m-d H:i:s');
        //     $new_time = $created_at + (365 * 24 * 60 * 60);
            
        //     $futureDate =date("Y-m-d H:i:s", $new_time);
        //     \Log::info($futureDate);
        //     do {
        //         if(strtotime($futureDate) == strtotime($time)){
        //             $user_update = User::whereId($us->user_id)->update([
        //                 'isActive' => 1,
        //             ]);
        //         }
        //     }while(strtotime($time) == strtotime($futureDate));
        // }
        // foreach($users[0]->life_insurance as $li){
        //     $created_at = strtotime($li->created_at);
        //     $time = date('Y-m-d H:i:s');
        //     $new_time = $created_at + (365 * 24 * 60 * 60);
        //     $futureDate =date("Y-m-d H:i:s", $new_time);
        //     do {
        //         if(strtotime($futureDate) == strtotime($time)){
        //             $user_update = User::whereId($li->user_id)->update([
        //                 'isActive' => 1,
        //             ]);
        //         }
        //     }while(strtotime($time) == strtotime($futureDate));
        // }

        // foreach($users[0]->mediclaim as $med){
        //     $created_at = strtotime($med->created_at);
        //     $time = date('Y-m-d H:i:s');
        //     $new_time = $created_at + (365 * 24 * 60 * 60);
        //     $futureDate =date("Y-m-d H:i:s", $new_time);
        //     do {
        //         if(strtotime($futureDate) == strtotime($time)){
        //             $user_update = User::whereId($med->user_id)->update([
        //                 'isActive' => 1,
        //             ]);
        //         }
        //     }while(strtotime($time) == strtotime($futureDate));
        // }
        
        // foreach($users[0]->mutual_fund as $mf){
        //     $created_at = strtotime($mf->created_at);
        //     $time = date('Y-m-d H:i:s');
        //     $new_time = $created_at + (365 * 24 * 60 * 60);
        //     $futureDate =date("Y-m-d H:i:s", $new_time);
        //     do {
        //         if(strtotime($futureDate) == strtotime($time)){
        //             $user_update = User::whereId($mf->user_id)->update([
        //                 'isActive' => 1,
        //             ]);
        //         }
        //     }while(strtotime($time) == strtotime($futureDate));
        // }
    }
}
