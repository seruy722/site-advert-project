<div class="container">
        <div class="row">
            <div class="col-md-12">
                @if (Auth::guest())
                    @else
                    @if (Auth::user()->role === 'admin')
                    <ul class="nav nav-tabs">
                            <li role="presentation" class="{{ (Route::currentRouteName() == 'accounts.admin.home') ? 'active' : '' }}"><a href="{{route('accounts.admin.home',Auth::id())}}">Новые обьявления</a></li>
                            <li role="presentation" class="{{ (Route::currentRouteName() == 'accounts.admin.users') ? 'active' : '' }}"><a href="{{route('accounts.admin.users')}}">Пользователи</a></li>
                            <li role="presentation" class="{{ (Route::currentRouteName() == 'accounts.admin.blokedList') ? 'active' : '' }}"><a href="{{route('accounts.admin.blokedList')}}">Черный список</a></li>
                            <li role="presentation" class="{{ (Route::currentRouteName() == 'accounts.admin.rubrics') ? 'active' : '' }}"><a href="{{route('accounts.admin.rubrics')}}">Рубрики</a></li>
                            <li role="presentation" class="{{ (Route::currentRouteName() == 'accounts.admin.settings') ? 'active' : '' }}"><a href="{{route('accounts.admin.settings',Auth::id())}}">Настройки</a></li>
                        </ul>
                    @endif
                    @if (Auth::user()->role === 'user')
                    <ul class="nav nav-tabs">
                            <li role="presentation" class="{{ (Route::currentRouteName() == 'accounts.user.home') ? 'active' : '' }}"><a href="{{route('accounts.user.home',Auth::id())}}">Обьявления</a></li>
                            <li role="presentation" class="{{ (Route::currentRouteName() == 'accounts.user.settings') ? 'active' : '' }}"><a href="{{route('accounts.user.settings',Auth::id())}}">Настройки</a></li>
                    </ul>
                    @endif 
                @endif
                    
            </div>
        </div>
    </div>