@if (isset($monthly) && $monthly>0)
    @include("admin.usergameboards.partials.monthlytable")
@else
    @include("admin.usergameboards.partials.globaltable")
@endif
