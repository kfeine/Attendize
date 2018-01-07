<?php

namespace App\Models;

use Illuminate\Http\UploadedFile;
use Str;
use Image;
use Log;

class Organiser extends MyBaseModel
{
    /**
     * The validation rules for the model.
     *
     * @var array $rules
     */
    protected $rules = [
        'name'           => ['required'],
        'email'          => ['required', 'email'],
        'email2'         => ['email'],
        'email3'         => ['email'],
        'email4'         => ['email'],
        'email5'         => ['email'],
        'organiser_logo' => ['mimes:jpeg,jpg,png', 'max:10000'],
    ];

    /**
     * The validation error messages for the model.
     *
     * @var array $messages
     */
    protected function messages() {
        return [
            'name.required'        => __('models_organiser.name_required'),
            'organiser_logo.max'   => __('models_organiser.organiser_logo_max'),
            'organiser_logo.size'  => __('models_organiser.organiser_logo_size'),
            'organiser_logo.mimes' => __('models_organiser.organiser_logo_mimes'),
        ];
    }

    /**
     * The account associated with the organiser
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account()
    {
        return $this->belongsTo(\App\Models\Account::class);
    }

    /**
     * The events associated with the organizer.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function events()
    {
        return $this->hasMany(\App\Models\Event::class);
    }

    /**
     * The attendees associated with the organizer.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function attendees()
    {
        return $this->hasManyThrough(\App\Models\Attendee::class, \App\Models\Event::class);
    }

    /**
     * Get the orders related to an organiser
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function orders()
    {
        return $this->hasManyThrough(\App\Models\Order::class, \App\Models\Event::class);
    }

    /**
     * Get the full logo path of the organizer.
     *
     * @return mixed|string
     */
    public function getFullLogoPathAttribute()
    {
        if ($this->logo_path && (file_exists(config('attendize.cdn_url_user_assets') . '/' . $this->logo_path) || file_exists(public_path($this->logo_path)))) {
            return config('attendize.cdn_url_user_assets') . '/' . $this->logo_path;
        }

        return config('attendize.fallback_organiser_logo_url');
    }

    /**
     * Get the url of the organizer.
     *
     * @return string
     */
    public function getOrganiserUrlAttribute()
    {
        return route('showOrganiserHome', [
            'organiser_id'   => $this->id,
            'organiser_slug' => Str::slug($this->oraganiser_name),
        ]);
    }

    /**
     * Get all emails
     *
     * @return array
     */
    public function getEmailsAttribute()
    {
        $emails = [$this->email];
        if ($this->email2 != "") { array_push($emails, $this->email2); }
        if ($this->email3 != "") { array_push($emails, $this->email3); }
        if ($this->email4 != "") { array_push($emails, $this->email4); }
        if ($this->email5 != "") { array_push($emails, $this->email5); }

        return $emails;
    }

    /**
     * Get the sales volume of the organizer.
     *
     * @return mixed|number
     */
    public function getOrganiserSalesVolumeAttribute()
    {
        return $this->events->sum('sales_volume');
    }

    /**
     * TODO:implement DailyStats method
     */
    public function getDailyStats()
    {
    }


    /**
     * Set a new Logo for the Organiser
     *
     * @param \Illuminate\Http\UploadedFile $file
     */
    public function setLogo(UploadedFile $file)
    {
        $filename = str_slug($this->name).'-logo-'.$this->id.'.'.strtolower($file->getClientOriginalExtension());

        // Image Directory
        $imageDirectory = public_path() . '/' . config('attendize.organiser_images_path');

        // Paths
        $relativePath = config('attendize.organiser_images_path').'/'.$filename;
        $absolutePath = public_path($relativePath);

        $file->move($imageDirectory, $filename);

        $img = Image::make($absolutePath);

        $img->resize(250, 250, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        $img->save($absolutePath);

        if (file_exists($absolutePath)) {
            $this->logo_path = $relativePath;
        }
    }
}
