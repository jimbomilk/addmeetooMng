<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ $login_user->profile->avatar }}" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
                <p>{{$login_user->name}}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
                <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                </span>
            </div>
        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>

            @if ($login_user->is('admin') || $login_user->is('owner')  )
            <li class="active treeview">
                <a href="#">
                    <i class="fa fa-dashboard"></i> <span>Management</span> <i class="fa fa-angle-left pull-right"></i>
                </a>

                <ul class="treeview-menu">
                    @if ($login_user->is('admin'))
                    <li><a href="/admin/users"><i class="fa fa-users"></i> Users</a></li>
                    @endif

                    <li><a href="/{{$login_user->type}}/locations"><i class="fa fa-building-o"></i> Locations</a></li>
                    <li><a href="/{{$login_user->type}}/messages"><i class="fa fa-paper-plane-o"></i> Messages</a></li>
                </ul>
            </li>
            @endif

            <li class="active treeview">
                <a href="#">
                    <i class="fa fa-rocket"></i> <span>Advertisements</span> <i class="fa fa-angle-left pull-right"></i>
                </a>

                <ul class="treeview-menu">
                    <li><a href="/{{$login_user->type}}/advertisements"><i class="fa fa-adn"></i> Ads</a></li>
                </ul>
            </li>


            @if ($login_user->is('admin') || $login_user->is('owner')  )
            <li class="active treeview">
                <a href="#">
                    <i class="fa fa-delicious"></i> <span>Games</span> <i class="fa fa-angle-left pull-right"></i>
                </a>

                <ul class="treeview-menu">
                    @if ($login_user->is('admin'))
                        <li><a href="/admin/activities"><i class="fa fa-universal-access"></i>Activities</a></li>
                    @endif
                    <li><a href="/{{$login_user->type}}/gameboards"><i class="fa fa-delicious"></i>Game Boards</a></li>
                </ul>
            </li>
            @endif

            @if ($login_user->is('admin') || $login_user->is('owner')  )
            <li class="active treeview">
                <a href="#">
                    <i class="fa fa-line-chart"></i> <span>Rankings</span> <i class="fa fa-angle-left pull-right"></i>
                </a>

                <ul class="treeview-menu">
                    <li><a href="/{{$login_user->type}}/usergameboards"><i class="fa fa-line-chart"></i> Ranking</a></li>
                </ul>
            </li>
            @endif

            @if ($login_user->is('admin') || $login_user->is('owner')  )
            <li class="treeview active">
                <a href="#">
                    <i class="fa fa-gavel"></i>
                    <span>Auctions</span>
                    <small class="label pull-right bg-green">new</small>


                </a>
                <ul class="treeview-menu">
                    <li><a href="/{{$login_user->type}}/items"><i class="fa fa-diamond"></i> Items</a></li>
                    <li><a href="/{{$login_user->type}}/auctions"><i class="fa fa-clock-o"></i> Active Auctions</a></li>

                </ul>
            </li>
            @endif



        </ul>
    </section>
    <!-- /.sidebar -->
</aside>