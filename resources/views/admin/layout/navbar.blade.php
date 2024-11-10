@php($navMenus = (new \App\Service\MenuService())->roleMenus(1, 1))
@php($routePath = ltrim(str_replace(request()->getSchemeAndHttpHost(), '', request()->url()), '/'))
<nav class="navbar navbar-inverse" style="border-radius: 0;">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#top-header-collapse" aria-expanded="false">
                <span class="sr-only">Expand</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Admin Dashboard</a>
        </div>
        <div class="collapse navbar-collapse" id="top-header-collapse">
            @foreach($navMenus as $menu)
                <ul class="nav navbar-nav">
                    @if(empty($menu['child']))
                        <li @if(!empty($menu['url']) && $menu['url'] == $routePath)  class="active"@endif><a
                                href="@if(!empty($menu['url'])){{url($menu['url'])}}@else javascript:vod(0);@endif">{{$menu['title']}}
                                <span class="sr-only">(current)</span></a></li>
                    @else
                        <li class="dropdown @if(in_array($routePath, array_filter(array_unique(array_column($menu['child'], 'url'))))) active @endif">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-haspopup="true"
                               aria-expanded="false">{{$menu['title']}} <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                @foreach($menu['child'] as $childMenu)
                                    <li>
                                        <a href="@if(!empty($childMenu['url'])){{url($childMenu['url'])}}@else javascript:vod(0);@endif">{{$childMenu['title']}}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endif
                </ul>
            @endforeach

            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">{{session('admin.username')}}<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{url('/logout')}}" title="To logout the Admin dashboard">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
