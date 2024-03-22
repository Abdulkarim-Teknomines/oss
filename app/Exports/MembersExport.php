<?php

namespace App\Exports;

use App\Models\User;
use App\Models\Member;
use App\Models\State;
use App\Models\City;
use App\Models\PolicyType;
use App\Models\VehicleCategory;
use App\Models\VehicleInsurance;
use App\Models\Children;
use App\Models\CompanyName;
use App\Models\InsurancePolicyType;
use App\Models\Lifeinsurance;
use App\Models\Mediclaim;
use App\Models\Mutualfund;
use Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MembersExport implements FromCollection, WithHeadings
{
    // 07330322770001D
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $id;

    function __construct($id) {
            $this->id = $id;
    }
    public function collection()
    {
        $datad = [];
        $export = [];
        $data = User::with('mediclaim','life_insurance','mutual_fund','vehicle_insurance')->where('id',$this->id)->first()->toArray();
        $d3 = array_merge($data['mediclaim'],$data['life_insurance'],$data['mutual_fund'],$data['vehicle_insurance']);
        $i=0;
        $jan_sum =0;
        $feb_sum =0;
        $mar_sum =0;
        $apr_sum =0;
        $may_sum =0;
        $jun_sum =0;
        $jul_sum =0;
        $aug_sum =0;
        $sep_sum =0;
        $oct_sum =0;
        $nov_sum =0;
        $dec_sum =0;
        $single_sum=0;
        $sub_tot =0;
        foreach($d3 as $member){
            $jan_sum+=$member['jan'];
            $feb_sum+=$member['feb'];
            $mar_sum+=$member['mar'];
            $apr_sum+=$member['apr'];
            $may_sum+=$member['may'];
            $jun_sum+=$member['jun'];
            $jul_sum+=$member['jul'];
            $aug_sum+=$member['aug'];
            $sep_sum+=$member['sep'];
            $oct_sum+=$member['oct'];
            $nov_sum+=$member['nov'];
            $dec_sum+=$member['dec'];
            $single_sum+=$member['single'];
            $plan_name='';
            if(isset($member['policy_name'])){
                $plan_name= $member['policy_name'];
            }elseif(isset($member['fund_name'])){
                $plan_name=$member['fund_name'];
            }elseif(isset($member['plan_name'])){
                $plan_name=$member['plan_name'];
            }elseif(isset($member['company_name'])){
                $plan_name=$member['company_name'];
            }
            if(isset($member['category'])){
                $category = $member['category'];
            }
            $datad[]=array(
                'name'=>$plan_name,
                'category'=>$category,
                'jan'=>number_format($member['jan'],0),
                'feb'=>number_format($member['feb'],0),
                'mar'=>number_format($member['mar'],0),
                'apr'=>number_format($member['apr'],0),
                'may'=>number_format($member['may'],0),
                'jun'=>number_format($member['jun'],0),
                'jul'=>number_format($member['jul'],0),
                'aug'=>number_format($member['aug'],0),
                'sep'=>number_format($member['sep'],0),
                'oct'=>number_format($member['oct'],0),
                'nov'=>number_format($member['nov'],0),
                'dec'=>number_format($member['dec'],0),
                'single'=>number_format($member['single'],0),
                'total' => $member['jan']+$member['feb']+$member['mar']+$member['apr']+$member['may']+$member['jun']+$member['jul']+$member['aug']+$member['sep']+$member['oct']+$member['nov']+$member['dec'],
            );
        }
        $new_arr[]=array(
            'name'=>'Total',
            'category'=>'',
            'jan'=>number_format($jan_sum,0),
            'feb'=>number_format($feb_sum,0),
            'mar'=>number_format($mar_sum,0),
            'apr'=>number_format($apr_sum,0),
            'may'=>number_format($may_sum,0),
            'jun'=>number_format($jun_sum,0),
            'jul'=>number_format($jul_sum,0),
            'aug'=>number_format($aug_sum,0),
            'sep'=>number_format($sep_sum,0),
            'oct'=>number_format($oct_sum,0),
            'nov'=>number_format($nov_sum,0),
            'dec'=>number_format($dec_sum,0),
            'single'=>number_format($single_sum,0),
            'total' => $jan_sum+$feb_sum+$mar_sum+$apr_sum+$may_sum+$jun_sum+$jul_sum+$aug_sum+$sep_sum+$oct_sum+$nov_sum+$dec_sum,
        );
        $ars = array_merge($datad,$new_arr);
        return collect($ars);
    }
    
    public function headings(): array
    {
        return ["Name","Category", "Jan", "Feb","Mar","Apr", "May", "Jun","Jul", "Aug", "Sep","Oct","Nov", "Dec", "Single","Total"];
    }
}
