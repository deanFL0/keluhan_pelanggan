<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeluhanPelanggan extends Model
{
    use HasFactory;
    public $timestamps = false; 
    protected $table = 'keluhan_pelanggan';

    protected $fillable = [
        'nama',
        'email',
        'nomor_hp',
        'status_keluhan',
        'keluhan',
    ];
    public function statusHistory()
    {
        return $this->hasMany(KeluhanStatusHis::class, 'keluhan_id');
    }
}
