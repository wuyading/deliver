@extends('sysadmin.layout')

@section('title', 'Page Title')

@section('head_css')
    <style>
        .table th{ text-align: right;width: 200px;}
        .tab-title{
            color: #ddd;
            font-size: 16px;
            margin: 10px;
        }
    </style>
@endsection

@section('content')
    <div class="page-content">
    @include('/sysadmin/common/crumb')

        <!-- END PAGE HEADER-->
        <div class="row" style="margin-top: 15px">
            <div class="col-md-12 col-sm-12">
                    <form action="{{ toRoute('deliver/ajax_save_deliver_product') }}" method="post">
                        <table class="table">
                            <tbody>
                            <tr>
                                <th><span style="color: red">*</span>选择商品：</th>
                                <td>
                                    <select name="product_id" id="product">
                                        <option value="">请选择商品</option>
                                        @foreach( $products as $product)
                                            <option format="{{ $product['format'] }}" price="{{ $product['sell_price'] }}" @if() @endif value="{{ $product['id'] }}">{{ $product['categorys']['name'].'—'.$product['sku'].'—'.$product['name'] }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <th>商品规格：</th>
                                <td>
                                    <input type="text" id="format" readonly class="form-control">
                                </td>
                            </tr>

                            <tr>
                                <th>商品单价：</th>
                                <td>
                                    <input type="text" id="price" readonly class="form-control">
                                </td>
                            </tr>

                            <tr>
                                <th><span style="color: red">*</span>商品数量：</th>
                                <td>
                                    <input type="number" min="0" id="num" name="product_num" value="{{ $product['num'] or ''}}" class="form-control" required>
                                </td>
                            </tr>

                            <tr>
                                <th>商品备注：</th>
                                <td>
                                    <input type="text" name="remark" value="{{ $product['num'] or ''}}" class="form-control">
                                </td>
                            </tr>

                            </tbody>
                        </table>
                        <div style="margin-top: 20px;text-align: center;">
                            <input type="hidden" name="id" value="{{ $id or '' }}">
                            <input type="hidden" name="orderInfoId" value="{{ $orderInfoId or '' }}">
                            <input type="submit" class="btn btn-primary  btn_save" value="&nbsp;&nbsp;&nbsp;提&nbsp;&nbsp;&nbsp;交&nbsp;&nbsp;&nbsp;保&nbsp;&nbsp;&nbsp;存&nbsp;&nbsp;&nbsp;">
                        </div>
                    </form>
                </div>
        </div>

        <div class="clearfix"></div>
        <!-- END DASHBOARD STATS 1-->
    </div>
@endsection

@section('footer_js')
    <?=asset_js('/assets/pages/scripts/dashboard.min.js')?>
    <script>
        $("#product").change(function () {
            $("#price").val($(this).children('option:selected').attr('price'));
            $("#format").val($(this).children('option:selected').attr('format'));
        });
    </script>
@endsection