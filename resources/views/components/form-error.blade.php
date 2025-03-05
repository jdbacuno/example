@props(['name']) {{-- needed to pass in the "name" attribute, e.g. @props('title') --}}

@error($name) {{-- @error('title') --}}
  <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p>
@enderror