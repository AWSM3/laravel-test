<nav class="col-md-2 d-none d-md-block bg-light sidebar">
    <div class="sidebar-sticky">
        <ul class="nav flex-column">
            @foreach ($navigation as $item)
                <li class="nav-item">
                    <a class="nav-link {{ $item->isActive() ? 'active' : '' }}" href="{{ $item->getUrl() }}">
                        {{ $item->getTitle() }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</nav>