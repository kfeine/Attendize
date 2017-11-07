<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class TicketOptions extends MyBaseModel
{

    use SoftDeletes;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The rules to validate the model.
     *
     * @var array $rules
     */
    public $rules = [
        'title'              => ['required'],
        'description'        => ['required'],
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
     * The tickets associated with the option.
     *
     * @access public
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tickets()
    {
        return $this->belongsToMany(\App\Models\Ticket::class);
    }
}
