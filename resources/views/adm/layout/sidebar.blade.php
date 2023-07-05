<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Menu</li>
                <li>
                    <a href="{{ route('adm.dash') }}" class="waves-effect">
                        <i class="ri-dashboard-line"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                @foreach ($modules as $module)
                @if (!$module->children)
                @if (in_array($module->id, $user->permissions))
                <li>
                    <a href="{{ route('adm.module.'.$module->id.'.index') }}" class="waves-effect {{ $current_module==$module->id?'active':'' }}">
                        <i class="{{ $module->icon }}"></i>
                        <span>{{ $module->title }}</span>
                    </a>
                </li>
                @endif

                @else
                <?php
                $has = false;
                $open = false;
                foreach ($module->children as $key => $sub) {
                    if (in_array($sub->id, $user->permissions)) {
                        $has = true;
                    }
                    if ($current_module == $sub->id) {
                        $open = true;
                    }
                }
                ?>

                @if ($has)
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect {{ $current_module==$module->id?'active':'' }}">
                        <i class="{{ $module->icon }}"></i>
                        <span>{{ $module->title }}</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        @foreach ($module->children as $sub)
                        @if (in_array($sub->id, $user->permissions))
                        <li>
                            <a href="{{ route('adm.module.'.$sub->id.'.index') }}">
                                <i class="{{ $sub->icon }}"></i>
                                {{ $sub->title }}
                            </a>
                        </li>
                        @endif
                        @endforeach
                    </ul>
                </li>
                @endif
                @endif
                @endforeach
            </ul>
        </div>
    </div>
</div>
