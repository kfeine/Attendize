<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class TicketOptions extends MyBaseModel
{

    use SoftDeletes;
    use \Askedio\SoftCascade\Traits\SoftCascadeTrait;

    protected $softCascade = ['options'];

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
        // order by option_order
        return $this->hasMany(\App\Models\TicketOptionsDetails::class)->orderBy('option_order', 'ASC');
    }
    /**
     * The options associated with the option block
     *
     * @access public
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function options_by_id()
    {
        // order by id
        return $this->hasMany(\App\Models\TicketOptionsDetails::class);
    }

    public function getOptionsEnabledAttribute()
    {
        return $this->options->filter(function($value, $key) {
            return $value->is_enabled;
        });
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
    public function messages() {
        return [
            'title.required' => __('models_ticketoptions.title_required'),
        ];
    }

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
