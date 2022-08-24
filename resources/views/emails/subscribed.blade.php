@component('mail::message')
# Thank you!

{{$topic}}

If you want to unsubscribe you can click the button below
@component('mail::button', ['url' => route('newsletters.unsubscribe',$email)])
  Unsubscribe
@endcomponent
Thanks,<br>
{{ config('app.name') }}
@endcomponent