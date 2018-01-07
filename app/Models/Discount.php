<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Discount extends MyBaseModel
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
        'type'               => ['required', 'in:amount,percentage'],
        'start_sale_date'    => ['date'],
        'end_sale_date'      => ['date', 'after:start_sale_date'],
        'code'               => ['required', 'alpha_num', 'size:8'],
        'quantity_available' => ['integer', 'min:0'],
    ];

    /**
     * The validation error messages.
     *
     * @var array $messages
     */
    public function messages() {
        return [
            'price.numeric'              => __('models_discount.price_numeric'),
            'title.required'             => __('models_discount.title_required'),
            'code.alpha_num'             => __('models_discount.code_alpha_num'),
            'quantity_available.integer' => __('models_discount.quantity_available_integer'),
        ];
    }

    /**
     * The event associated with the discount.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function event()
    {
        return $this->belongsTo(\App\Models\Event::class);
    }

    /**
     * The order(s) associated with the discount.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasToMany
     */
    public function orders()
    {
        return $this->hasMany(\App\Models\Order::class);
    }

    /**
     * Get the number of discounts remaining.
     *
     * @return \Illuminate\Support\Collection|int|mixed|static
     */
    public function getQuantityRemainingAttribute()
    {
        if (is_null($this->quantity_available)) {
            return 9999; //Better way to do this?
        }

        return $this->quantity_available - $this->orders->count();
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
