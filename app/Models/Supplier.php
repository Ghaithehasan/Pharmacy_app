<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable as AuthAuthenticatable;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Hash;

class Supplier extends Model implements Authenticatable
{
    use SoftDeletes,AuthAuthenticatable;

protected $fillable = [
    'company_name',
    'contact_person_name',
    'bio',
    'phone',
    'email',
    'address',
    'payment_method',
    'credit_limit',
    'is_active',
    'password', // تأكد من إضافة كلمة المرور هنا
];

protected $hidden = [
    'password', // لإخفاء كلمة المرور عند جلب البيانات
];


    // public function products()
    // {
    //     return $this->hasMany(SupplierProduct::class);
    // }

    public function notifications()
    {
        return $this->hasMany(SupplierNotification::class);
    }


    public function payments()
    {
        return $this->hasMany(SupplierPayment::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }


}
