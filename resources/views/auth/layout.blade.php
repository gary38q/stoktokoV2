@extends('base.base')

@section('content')
    <!--begin::Authentication-->
    <div
        class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed"
        style="background-image: url({{ asset(theme()->getMediaUrlPath() . 'illustrations/progress-hd.png') }})">

        <!--begin::Content-->
        <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
            <!--begin::Logo-->
                <h1>EDEN JAYA</h1>
                <br>
            <!--end::Logo-->

            <!--begin::Wrapper-->
            <div class="w-lg-500px bg-white rounded shadow-sm p-10 p-lg-15 mx-auto">
                {{ $slot }}
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Authentication-->
@endsection
