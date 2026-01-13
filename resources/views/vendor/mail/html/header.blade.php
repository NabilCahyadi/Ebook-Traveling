@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="{{ asset('images/logo_horizontall.png') }}" class="logo" alt="MeatMap Logo" style="height: 50px;">
@else
{!! $slot !!}
@endif
</a>
</td>
</tr>
