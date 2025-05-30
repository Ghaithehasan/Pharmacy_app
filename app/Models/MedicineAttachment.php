<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicineAttachment extends Model
{
    protected $fillable = [
        'medicine_id',
        'file_name',
        'file_path'
    ];

    // العلاقة مع الدواء
    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
} 