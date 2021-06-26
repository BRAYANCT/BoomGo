@component('mail::message')
# Hola {{ $orderGroup-> user-> first_name }},

Gracias, tu pedido se ha generado de forma exitosa.


@foreach($orderGroup->orders as $order)
<p class="h4">Negocio: {{ $order-> business->name }}</p>
<p class="h4">Tu orden: {{ $order-> code }}</p>
<table class="order-items-table">
    <thead>
    <tr>
        <th>Producto</th>
        <th>Precio</th>
        <th>Cantidad</th>
        <th>Subtotal</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($order-> items as $item)
        <tr>
            <td>{{ $item-> name }}</td>
            <td>
                S/ {{ $item->final_price }}
                @if($item->offer_active)
                    <span  class="crossed-out-price" style="margin-left: 5px">
                        S/ {{ $item->price }}
                    </span>
                @endif
            </td>
            <td>{{ $item-> quantity }}</td>

            <td>{{ $item-> sub_total }}</td>
        </tr>
    @endforeach

    </tbody>
    <tfoot>
    <tr>
        <th colspan="2"></th>
        <th >Envío</th>
        <th>S/ {{ $order-> shipping_price }}</th>
    </tr>
    <tr>
        <th colspan="2"></th>
        <th >Total</th>
        <th>S/ {{ $order-> total }}</th>
    </tr>
    </tfoot>
</table>
@if(!$loop->last)<hr>@else<br>@endif
@endforeach

Gracias,<br>
{{ config('app.name') }}
@endcomponent
