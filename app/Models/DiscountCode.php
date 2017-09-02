<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class DiscountCode extends MyBaseModel
{
    use SoftDeletes;

    /**
     * The rules to validate the model.
     *
     * @var array $rules
     */
    public $rules = [
        'title'              => ['required'],
        'price'              => ['required', 'numeric', 'max:0'],
        'start_sale_date'    => ['date'],
        'end_sale_date'      => ['date', 'after:start_sale_date'],
        'code'               => ['required', 'alpha_num', 'size:8'],
    ];

    /**
     * The validation error messages.
     *
     * @var array $messages
     */
    public $messages = [
        'price.numeric'              => 'The price must be a valid negative number (e.g -12.50)',
        'title.required'             => 'You must at least give a title for your ticket. (e.g Special discount)',
        'code.alpha_num'             => 'The code should be 8 alpha numerical characters (e.g ABCD1234).',
    ];

    /**
     * The event associated with the discount code.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function event()
    {
        return $this->belongsTo(\App\Models\Event::class);
    }

    /**
     * The order(s) associated with the discount code.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function order()
    {
        return $this->belongsToMany(\App\Models\Order::class);
    }

    /**
     * The attributes that should be mutated to dates.
     *
     * @return array $dates
     */
    public function getDates()
    {
        return ['start_sale_date', 'end_sale_date'];
    }
}
