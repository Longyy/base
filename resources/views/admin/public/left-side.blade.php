<aside class="bg-light lter b-r aside-md hidden-print" id="nav">
    <section class="vbox">

        <section class="w-f scrollable">
            <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 493px;"><div class="slim-scroll" data-height="auto" data-disable-fade-out="true" data-distance="0" data-size="5px" data-color="#333333" style="overflow: hidden; width: auto; height: 493px;"> <!-- nav -->
                    <nav class="nav-primary hidden-xs">
                        <ul class="nav">
 
                            <!-- 二级和三级菜单 -->
                            @foreach ($aPageMenu['aMainMenu'] as $aVal)
                                @if($aVal['iLevel'] == 1)
                                    {{--<li class="active">--}}
                                    <li @if(isset($aVal['iActive'])) class="active" @endif>
                                        <a href="{{$aVal['sUrl']}}"> <i class="fa {{$aVal['sIcon']}} icon"> <b class="b-b b-light"></b> </i> <span class="pull-right"> <i class="fa fa-angle-down text"></i> <i class="fa fa-angle-up text-active"></i> </span> <span>{{$aVal['sName']}}</span> </a>
                                    @foreach ($aPageMenu['aMainMenu'] as $aVVal)
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
        <footer class="footer lt hidden-xs b-t b-light">

            <div id="chat" class="dropup">
                <section class="dropdown-menu on aside-md m-l-n">
                    <section class="panel bg-white">
                        <header class="panel-heading b-b b-dark ">可用角色</header>
                        <div class="panel-body animated fadeInRight">
                            @foreach($aProfile['aTempGroup'] as $aItem)
                                <p><a href="#" class="btn btn-sm btn-default">{{$aItem['sGroupName']}}</a></p>
                            @endforeach
                        </div>
                    </section>
                </section>
            </div>
            <div class="btn-group hidden-nav-xs">
                <button type="button" title="切换角色" class="btn btn-sm btn-default" data-toggle="dropdown" data-target="#chat">切换角色</button>
            </div>
            <a href="#nav" data-toggle="class:nav-xs" class="pull-right btn btn-sm btn-default btn-icon"> <i class="fa fa-angle-left text"></i> <i class="fa fa-angle-right text-active"></i> </a>

        </footer>
    </section>
</aside>