@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show mb-4">
        <ul>
            <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"><i class="fa fa-times" aria-hidden="true"></i></button>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{--  @if (Session::has('success'))
<div class="alert alert-danger alert-dismissible fade show mb-4">
    <li>{{ Session:: }}</li>
</div>
@endif  --}}
