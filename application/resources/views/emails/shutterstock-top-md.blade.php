@component('mail::message')
# Your ShutterStock search results

@component('mail::table')
    | Images        |
    | ------------- |
    @foreach ($images as $key => $image)
    | [Image # {{ $key+1 }}]({{ $image }}) |
    @endforeach
@endcomponent

{{ config('app.name') }}
@endcomponent
