<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\AccountHeads;
use App\Models\Backend\Account;

class BankTransaction extends Model
{
    use HasFactory;

    // Get all row. Descending order using scope.
    public function scopeOrderByDesc($query, $data)
    {
        $query->orderBy($data, 'desc');
    }

    public function getAccountTypeAttribute()
    {
        if($this->type      == AccountHeads::INCOME){
            $type =  __('AccountHeads.'.AccountHeads::INCOME) ;
        }elseif($this->type == AccountHeads::EXPENSE){
            $type = __('AccountHeads.'.AccountHeads::EXPENSE);
        }
        return $type;
    }

    
    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }

}
