<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ asset('themes/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ user_active()->fullname }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online ( {{ user_active()->userlevel }} )</a>
            </div>
        </div>
        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
        </ul>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        {!! Menu::get('sidebar') !!}
    </section>
    <!-- /.sidebar -->
</aside>
