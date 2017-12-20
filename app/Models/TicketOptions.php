<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class TicketOptions extends MyBaseModel
{

    use SoftDeletes;

    /**
     * The type associated with the question.
     *
     * @access public
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function type()
    {
        return $this->belongsTo(\App\Models\TicketOptionsType::class);
    }

    /**
     * The tickets associated with the option.
     *
     * @access public
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ticket()
    {
        return $this->belongsTo(\App\Models\Ticket::class);
    }

    /**
     * The options associated with the option block
     *
     * @access public
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function options()
    {
        return $this->hasMany(\App\Models\TicketOptionsDetails::class);
    }

    /**
     * The rules to validate the model.
     *
     * @var array $rules
     */
    public $rules = [
        'title'              => ['required'],
    ];
    /**
     * The validation error messages.
     *
     * @var array $messages
     */
    public $messages = [
        'title.required'             => 'You must at least give a title for your block option. (e.g Early Bird)',
    ];

    /**
     * Scope a query to only include active options.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIsEnabled($query)
    {
        return $query->where('is_enabled', 1);
    }

}
