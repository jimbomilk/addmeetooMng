<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ $profile->avatar }}" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
                <p>{{$login_user->name}}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">{{trans('labels.mainmenu')}}</li>

            @if ($login_user->is('admin') || $login_user->is('owner')  )
            <li class="active treeview">
                <a href="#">
                    <i class="fa fa-dashboard"></i> <span>{{trans('labels.management')}}</span> <i class="fa fa-angle-left pull-right"></i>
                </a>

                <ul class="treeview-menu">
                    <li><a href="/{{$login_user->type}}/"><i class="fa fa-dashboard"></i> {{trans('labels.main')}}</a></li>
                    @if ($login_user->is('admin'))
                    <li><a href="/admin/users"><i class="fa fa-users"></i> {{trans('labels.users')}}</a></li>

                    @endif

                    <li><a href="/{{$login_user->type}}/locations"><i class="fa fa-building-o"></i> {{trans('labels.locations')}}</a></li>
                    <li><a href="/{{$login_user->type}}/messages"><i class="fa fa-paper-plane-o"></i> {{trans('labels.messages')}}</a></li>
                </ul>
            </li>
            @endif

            <li class="active treeview">
                <a href="#">
                    <i class="fa fa-rocket"></i> <span>{{trans('labels.advertisements')}}</span> <i class="fa fa-angle-left pull-right"></i>
                </a>

                <ul class="treeview-menu">
                    <li><a href="/{{$login_user->type}}/advertisements"><i class="fa fa-adn"></i> {{trans('labels.ads')}}</a></li>
                </ul>
            </li>


            @if ($login_user->is('admin') || $login_user->is('owner')  )
            <li class="active treeview">
                <a href="#">
                    <i class="fa fa-delicious"></i> <span>{{trans('labels.games')}}</span> <i class="fa fa-angle-left pull-right"></i>
                </a>

                <ul class="treeview-menu">
                    @if ($login_user->is('admin'))
                        <li><a href="/admin/activities"><i class="fa fa-universal-access"></i>{{trans('labels.activities')}}</a></li>
                    @endif
                    <li><a href="/{{$login_user->type}}/gameboards"><i class="fa fa-delicious"></i>{{trans('labels.gameboards')}}</a></li>
                </ul>
            </li>
            @endif

            @if ($login_user->is('admin') || $login_user->is('owner')  )
            <li class="active treeview">
                <a href="#">
                    <i class="fa fa-line-chart"></i> <span>{{trans('labels.rankings')}}</span> <i class="fa fa-angle-left pull-right"></i>
                </a>

                <ul class="treeview-menu">
                    <li><a href="/{{$login_user->type}}/usergameboards"><i class="fa fa-line-chart"></i> {{trans('labels.ranking')}}</a></li>
                </ul>
            </li>
            @endif

            @if ($login_user->is('admin')  )
            <li class="treeview active">
                <a href="#">
                    <i class="fa fa-gavel"></i>
                    <span>{{trans('labels.auctions')}}</span>
                    <small class="label pull-right bg-green">new</small>


                </a>
                <ul class="treeview-menu">
                    <li><a href="/{{$login_user->type}}/items"><i class="fa fa-diamond"></i> {{trans('labels.items')}}</a></li>
                    <li><a href="/{{$login_user->type}}/auctions"><i class="fa fa-clock-o"></i> {{trans('labels.activeauctions')}}</a></li>

                </ul>
            </li>
            @endif



        </ul>
    </section>
    <!-- /.sidebar -->
</aside>