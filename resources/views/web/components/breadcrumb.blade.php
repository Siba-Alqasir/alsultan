<!-- breadcrumb area start -->
<div class="breadcrumb__area breadcrumb__height grey-bg p-relative"
        style="background: url('{{$data['page']['header']}}'); background-repeat: no-repeat; background-size: cover;">
    <div class="container">
        <div class="row">
            <div class="col-xxl-12">
                <div class="breadcrumb__content text-center z-index">

                    <div class="breadcrumb__section-title-box mb-20">
                    <h3 class="breadcrumb__title text-uppercase">{{$data['page']['title']}}</h3>
                    </div>
                    <div class="breadcrumb__list mb-10">
                    <span><a href="{{LaravelLocalization::localizeUrl('/')}}">{{_t('Home')}}</a></span>
                    <span class="dvdr">&nbsp;&bullet;&nbsp;</span>
                    <span>{{$data['page']['title']}}</span>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- breadcrumb area end -->
