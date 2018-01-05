@if($event->images->count())
<section id="details" class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-2">
            </div>
            <div class="col-md-8">
                <div class="content event_poster">
                    <img alt="{{$event->title}}" src="{{config('attendize.cdn_url_user_assets').'/'.$event->images->first()['image_path']}}" property="image">
                </div>
            </div>
        </div>
    </div>
</section>
@endif
