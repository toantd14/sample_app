<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <button class="navbar-toggler btn-toggle-top-page" id="btn-toggle-menu" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav list-menu">
            <li class="nav-item menu-item text-center"><a class="nav-link p-0" href="{{ route('top.index') }}">トップ</a></li>
            <li class="nav-item menu-item text-center"><a class="nav-link p-0" href="{{ route('parkinglot.index') }}">駐車場管理</a></li>
            <li class="nav-item menu-item text-center"><a class="nav-link p-0" href="{{ route('menus.index') }}">駐車場メニュー</a></li>

            <li class="nav-item menu-item text-center"><a class="nav-link p-0" href="{{ route('notifications.index') }}">お知らせ管理</a></li>
            <li class="nav-item menu-item text-center"><a class="nav-link p-0" href="{{ route('time-used.index') }}">実績管理</a></li>
            <li class="nav-item menu-item text-center"><a class="nav-link p-0" href="{{ route('member.edit', Auth::guard('owner')->user()->owner_cd) }}">プロフィール</a></li>
            <li class="nav-item menu-item text-center"><a class="nav-link p-0" href="{{ route('get.owner.logout') }}">ログアウト</a></li>
        </ul>
    </div>
</nav>
