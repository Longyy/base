{{--{{dd($aPageMenu)}}--}}
<header class="bg-dark dk header navbar navbar-fixed-top-xs">
    <div class="navbar-header aside-md"> <a class="btn btn-link visible-xs" data-toggle="class:nav-off-screen" data-target="#nav"> <i class="fa fa-bars"></i> </a> <a href="#" class="navbar-brand" data-toggle="fullscreen"><img src="/admin/images/logo.png" class="m-r-sm">Notebook</a> <a class="btn btn-link visible-xs" data-toggle="dropdown" data-target=".nav-user"> <i class="fa fa-cog"></i> </a> </div>
    <ul class="nav navbar-nav hidden-xs">

        <!-- 一级菜单 -->
        @foreach ($aPageMenu as $aMenu)
            @if($aMenu['iLevel'] == 0)
                <li @if(isset($aMenu['iActive'])) class="active" @endif>
                    <a href="#" class="dker"> <i class="fa fa-building-o"></i> <span class="h5 font-bold">{{$aMenu['sName']}}</span> </a>
                </li>
            @endif
        @endforeach

        {{--<li>--}}
            {{--<div class="m-t m-l"> <a href="price.html" class="dropdown-toggle btn btn-xs btn-primary" title="Upgrade"><i class="fa fa-long-arrow-up"></i><span class="font-bold"></span>eee</a> </div>--}}
        {{--</li>--}}
    </ul>
    <ul class="nav navbar-nav navbar-right hidden-xs nav-user">
        <li class="hidden-xs"> <a href="#" class="dropdown-toggle dk" data-toggle="dropdown"> <i class="fa fa-bell"></i> <span class="badge badge-sm up bg-danger m-l-n-sm count">2</span> </a>
            <section class="dropdown-menu aside-xl">
                <section class="panel bg-white">
                    <header class="panel-heading b-light bg-light"> <strong>You have <span class="count">2</span> notifications</strong> </header>
                    <div class="list-group list-group-alt animated fadeInRight"> <a href="#" class="media list-group-item"> <span class="pull-left thumb-sm"> <img src="/admin/images/avatar.jpg" alt="John said" class="img-circle"> </span> <span class="media-body block m-b-none"> Use awesome animate.css<br>
              <small class="text-muted">10 minutes ago</small> </span> </a> <a href="#" class="media list-group-item"> <span class="media-body block m-b-none"> 1.0 initial released<br>
              <small class="text-muted">1 hour ago</small> </span> </a> </div>
                    <footer class="panel-footer text-sm"> <a href="#" class="pull-right"><i class="fa fa-cog"></i></a> <a href="#notes" data-toggle="class:show animated fadeInRight">See all the notifications</a> </footer>
                </section>
            </section>
        </li>
        <li class="dropdown hidden-xs"> <a href="#" class="dropdown-toggle dker" data-toggle="dropdown"><i class="fa fa-fw fa-search"></i></a>
            <section class="dropdown-menu aside-xl animated fadeInUp">
                <section class="panel bg-white">
                    <form role="search">
                        <div class="form-group wrapper m-b-none">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search">
                  <span class="input-group-btn">
                  <button type="submit" class="btn btn-info btn-icon"><i class="fa fa-search"></i></button>
                  </span> </div>
                        </div>
                    </form>
                </section>
            </section>
        </li>
        <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <span class="thumb-sm avatar pull-left"> <img src="/admin/images/avatar.jpg"> </span> John.Smith <b class="caret"></b> </a>
            <ul class="dropdown-menu animated fadeInRight">
                <span class="arrow top"></span>
                <li> <a href="#">Settings</a> </li>
                <li> <a href="profile.html">Profile</a> </li>
                <li> <a href="#"> <span class="badge bg-danger pull-right">3</span> Notifications </a> </li>
                <li> <a href="docs.html">Help</a> </li>
                <li class="divider"></li>
                <li> <a href="modal.lockme.html" data-toggle="ajaxModal" >Logout</a> </li>
            </ul>
        </li>
    </ul>
</header>