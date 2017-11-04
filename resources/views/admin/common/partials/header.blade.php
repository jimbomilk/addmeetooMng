<section class="content-header">
    <h1>
        <i class="fa {{trans('design.'.$name)}}"></i>
        @if (isset($titlepage))
            <strong>{{ $titlepage }}</strong>
        @else
            <strong>{{ trans('labels.'.$name) }}</strong>
        @endif
    </h1>
    <ol class="breadcrumb">
        <li><a href="/{{$login_user->type}}"><i class="fa fa-dashboard"></i> {{trans('labels.home')}}</a></li>
        <li class="active">{{  trans('labels.'.$name)}}</li>
    </ol>
</section>