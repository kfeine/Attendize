<?php

namespace App\Models;

class TicketOptionsDetails extends MyBaseModel
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
        'price'              => ['required', 'numeric', 'min:0'],
    ];
    /**
     * The validation error messages.
     *
     * @var array $messages
     */
    public function messages() {
       return [
            'price.numeric'  => __('models_ticketoptionsdetails.price_numeric'),
            'title.required' => __('models_ticketoptionsdetails.title_required'),
        ];
    }

    /**
     * The Option associated with the option details.
     *
     * @access public
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ticket_options()
    {
        return $this->belongsTo(\App\Models\TicketOptions::class);
    }

    /**
     * The Option Generic associated with the option details.
     *
     * @access public
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ticket_options_details_generic()
    {
        return $this->belongsTo(\App\Models\TicketOptionsDetailsGeneric::class);
    }

    public function getTitleWithPriceAttribute()
    {
        return $this->title . ' (' . money($this->price, $this->ticket_options->ticket->event->currency) .')';
    }
}
