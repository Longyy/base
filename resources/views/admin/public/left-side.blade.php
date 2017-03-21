<aside class="bg-dark lter aside-md hidden-print" id="nav">
    <section class="vbox">
        <header class="header bg-primary lter text-center clearfix">
            <div class="btn-group">
                <button type="button" class="btn btn-sm btn-dark btn-icon" title="New project"><i class="fa fa-plus"></i></button>
                <div class="btn-group hidden-nav-xs">
                    <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown"> Switch Project <span class="caret"></span> </button>
                    <ul class="dropdown-menu text-left">
                        <li><a href="#">Project</a></li>
                        <li><a href="#">Another Project</a></li>
                        <li><a href="#">More Projects</a></li>
                    </ul>
                </div>
            </div>
        </header>
        <section class="w-f scrollable">
            <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 493px;"><div class="slim-scroll" data-height="auto" data-disable-fade-out="true" data-distance="0" data-size="5px" data-color="#333333" style="overflow: hidden; width: auto; height: 493px;"> <!-- nav -->
                    <nav class="nav-primary hidden-xs">
                        <ul class="nav">

                            <!-- 二级和三级菜单 -->
                            @foreach ($aPageMenu as $aVal)
                                @if($aVal['iLevel'] == 1)
                                    {{--<li class="active">--}}
                                    <li @if(isset($aVal['iActive'])) class="active" @endif>
                                        <a href="{{$aVal['sUrl']}}"> <i class="fa fa-columns icon"> <b class="bg-warning"></b> </i> <span class="pull-right"> <i class="fa fa-angle-down text"></i> <i class="fa fa-angle-up text-active"></i> </span> <span>{{$aVal['sName']}}</span> </a>
                                    @foreach ($aPageMenu as $aVVal)
                                        @if($aVVal['iLevel'] == 2 && $aVVal['iParentID'] == $aVal['iAutoID'])
                                                <ul class="nav lt">
                                                    <li> <a href="{{$aVVal['sUrl']}}"> <i class="fa fa-angle-right"></i> <span>{{$aVVal['sName']}}</span> </a> </li>
                                                </ul>
                                        @endif
                                    @endforeach

                                    </li>

                                @endif
                            @endforeach

                        </ul>

                    </nav>
                    <!-- / nav --> </div><div class="slimScrollBar" style="width: 5px; position: absolute; top: 0px; opacity: 0.4; display: none; border-top-left-radius: 7px; border-top-right-radius: 7px; border-bottom-right-radius: 7px; border-bottom-left-radius: 7px; z-index: 99; right: 0px; height: 493px; background: rgb(51, 51, 51);"></div><div class="slimScrollRail" style="width: 5px; height: 100%; position: absolute; top: 0px; display: none; border-top-left-radius: 7px; border-top-right-radius: 7px; border-bottom-right-radius: 7px; border-bottom-left-radius: 7px; opacity: 0.2; z-index: 90; right: 0px; background: rgb(51, 51, 51);"></div></div>
        </section>
        <footer class="footer lt hidden-xs b-t b-dark">
            <div id="chat" class="dropup">
                <section class="dropdown-menu on aside-md m-l-n">
                    <section class="panel bg-white">
                        <header class="panel-heading b-b b-light">Active chats</header>
                        <div class="panel-body animated fadeInRight">
                            <p class="text-sm">No active chats.</p>
                            <p><a href="#" class="btn btn-sm btn-default">Start a chat</a></p>
                        </div>
                    </section>
                </section>
            </div>
            <div id="invite" class="dropup">
                <section class="dropdown-menu on aside-md m-l-n">
                    <section class="panel bg-white">
                        <header class="panel-heading b-b b-light"> John <i class="fa fa-circle text-success"></i> </header>
                        <div class="panel-body animated fadeInRight">
                            <p class="text-sm">No contacts in your lists.</p>
                            <p><a href="#" class="btn btn-sm btn-facebook"><i class="fa fa-fw fa-facebook"></i> Invite from Facebook</a></p>
                        </div>
                    </section>
                </section>
            </div>
            <a href="#nav" data-toggle="class:nav-xs" class="pull-right btn btn-sm btn-dark btn-icon"> <i class="fa fa-angle-left text"></i> <i class="fa fa-angle-right text-active"></i> </a>
            <div class="btn-group hidden-nav-xs">
                <button type="button" title="Chats" class="btn btn-icon btn-sm btn-dark" data-toggle="dropdown" data-target="#chat"><i class="fa fa-comment-o"></i></button>
                <button type="button" title="Contacts" class="btn btn-icon btn-sm btn-dark" data-toggle="dropdown" data-target="#invite"><i class="fa fa-facebook"></i></button>
            </div>
        </footer>
    </section>
</aside>