<x-mail::message>
# Hello,

Your two-factor login code is: **{{ $code }}**

This code will expire in 10 minutes.

If you did not attempt to log in, please secure your account.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
