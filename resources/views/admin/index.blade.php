@extends('admin.layouts.main')
{{--{{dd($aPageMenu)}}--}}
@section('content')

    <section id="content">
        <section class="vbox">
            <section class="scrollable padder">
                <ul class="breadcrumb no-border no-radius b-b b-light pull-in">
                    <li><a href="index.html"><i class="fa fa-home"></i> Home</a></li>
                    <li class="active">Workset</li>
                </ul>
                <div class="m-b-md">
                    <h3 class="m-b-none">Workset</h3>
                    <small>Welcome back, Noteman</small> </div>
                <section class="panel panel-default">
                    <div class="row m-l-none m-r-none bg-light lter">
                        <div class="col-sm-6 col-md-3 padder-v b-r b-light"> <span class="fa-stack fa-2x pull-left m-r-sm"> <i class="fa fa-circle fa-stack-2x text-info"></i> <i class="fa fa-male fa-stack-1x text-white"></i> </span> <a class="clear" href="#"> <span class="h3 block m-t-xs"><strong>52,000</strong></span> <small class="text-muted text-uc">New robots</small> </a> </div>
                        <div class="col-sm-6 col-md-3 padder-v b-r b-light lt"> <span class="fa-stack fa-2x pull-left m-r-sm"> <i class="fa fa-circle fa-stack-2x text-warning"></i> <i class="fa fa-bug fa-stack-1x text-white"></i> <span class="easypiechart pos-abt easyPieChart" data-percent="100" data-line-width="4" data-track-color="#fff" data-scale-color="false" data-size="50" data-line-cap="butt" data-animate="2000" data-target="#bugs" data-update="3000" style="width: 50px; height: 50px; line-height: 50px;"><canvas width="50" height="50"></canvas></span> </span> <a class="clear" href="#"> <span class="h3 block m-t-xs"><strong id="bugs">6764</strong></span> <small class="text-muted text-uc">Bugs intruded</small> </a> </div>
                        <div class="col-sm-6 col-md-3 padder-v b-r b-light"> <span class="fa-stack fa-2x pull-left m-r-sm"> <i class="fa fa-circle fa-stack-2x text-danger"></i> <i class="fa fa-fire-extinguisher fa-stack-1x text-white"></i> <span class="easypiechart pos-abt easyPieChart" data-percent="100" data-line-width="4" data-track-color="#f5f5f5" data-scale-color="false" data-size="50" data-line-cap="butt" data-animate="3000" data-target="#firers" data-update="5000" style="width: 50px; height: 50px; line-height: 50px;"><canvas width="50" height="50"></canvas></span> </span> <a class="clear" href="#"> <span class="h3 block m-t-xs"><strong id="firers">4343</strong></span> <small class="text-muted text-uc">Extinguishers ready</small> </a> </div>
                        <div class="col-sm-6 col-md-3 padder-v b-r b-light lt"> <span class="fa-stack fa-2x pull-left m-r-sm"> <i class="fa fa-circle fa-stack-2x icon-muted"></i> <i class="fa fa-clock-o fa-stack-1x text-white"></i> </span> <a class="clear" href="#"> <span class="h3 block m-t-xs"><strong>31:50</strong></span> <small class="text-muted text-uc">Left to exit</small> </a> </div>
                    </div>
                </section>
                <div class="row">
                    <div class="col-md-8">
                        <section class="panel panel-default">
                            <header class="panel-heading font-bold">Statistics</header>
                            <div class="panel-body">
                                <div id="flot-1ine" style="height: 210px; padding: 0px; position: relative;"><canvas class="flot-base" width="551" height="210" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 551px; height: 210px;"></canvas><div class="flot-text" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px; font-size: smaller; color: rgb(84, 84, 84);"><div class="flot-x-axis flot-x1-axis xAxis x1Axis" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px; display: block;"><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 58px; top: 192px; left: 17px; text-align: center;">0</div><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 58px; top: 192px; left: 111px; text-align: center;">2</div><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 58px; top: 192px; left: 205px; text-align: center;">4</div><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 58px; top: 192px; left: 300px; text-align: center;">6</div><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 58px; top: 192px; left: 394px; text-align: center;">8</div><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 58px; top: 192px; left: 485px; text-align: center;">10</div></div><div class="flot-y-axis flot-y1-axis yAxis y1Axis" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px; display: block;"><div class="flot-tick-label tickLabel" style="position: absolute; top: 179px; left: 8px; text-align: right;">0</div><div class="flot-tick-label tickLabel" style="position: absolute; top: 135px; left: 8px; text-align: right;">5</div><div class="flot-tick-label tickLabel" style="position: absolute; top: 91px; left: 1px; text-align: right;">10</div><div class="flot-tick-label tickLabel" style="position: absolute; top: 47px; left: 1px; text-align: right;">15</div><div class="flot-tick-label tickLabel" style="position: absolute; top: 4px; left: 1px; text-align: right;">20</div></div></div><canvas class="flot-overlay" width="551" height="210" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 551px; height: 210px;"></canvas></div>
                            </div>
                            <footer class="panel-footer bg-white no-padder">
                                <div class="row text-center no-gutter">
                                    <div class="col-xs-3 b-r b-light"> <span class="h4 font-bold m-t block">5,860</span> <small class="text-muted m-b block">Orders</small> </div>
                                    <div class="col-xs-3 b-r b-light"> <span class="h4 font-bold m-t block">10,450</span> <small class="text-muted m-b block">Sellings</small> </div>
                                    <div class="col-xs-3 b-r b-light"> <span class="h4 font-bold m-t block">21,230</span> <small class="text-muted m-b block">Items</small> </div>
                                    <div class="col-xs-3"> <span class="h4 font-bold m-t block">7,230</span> <small class="text-muted m-b block">Customers</small> </div>
                                </div>
                            </footer>
                        </section>
                    </div>
                    <div class="col-md-4">
                        <section class="panel panel-default">
                            <header class="panel-heading font-bold">Data graph</header>
                            <div class="bg-light dk wrapper"> <span class="pull-right">Friday</span> <span class="h4">$540<br>
                    <small class="text-muted">+1.05(2.15%)</small> </span>
                                <div class="text-center m-b-n m-t-sm">
                                    <div class="sparkline" data-type="line" data-height="65" data-width="100%" data-line-width="2" data-line-color="#dddddd" data-spot-color="#bbbbbb" data-fill-color="" data-highlight-line-color="#fff" data-spot-radius="3" data-resize="true" values="280,320,220,385,450,320,345,250,250,250,400,380"><canvas width="244" height="65" style="display: inline-block; width: 244px; height: 65px; vertical-align: top;"></canvas></div>
                                    <div class="sparkline inline" data-type="bar" data-height="45" data-bar-width="6" data-bar-spacing="6" data-bar-color="#65bd77"><canvas width="150" height="45" style="display: inline-block; width: 150px; height: 45px; vertical-align: top;"></canvas></div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div> <span class="text-muted">Total:</span> <span class="h3 block">$2500.00</span> </div>
                                <div class="line pull-in"></div>
                                <div class="row m-t-sm">
                                    <div class="col-xs-4"> <small class="text-muted block">Market</small> <span>$1500.00</span> </div>
                                    <div class="col-xs-4"> <small class="text-muted block">Referal</small> <span>$600.00</span> </div>
                                    <div class="col-xs-4"> <small class="text-muted block">Affiliate</small> <span>$400.00</span> </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <h4 class="m-t-none">Todos</h4>
                        <ul class="list-group gutter list-group-lg list-group-sp sortable">
                            <li class="list-group-item box-shadow" draggable="true">
                                <a href="#" class="pull-right" data-dismiss="alert"><i class="fa fa-times icon-muted"></i> </a>
                    <span class="pull-left media-xs">
                      <i class="fa fa-sort icon-muted fa m-r-sm"></i>
                      <a href="#todo-1" data-toggle="class:text-lt text-success" class="active">
                          <i class="fa fa-square-o fa-fw text"></i>
                          <i class="fa fa-check-square-o fa-fw text-active text-success"></i>
                      </a>
                    </span>
                                <div class="clear text-success text-lt" id="todo-1"> Browser compatibility </div>
                            </li>
                            <li class="list-group-item box-shadow" draggable="true"> <a href="#" class="pull-right" data-dismiss="alert"> <i class="fa fa-times icon-muted"></i> </a> <span class="pull-left media-xs"> <i class="fa fa-sort icon-muted fa m-r-sm"></i> <a href="#todo-2" data-toggle="class:text-lt text-danger"> <i class="fa fa-square-o fa-fw text"></i> <i class="fa fa-check-square-o fa-fw text-active text-danger"></i> </a> </span>
                                <div class="clear" id="todo-2"> Looking for more example templates </div>
                            </li>
                            <li class="list-group-item box-shadow" draggable="true"> <a href="#" class="pull-right" data-dismiss="alert"> <i class="fa fa-times icon-muted"></i> </a> <span class="pull-left media-xs"> <i class="fa fa-sort icon-muted fa m-r-sm"></i> <a href="#todo-3" data-toggle="class:text-lt"> <i class="fa fa-square-o fa-fw text"></i> <i class="fa fa-check-square-o fa-fw text-active text-success"></i> </a> </span>
                                <div class="clear" id="todo-3"> Customizing components </div>
                            </li>
                            <li class="list-group-item box-shadow" draggable="true"> <a href="#" class="pull-right" data-dismiss="alert"> <i class="fa fa-times icon-muted"></i> </a> <span class="pull-left media-xs"> <i class="fa fa-sort icon-muted fa m-r-sm"></i> <a href="#todo-4" data-toggle="class:text-lt"> <i class="fa fa-square-o fa-fw text"></i> <i class="fa fa-check-square-o fa-fw text-active text-success"></i> </a> </span>
                                <div class="clear" id="todo-4"> The fastest way to get started </div>
                            </li>
                            <li class="list-group-item box-shadow" draggable="true"> <a href="#" class="pull-right" data-dismiss="alert"> <i class="fa fa-times icon-muted"></i> </a> <span class="pull-left media-xs"> <i class="fa fa-sort icon-muted fa m-r-sm"></i> <a href="#todo-5" data-toggle="class:text-lt"> <i class="fa fa-square-o fa-fw text"></i> <i class="fa fa-check-square-o fa-fw text-active text-success"></i> </a> </span>
                                <div class="clear" id="todo-5"> HTML5 doctype required </div>
                            </li>
                            <li class="list-group-item box-shadow" draggable="true"> <a href="#" class="pull-right" data-dismiss="alert"> <i class="fa fa-times icon-muted"></i> </a> <span class="pull-left media-xs"> <i class="fa fa-sort icon-muted fa m-r-sm"></i> <a href="#todo-6" data-toggle="class:text-lt"> <i class="fa fa-square-o fa-fw text"></i> <i class="fa fa-check-square-o fa-fw text-active text-success"></i> </a> </span>
                                <div class="clear" id="todo-6"> LessCSS compiling </div>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <section class="panel b-light">
                            <header class="panel-heading bg-primary dker no-border"><strong>Calendar</strong></header>
                            <div id="calendar" class="bg-primary m-l-n-xxs m-r-n-xxs"><div class="calendar" id="cal_8ju"><table class="table header"><tbody><tr></tr></tbody><td><i class="fa fa-arrow-left"></i></td><td colspan="5" class="year span6"><div class="visualmonthyear">March 2017</div></td><td><i class="fa fa-arrow-right"></i></td></table><table class="daysmonth table table"><tbody><tr class="week_days"><td class="first">S</td><td>M</td><td>T</td><td>W</td><td>T</td><td>F</td><td class="last">S</td></tr><tr><td class="invalid first"></td><td class="invalid"></td><td class="invalid"></td><td id="cal_8ju_1_3_2017"><a>1</a></td><td id="cal_8ju_2_3_2017"><a>2</a></td><td id="cal_8ju_3_3_2017"><a>3</a></td><td id="cal_8ju_4_3_2017" class="last"><a>4</a></td></tr><tr><td id="cal_8ju_5_3_2017" class="first event event_popover"><a data-original-title="Meet a friend" data-trigger="manual" class="manual_popover" rel="popover" data-content="Contents here">5</a><span style="background: rgb(251, 107, 91);"></span></td><td id="cal_8ju_6_3_2017"><a>6</a></td><td id="cal_8ju_7_3_2017"><a>7</a></td><td id="cal_8ju_8_3_2017" class="event event_popover"><a data-original-title="Kick off meeting!" data-trigger="manual" class="manual_popover" rel="popover" data-content="Have a kick off meeting with .inc company">8</a><span style="background: rgb(255, 186, 77);"></span></td><td id="cal_8ju_9_3_2017"><a>9</a></td><td id="cal_8ju_10_3_2017"><a>10</a></td><td id="cal_8ju_11_3_2017" class="last"><a>11</a></td></tr><tr><td id="cal_8ju_12_3_2017" class="first"><a>12</a></td><td id="cal_8ju_13_3_2017"><a>13</a></td><td id="cal_8ju_14_3_2017"><a>14</a></td><td id="cal_8ju_15_3_2017"><a>15</a></td><td id="cal_8ju_16_3_2017"><a>16</a></td><td id="cal_8ju_17_3_2017"><a>17</a></td><td id="cal_8ju_18_3_2017" class="last event event_popover"><a data-original-title="Milestone release" data-trigger="manual" class="manual_popover" rel="popover" data-content="Contents here">18</a><span style="background: rgb(255, 186, 77);"></span></td></tr><tr><td id="cal_8ju_19_3_2017" class="first event event_tooltip"><a data-original-title="A link" href="https://github.com/blog/category/drinkup" rel="tooltip">19</a><span style="background: rgb(204, 204, 204);"></span></td><td id="cal_8ju_20_3_2017"><a>20</a></td><td id="cal_8ju_21_3_2017"><a>21</a></td><td id="cal_8ju_22_3_2017"><a>22</a></td><td id="cal_8ju_23_3_2017"><a>23</a></td><td id="cal_8ju_24_3_2017"><a>24</a></td><td id="cal_8ju_25_3_2017" class="last"><a>25</a></td></tr><tr><td id="cal_8ju_26_3_2017" class="first"><a>26</a></td><td id="cal_8ju_27_3_2017"><a>27</a></td><td id="cal_8ju_28_3_2017"><a>28</a></td><td id="cal_8ju_29_3_2017"><a>29</a></td><td id="cal_8ju_30_3_2017"><a>30</a></td><td id="cal_8ju_31_3_2017"><a>31</a></td><td class="invalid last"></td></tr></tbody></table></div></div>
                            <div class="list-group"> <a href="#" class="list-group-item text-ellipsis"> <span class="badge bg-danger">7:30</span> Meet a friend </a> <a href="#" class="list-group-item text-ellipsis"> <span class="badge bg-success">9:30</span> Have a kick off meeting with .inc company </a> <a href="#" class="list-group-item text-ellipsis"> <span class="badge bg-light">19:30</span> Milestone release </a> </div>
                        </section>
                    </div>
                </div>
                <div>
                    <div class="btn-group m-b" data-toggle="buttons">
                        <label class="btn btn-sm btn-default active">
                            <input type="radio" name="options" id="option1">
                            Timeline </label>
                        <label class="btn btn-sm btn-default">
                            <input type="radio" name="options" id="option2">
                            Activity </label>
                    </div>
                    <section class="comment-list block">
                        <article id="comment-id-1" class="comment-item"> <span class="fa-stack pull-left m-l-xs"> <i class="fa fa-circle text-info fa-stack-2x"></i> <i class="fa fa-play-circle text-white fa-stack-1x"></i> </span>
                            <section class="comment-body m-b-lg">
                                <header> <a href="#"><strong>John smith</strong></a> shared a <a href="#" class="text-info">video</a> to you <span class="text-muted text-xs"> 24 minutes ago </span> </header>
                                <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi id neque quam.</div>
                            </section>
                        </article>
                        <!-- .comment-reply -->
                        <article id="comment-id-2" class="comment-reply">
                            <article class="comment-item"> <a class="pull-left thumb-sm"> <img src="/admin/images/avatar_default.jpg" class="img-circle"> </a>
                                <section class="comment-body m-b-lg">
                                    <header> <a href="#"><strong>John smith</strong></a> <span class="text-muted text-xs"> 26 minutes ago </span> </header>
                                    <div> Morbi id neque quam. Aliquam.</div>
                                </section>
                            </article>
                            <article class="comment-item"> <a class="pull-left thumb-sm"> <img src="/admin/images/avatar.jpg" class="img-circle"> </a>
                                <section class="comment-body m-b-lg">
                                    <header> <a href="#"><strong>Mike</strong></a> <span class="text-muted text-xs"> 26 minutes ago </span> </header>
                                    <div>Good idea.</div>
                                </section>
                            </article>
                        </article>
                        <!-- / .comment-reply -->
                        <article id="comment-id-2" class="comment-item"> <span class="fa-stack pull-left m-l-xs"> <i class="fa fa-circle text-danger fa-stack-2x"></i> <i class="fa fa-file-o text-white fa-stack-1x"></i> </span>
                            <section class="comment-body m-b-lg">
                                <header> <a href="#"><strong>John Doe</strong></a> <span class="text-muted text-xs"> 1 hour ago </span> </header>
                                <div>Lorem ipsum dolor sit amet, consecteter adipiscing elit.</div>
                            </section>
                        </article>
                        <article id="comment-id-2" class="comment-item"> <span class="fa-stack pull-left m-l-xs"> <i class="fa fa-circle text-success fa-stack-2x"></i> <i class="fa fa-check text-white fa-stack-1x"></i> </span>
                            <section class="comment-body m-b-lg">
                                <header> <a href="#"><strong>Jonathan</strong></a> completed a task <span class="text-muted text-xs"> 1 hour ago </span> </header>
                                <div>Consecteter adipiscing elit.</div>
                            </section>
                        </article>
                    </section>
                    <a href="#" class="btn btn-default btn-sm m-b"><i class="fa fa-plus icon-muted"></i> more</a> </div>
            </section>
        </section>
        <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a> </section>

@endsection


@section('before-css')
    <link rel="stylesheet" href="/admin/js/calendar/bootstrap_calendar.css" type="text/css" cache="false" />
@endsection

@section('before-js')
@endsection

@section('after-js')
    <script src="/admin/js/charts/easypiechart/jquery.easy-pie-chart.js" cache="false"></script>
    <script src="/admin/js/charts/sparkline/jquery.sparkline.min.js" cache="false"></script>
    <script src="/admin/js/charts/flot/jquery.flot.min.js" cache="false"></script>
    <script src="/admin/js/charts/flot/jquery.flot.tooltip.min.js" cache="false"></script>
    <script src="/admin/js/charts/flot/jquery.flot.resize.js" cache="false"></script>
    <script src="/admin/js/charts/flot/jquery.flot.grow.js" cache="false"></script>
    <script src="/admin/js/charts/flot/demo.js" cache="false"></script>
    <script src="/admin/js/calendar/bootstrap_calendar.js" cache="false"></script>
    <script src="/admin/js/calendar/demo.js" cache="false"></script>
    <script src="/admin/js/sortable/jquery.sortable.js" cache="false"></script>
@endsection