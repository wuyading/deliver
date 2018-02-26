@extends('sysadmin.layout')

@section('title', 'Page Title')

@section('head_css')
    <?=asset_css('/assets/layouts/layout/css/custom.min.css')?>
@endsection

@section('content')
    <div class="page-content">
    @include('/sysadmin/common/crumb')
    <!-- BEGIN PAGE TITLE-->
        <div class="row show_print" style="width:1507px;background:#ffffff">
            6666
        </div>
        <input type="submit" class="btn btn-lg btn-primary btn-print" value="打印页面">
        <!-- END PAGE TITLE-->
    <!-- END PAGE HEADER-->
    <!-- BEGIN DASHBOARD STATS 1-->
    <div class="clearfix"></div>
    <!-- END DASHBOARD STATS 1-->
    </div>
@endsection

@section('footer_js')
    <?=asset_js('/assets/pages/scripts/dashboard.min.js')?>
    <?=asset_js('/assets/jquery.jqprint-0.3.js')?>
    <script type="text/javascript">
        jQuery.uaMatch = function( ua ) {
            ua = ua.toLowerCase();

            var match = /(chrome)[ \/]([\w.]+)/.exec( ua ) ||
                /(webkit)[ \/]([\w.]+)/.exec( ua ) ||
                /(opera)(?:.*version|)[ \/]([\w.]+)/.exec( ua ) ||
                /(msie)[\s?]([\w.]+)/.exec( ua ) ||
                /(trident)(?:.*? rv:([\w.]+)|)/.exec( ua ) ||
                ua.indexOf("compatible") < 0 && /(mozilla)(?:.*? rv:([\w.]+)|)/.exec( ua ) ||
                [];

            return {
                browser: match[ 1 ] || "",
                version: match[ 2 ] || "0"
            };
        };

        matched = jQuery.uaMatch( navigator.userAgent );
        //IE 11+ fix (Trident)
        matched.browser = matched.browser == 'trident' ? 'msie' : matched.browser;
        browser = {};

        if ( matched.browser ) {
            browser[ matched.browser ] = true;
            browser.version = matched.version;
        }

        // Chrome is Webkit, but Webkit is also Safari.
        if ( browser.chrome ) {
            browser.webkit = true;
        } else if ( browser.webkit ) {
            browser.safari = true;
        }

        jQuery.browser = browser;
        $(".btn-print").click(function () {
            $.each($('textarea'),function () {
                if($(this).val()){
                    $(this).height(this.scrollHeight);
                }
            });
            $('.show_print').jqprint();
        });
    </script>
@endsection
