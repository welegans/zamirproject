@component('mail::message')
<h3>  # Order cnfirmed</h3>
<p>
  Order has been cnfirmed. <br>
  {{-- Your total price {{$order->total}} --}}
</p>
@component('mail::button', ['url' => '$url'])
View Order
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
