{{--begin::Aside Menu--}}
@php
    $menu = bootstrap()->getAsideMenu();
    \App\Core\Adapters\Menu::filterMenuPermissions($menu->items);
    
    $modulnav = getmodulnav();
@endphp

<div
    class="hover-scroll-overlay-y my-5 my-lg-5"
    id="kt_aside_menu_wrapper"
    data-kt-scroll="true"
    data-kt-scroll-activate="{default: false, lg: true}"
    data-kt-scroll-height="auto"
    data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer"
    data-kt-scroll-wrappers="#kt_aside_menu"
    data-kt-scroll-offset="0"
>
    {{--begin::Menu--}}
    <div class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500" id="#kt_aside_menu" data-kt-menu="true">
        
        <div class="menu-item {{ $modulnav == "pembelian" ? 'here' : ''}}">
            <a class="menu-link" href="#">
                <span class="menu-bullet">
                    <span class="fas fa-shopping-cart"></span>
                </span>
                <span class="menu-title">Pembelian</span>
            </a>
        </div>

        <div class="menu-item {{ $modulnav == "produk" ? 'here' : ''}}">
            <a class="menu-link" href="#">
                <span class="menu-bullet">
                    <span class="fas fa-database"></span>
                </span>
                <span class="menu-title">Produk</span>
            </a>
        </div>
    </div>
    {{--end::Menu--}}
</div>
{{--end::Aside Menu--}}
