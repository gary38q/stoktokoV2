@php
    $toolbarButtonMarginClass = "ms-1 ms-lg-3";
    $toolbarButtonHeightClass = "w-40px h-40px";
    $toolbarUserAvatarHeightClass = "symbol-40px";
    $toolbarButtonIconSizeClass = "svg-icon-1";
@endphp

{{--begin::Toolbar wrapper--}}
<div class="d-flex align-items-stretch flex-shrink-0">

    {{--begin::User--}}
    @if(Auth::check())
        <div class="d-flex align-items-center {{ $toolbarButtonMarginClass }}" id="kt_header_user_menu_toggle">
            {{--begin::Menu--}}
            <div class="cursor-pointer symbol {{ $toolbarUserAvatarHeightClass }}" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end" data-kt-menu-flip="bottom">
                <img src="{{ auth()->user()->avatar_url }}" alt="metronic"/>
            </div>
            {{ theme()->getView('partials/topbar/_user-menu') }}
            {{--end::Menu--}}
        </div>
    @endif
    {{--end::User --}}
</div>
{{--end::Toolbar wrapper--}}
