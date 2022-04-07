<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mtvs\EloquentHashids\HasHashid;
use Mtvs\EloquentHashids\HashidRouting;

class SaleDetail extends Model
{
    use HasFactory;
    use HasFactory, HasHashid, HashidRouting;

    protected $appends = ['hashid'];
    protected $guarded = [];

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
}
