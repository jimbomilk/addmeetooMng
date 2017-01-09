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

            <li class="active treeview">
                <a href="#">
                    <i class="fa fa-dashboard"></i> <span>Management</span> <i class="fa fa-angle-left pull-right"></i>
                </a>

                <ul class="treeview-menu">
                    <li><a href="/admin/activities"><i class="fa fa-circle-o"></i> Activities</a></li>
                    <li><a href="/admin/categories"><i class="fa fa-circle-o"></i> Categories</a></li>
                    <li><a href="/admin/locations"><i class="fa fa-circle-o"></i> Locations</a></li>
                    <li><a href="/admin/positions"><i class="fa fa-circle-o"></i> Positions</a></li>
                    <li><a href="/admin/languages"><i class="fa fa-circle-o"></i> Languages</a></li>
                </ul>
            </li>
            <li class="treeview active">
                <a href="#">
                    <i class="fa fa-clock-o"></i>
                    <span>Auctions</span>
                    <small class="label pull-right bg-green">new</small>


                </a>
                <ul class="treeview-menu">
                    <li><a href="/admin/items"><i class="fa fa-circle-o"></i> Items</a></li>
                    <li><a href="/admin/auctions"><i class="fa fa-circle-o"></i> Active Auctions</a></li>

                </ul>
            </li>
            <li class="treeview active">
                <a href="#">
                    <i class="fa fa-line-chart"></i>
                    <span>Rankings</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
            </li>
            <li class="treeview active">
                <a href="#">
                    <i class="fa fa-video-camera"></i>
                    <span>TV SET</span><i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="/admin/tvconfigs"><i class="fa fa-circle-o"></i> Config</a></li>
                    <li><a href="/admin/screens"><i class="fa fa-circle-o"></i> Screens</a></li>

                </ul>
            </li>


        </ul>
    </section>
    <!-- /.sidebar -->
</aside>