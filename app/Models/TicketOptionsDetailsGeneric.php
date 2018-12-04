<?php

namespace App\Models;

class TicketOptionsDetailsGeneric extends MyBaseModel
{

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @access protected
     * @var array
     */
    protected $fillable = ['title'];

    /**
     * The rules to validate the model.
     *
     * @var array $rules
     */
    public $rules = [
        'title'              => ['required'],
        'quantity_available' => ['integer', 'min:0'],
    ];
    /**
     * The validation error messages.
     *
     * @var array $messages
     */
    public function messages() {
       return [
            'title.required' => __('models_ticketoptionsdetailsgeneric.title_required'),
            'quantity_available.integer' => __('models_ticketoptionsdetailsgeneric.quantity_available_integer'),
        ];
    }
    public $validation_messages = [];

    /**
     * Scope a query to only include options generic that are sold out.
     *
     * @param $query
     */
    public function scopeSoldOut($query)
    {
        $query->where('remaining_tickets', '=', 0);
    }

    /**
     * Get the number of options generic remaining.
     *
     * @return \Illuminate\Support\Collection|int|mixed|static
     */
    public function getQuantityRemainingAttribute()
    {
        if (is_null($this->quantity_available)) {
            return 9999; //Better way to do this?
        }

        return $this->quantity_available - ($this->quantity_sold + $this->quantity_reserved);
    }

    /**
     * Get the number of options generic reserved.
     *
     * @return mixed
     */
    public function getQuantityReservedAttribute()
    {
        $reserved_total = \DB::table('reserved_options_generics')
            ->where('ticket_options_details_generic_id', $this->id)
            ->where('expires', '>', \Carbon::now())
            ->sum('quantity_reserved');

        return $reserved_total;
    }

}
