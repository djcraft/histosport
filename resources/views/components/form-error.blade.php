@if($errors->has($name))
    <span class="text-red-500 text-xs">{{ $errors->first($name) }}</span>
@endif
