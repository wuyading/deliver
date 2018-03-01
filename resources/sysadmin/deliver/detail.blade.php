@extends('sysadmin.layout')

@section('title', '')

@section('head_css')
    <?=asset_css('/assets/layouts/layout/css/custom.min.css')?>
    <style>
        #table1{margin-top:20px;margin-bottom: 5px;}
        #table1 tr,#table1 td{height: 30px;}
        #table1 th,#table1 tr{}



        #table2{border: 1px solid;margin-bottom:10px;}
        #table2 tr,#table2 td{text-align:center;border: 1px solid;height: 40px;}
        #table2 th,#table2 tr{text-align: center;}
        .btn{display:inherit;margin: 0 auto}

        @media print {
            .btn{display: none}
        }

        #table3{margin-bottom: 20px;}
        ul li{list-style: none}

        #table4{margin-bottom: 40px;}
        #table4 td{height:25px;}
    </style>
@endsection

@section('content')
    <div class="page-content">
    @include('/sysadmin/common/crumb')
        <a style="width:60px;margin-top:5px;float:left;" class="btn btn-primary" href="javascript:history.go(-1);">返回</a>
    <!-- BEGIN PAGE TITLE-->
        <div class="row show_print" style="width:95%;margin-left:5px;background:#ffffff">
            <table id="table1" class="col-md-12 col-sm-12" cellspacing="0"  style="border-collapse:collapse;">
                <tr>
                    <td colspan="12" class="text-center"><h3>安诺食品有限公司</h3><div style=" width:200px;margin:0 auto;border-bottom: 2px solid"></div></td>
                </tr>
                <tr>
                    <td>客户：&nbsp;&nbsp;{{ $deliverInfo['customer'] }}</td>
                    <td>日期：&nbsp;&nbsp;{{ $deliverInfo['order_date'] }}</td>
                    <td>编号：&nbsp;&nbsp;{{ $deliverInfo['order_no'] }}</td>
                </tr>
                <tr>
                    <td>联系人：&nbsp;&nbsp;{{ $deliverInfo['contact'] }}</td>
                    <td>电话：&nbsp;&nbsp;{{ $deliverInfo['mobile'] }}</td>
                    <td>结算方式：&nbsp;&nbsp;{{ $deliverInfo['pay_type'] }}</td>
                </tr>
                <tr>
                    <td>送货地址：&nbsp;&nbsp;{{ $deliverInfo['deliver_addr'] }}</td>
                </tr>
            </table>

            <table id="table2" class="col-md-12 col-sm-12 " border="1" cellspacing="0" bordercolor="#000000" style="border-collapse:collapse;">
                <tr>
                    <th class="col-md-1" style="width:100px;">商品代码</th>
                    <th class="col-md-2">商品名称</th>
                    <th class="col-md-2">规格型号</th>
                    <th class="col-md-1">单位</th>
                    <th class="col-md-1">仓库</th>
                    <th class="col-md-1">单价</th>
                    <th class="col-md-1">数量</th>
                    <th class="col-md-2">加税合计</th>
                    <th class="col-md-1">备注</th>
                </tr>
                @foreach($list as $item)
                    <tr>
                        <td>{{ $item['product_sku'] }}</td>
                        <td>{{ $item['product_name'] }}</td>
                        <td>{{ $item['product']['format'] }}</td>
                        <td>{{ $item['product']['unit'] }}</td>
                        <td>{{ '总仓' }}</td>
                        <td>{{ $item['product_price'] }}</td>
                        <td>{{ number_format($item['num'],'2','.','') }}</td>
                        <td>{{ $item['total_money'] }}</td>
                        <td>{{ $item['remark'] }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td id="total" colspan="6" style="text-align: left;padding-left:35px;">合计</td>
                    <td>{{ number_format($totalNum,'2','.','') }}</td>
                    <td>{{ $totalMoney }}</td>
                    <td></td>
                </tr>
            </table>

            <table id="table3" class="col-md-12 col-sm-12" cellspacing="0"  style="border-collapse:collapse;">
                <tr>
                    <td>销售人员：&nbsp;&nbsp;{{ $deliverInfo['sale_user'] }}</td>
                    <td>制单：&nbsp;&nbsp;{{ $deliverInfo['userInfo']['username'] }}</td>
                    <td>审核：&nbsp;&nbsp;{{ $deliverInfo['approver'] }}</td>
                </tr>
            </table>
            <table id="table4" class="col-md-12 col-sm-12" cellspacing="0"  style="border-collapse:collapse;">
                <tr>
                    <td>订货电话：15397287659，0573-82062227 &nbsp;&nbsp;&nbsp;&nbsp;地址：&nbsp;嘉兴市南湖区富润路105号</td>
                </tr>
                <tr>
                    <td>收款账号：{{ $deliverInfo['accountInfo']['bank_name'].'&nbsp;&nbsp;&nbsp;&nbsp;'.$deliverInfo['accountInfo']['bank_num'].'&nbsp;&nbsp;&nbsp;&nbsp;'.$deliverInfo['accountInfo']['account_name'] }} &nbsp;&nbsp; 支付宝账号：{{ $deliverInfo['accountInfo']['alipay'] }} &nbsp;&nbsp; 微信：{{ $deliverInfo['accountInfo']['wechat'] }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 客户签字：</td>
                </tr>
                <tr>
                    <td>备注：收货后请仔细检查如有疑问请在收到货后三天内提出异议或换货，逾期则视为认可，不得退换，谢谢！</td>
                </tr>
            </table>

        </div>
        <input type="submit" class="btn btn-lg btn-primary btn-print" onclick="window.print()" value="打印发货单">

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
//        $(".btn-print").click(function () {
//            $.each($('#table2 td'),function () {
//                if($(this).val()){
//                    $(this).height('50px');
//                }
//            });
//            $('.show_print').jqprint();
//        });
    </script>

@endsection
