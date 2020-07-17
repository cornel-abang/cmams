@if(session('success'))
    <div class="alert alert-success">
        {!! session('success') !!} <a href="" id="close-msg"><span class="la la-times-circle"></span></a>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {!! session('error') !!} <a href="" id="close-msg"><span class="la la-times-circle"></span></a>
    </div>
@endif
