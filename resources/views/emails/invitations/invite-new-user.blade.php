@if ($Register === false)

@component('mail::message')
# Hi

You Have been Invitated to going our team
**{{$invitation->team->name}}** 
Because you are not yet singed up to the platform,please 
[Register for free]({{ $url}}) , then you can accept or reject the invitation in your team managemnt console .

@component('mail::button', ['url' => '$url'])
Register for free
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent

@else


@component('mail::message')
# Hi

You Have been Invitated to going our team
**{{$invitation->team->name}}** 
you can accept or reject the invitation in your
[team managemnt console]({{ $url}})
@component('mail::button', ['url' => '$url'])
Going The Team
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
    
@endif