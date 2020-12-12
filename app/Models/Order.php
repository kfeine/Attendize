<?php

namespace App\Models;

use File;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends MyBaseModel
{
    use SoftDeletes;

    /**
     * The validation rules of the model.
     *
     * @var array $rules
     */
    public $rules = [
        'order_first_name' => ['required'],
        'order_last_name'  => ['required'],
        'order_email'      => ['required', 'email'],
        'order_phone'      => ['required'],
        'order_address_line_1'      => ['required'],
        'order_city'      => ['required'],
        'order_postal_code'      => ['required'],
    ];

    /**
     * The validation error messages.
     *
     * @var array $messages
     */
    public function messages() {
        return [
            'order_first_name.required'     => __('models_order.order_first_name_required'),
            'order_last_name.required'      => __('models_order.order_last_name_required'),
            'order_email.email'             => __('models_order.order_email_email'),
            'order_phone.required'          => __('models_order.order_phone_required'),
            'order_address_line_1.required' => __('models_order.order_address_line_1_required'),
            'order_city.required'           => __('models_order.order_city_required'),
            'order_postal_code.required'    => __('models_order.order_postal_code_required'),
        ];
    }

    /**
     * The items associated with the order.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderItems()
    {
        return $this->hasMany(\App\Models\OrderItem::class);
    }

    /**
     * The discount associated with the order.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function discount()
    {
        return $this->belongsTo(\App\Models\Discount::class);
    }

    /**
     * The attendees associated with the order.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attendees()
    {
        return $this->hasMany(\App\Models\Attendee::class);
    }

    /**
     * The account associated with the order.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account()
    {
        return $this->belongsTo(\App\Models\Account::class);
    }

    /**
     * The event associated with the order.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function event()
    {
        return $this->belongsTo(\App\Models\Event::class);
    }

    /**
     * The tickets associated with the order.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tickets()
    {
        return $this->hasMany(\App\Models\Ticket::class);
    }


    public function payment_gateway()
    {
        return $this->belongsTo(\App\Models\PaymentGateway::class);
    }

    /**
     * The status associated with the order.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function orderStatus()
    {
        return $this->belongsTo(\App\Models\OrderStatus::class);
    }


    /**
     * Get the organizer fee of the order.
     *
     * @return \Illuminate\Support\Collection|mixed|static
     */
    public function getOrganiserAmountAttribute()
    {
        return $this->amount + $this->organiser_booking_fee;
    }

    /**
     * Get the total amount of the order.
     *
     * @return \Illuminate\Support\Collection|mixed|static
     */
    public function getTotalAmountAttribute()
    {
        return $this->amount + $this->organiser_booking_fee + $this->booking_fee;
    }

    /**
     * Get the full name of the order.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Boot all of the bootable traits on the model.
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if(empty($order->order_reference)){
              $order->order_reference = strtoupper(str_random(5)) . date('jn'). strtoupper(iconv('UTF-8', 'ASCII//TRANSLIT', substr($order->last_name, 0, 5)));
              //$order->order_reference = strtoupper(uniqid());
            }
        });
    }
}
