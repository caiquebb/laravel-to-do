@component('mail::message')
# Shared To Do

{{ $userName }} shared a To Do List with you.

@component('mail::button', ['url' => $todoUrl])
View To Do
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
