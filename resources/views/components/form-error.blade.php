@props(['name'])

@error($name)
<p class="text-xs text-red-500 font-semibold mt-1 ms-5">{{ $message }}</p>
@enderror
