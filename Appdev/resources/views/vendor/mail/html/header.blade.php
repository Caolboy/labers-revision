@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="/labers1.png" class="logo" alt="LABERS Logo">
@else 
{{ $slot }}
@endif
</a>
</td>
</tr>
