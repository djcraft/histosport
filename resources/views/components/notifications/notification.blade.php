@if(session('notification'))
    <div class="mb-4 px-4 py-2 rounded {{ session('notification.type') === 'success' ? 'bg-green-100 text-green-800' : (session('notification.type') === 'error' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800') }}">
        {!! session('notification.message') !!}
    </div>
@endif
