@php $totalSum = 0; @endphp
@foreach ($products as $index => $p)
    @php $totalSum += $p['total_value']; @endphp
    <tr>
        <td>{{ $p['product_name'] }}</td>
        <td>{{ $p['quantity'] }}</td>
        <td>${{ $p['price'] }}</td>
        <td>{{ $p['datetime'] }}</td>
        <td>${{ $p['total_value'] }}</td>
        <td><button class="btn btn-sm btn-warning edit-btn" data-index="{{ $index }}">Edit</button></td>
    </tr>
@endforeach
<tr class="fw-bold table-secondary">
    <td colspan="4" class="text-end">Sum Total:</td>
    <td colspan="2">${{ $totalSum }}</td>
</tr>
