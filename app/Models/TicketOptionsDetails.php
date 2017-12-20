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
    public $messages = [
        'price.numeric'              => 'The price must be a valid number (e.g 12.50)',
        'title.required'             => 'You must at least give a title for your option. (e.g Early Bird)',
    ];

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

    public function getTitleWithPriceAttribute()
    {
        return $this->title . ' (' . money($this->price, $this->ticket->event->currency) .')';
    }
}
