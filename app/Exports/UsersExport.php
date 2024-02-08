<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithHeadings
{
    // 07330322770001D
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // $user= User::select("id", "name", "email")->get();
        $data = [];
        $users = User::with('roles')->select("id", "name", "email")->get();
        $i=0;
        foreach($users as $user){
            //  $user->getRoleNames();  
            $data[]=array(
                'id'=>$user->id,
                'name'=>$user->name,
                'email'=>$user->email,
                
            );
            foreach($user->roles as $role){
                $data[$i]['role'] = $role->name;
            }
            $i++;
        }
        // return Response::json($data->toArray());
        return collect($data);
        // dd($data);
        

    }
    public function headings(): array
    {
        return ["ID", "Name", "Email","Role"];
    }
}
