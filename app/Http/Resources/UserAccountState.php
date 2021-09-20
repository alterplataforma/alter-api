<?php

namespace App\Http\Resources;

use App\Http\Helpers\UtilHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class UserAccountState extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'                        => $this->id,
            'name'                      => $this->name.' '.$this->last_name,
            'alter_cash'                => number_format($this->alter_cash),
            'income_group'              => round(UtilHelper::caclulate_balance(\request()->user())['income_group']),
            'income_normal'             => round(UtilHelper::caclulate_balance(\request()->user())['total_provider']),
            'biweekly_goal'             => $this->metaquincenal,
            'cutDate'                   => UtilHelper::calculate_date_alter_configuration()['cutDate'],
            'cutDateLast'               => UtilHelper::calculate_date_alter_configuration()['cutDateLast'],
            'income_total'              => round(UtilHelper::caclulate_balance(\request()->user())['income_total']),
            'goal'                      => round(UtilHelper::caclulate_balance(\request()->user())['goal']),
            'with_goal'                 => UtilHelper::caclulate_balance(\request()->user())['with_goal'],
            'expenses'                  => UtilHelper::caclulate_balance(\request()->user())['total_client'],
            'cutDateText'               => UtilHelper::calculate_date_alter_configuration()['cutDateText'],
        ];
    }
}
