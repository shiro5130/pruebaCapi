<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $fillable = ['street', 'city', 'state', 'postal_code', 'contact_id'];

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
}
