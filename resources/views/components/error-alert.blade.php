<div class="alert alert-danger">
    <ul>
        @foreach ($error->all() as $e)
        <li>{{ $e }}</li>
        @endforeach
    </ul>
</div>
