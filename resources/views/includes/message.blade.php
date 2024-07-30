@if(Session::has('success'))
    <div class="alert alert-success alert-dismissible fade show" style="text-align: center; margin-top: 10px;">
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        <strong>
            {!!Session::get('success')!!}
        </strong>
    </div>
@endif
@if(Session::has('error'))
    <div class="alert alert-danger alert-dismissible fade show" style="text-align: center; margin-top: 10px;">
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        <strong>
            {!!Session::get('error')!!}
        </strong>
    </div>
@endif
@if ($errors->any())
{{-- @dd($errors->all()) --}}
    <div class="alert alert-danger alert-dismissible fade show" style="text-align: center; margin-top: 10px;">
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        <ul>
            @foreach ($errors->all() as $error)
                <li style="list-style: none;">{!! $error !!}</li>
            @endforeach
        </ul>
    </div>
@endif