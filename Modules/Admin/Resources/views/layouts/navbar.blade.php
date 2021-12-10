<nav class="navbar navbar-expand-lg navbar-light bg-light pt-0">
    <button class="navbar-toggler btn-toggle-top-page" id="btn-toggle-menu" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse " id="navbarNav">
        <ul class="navbar-nav list-menu">
            <li class="nav-item menu-item text-center"><a class="nav-link p-0" href="{{ route('owners.index') }}">オーナー管理</a></li>
            <li class="nav-item menu-item text-center"><a class="nav-link p-0" href="{{ route('parkings.index') }}">駐車場管理</a></li>
            <li class="nav-item menu-item text-center"><a class="nav-link p-0" href="{{ route('users.list') }}">利用者管理</a></li>
            <li class="nav-item menu-item text-center"><a class="nav-link p-0" href="{{ route('use-situations.index') }}">実績管理</a></li>
            <li class="nav-item menu-item text-center"><a class="nav-link p-0" href="{{ route('get.admin.logout') }}">ログアウト</a></li>
        </ul>
    </div>
</nav>
