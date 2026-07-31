<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['reference', 'provider', 'provider_reference', 'order_number', 'amount', 'amount_customer', 'phone', 'currency', 'channel', 'reason', 'entity', 'entity_id', 'type', 'status', 'user_id'])]
class Payment extends Model {}
