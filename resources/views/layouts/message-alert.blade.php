@if(Session::has('error') || Session::has('success') || Session::has('warning'))
    <div class="alert-box {{isset($classes) ? $classes : ''}}">
@endif
@if(Session::has('error'))
    <div class="error-message alert text-white alert-danger alert-success mb-0 type-error">
        <button type="button" class="close" data-dismiss="alert">×</button>
        {{ Session::get("error") }}
    </div>
@endif

@if(Session::has('success'))
    <div class="alert text-white alert-dismissible alert-success mb-0">
        <button type="button" class="close" data-dismiss="alert">×</button>
        {{ Session::get("success") }}
    </div>
@endif

@if(Session::has('warning'))
    <div class="alert text-white alert-dismissible alert-warning mb-0">
        <button type="button" class="close" data-dismiss="alert">×</button>
        {{ Session::get("warning") }}
    </div>
@endif

@if (session('resent'))
    <div class="alert text-white alert-dismissible alert-success mb-0">
        <button type="button" class="close" data-dismiss="alert">×</button>
        A new mail confirmation email has been sent to your email.
    </div>
@endif


    @if(Session::has('error') || Session::has('success') || Session::has('warning'))
    </div>
@endif
