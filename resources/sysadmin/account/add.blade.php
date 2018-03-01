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
                    <form action="{{ toRoute('account/ajax_save_account') }}" method="post">
                        <table class="table">
                            <tbody>
                            <tr>
                                <th><span style="color: red">*</span>收款人姓名：</th>
                                <td>
                                    <input type="text" id="" name="info[account_name]" value="{{ $data['account_name'] or ''}}" class="form-control" required>
                                </td>
                            </tr>

                            <tr>
                                <th><span style="color: red">*</span>银行名称：</th>
                                <td>
                                    <select name="info[bank_name]" id="" required>
                                        <option value="">请选择银行</option>
                                        <option value="中国银行" @if(isset($data['bank_name']) && $data['bank_name'] == '中国银行' ) selected @endif >中国银行</option>
                                        <option value="人民银行" @if(isset($data['bank_name']) && $data['bank_name'] == '人民银行' ) selected @endif >中国人民银行</option>
                                        <option value="工商银行" @if(isset($data['bank_name']) && $data['bank_name'] == '工商银行' ) selected @endif >中国工商银行</option>
                                        <option value="建设银行" @if(isset($data['bank_name']) && $data['bank_name'] == '建设银行' ) selected @endif >中国建设银行</option>
                                        <option value="招商银行" @if(isset($data['bank_name']) && $data['bank_name'] == '招商银行' ) selected @endif >中国招商银行</option>
                                        <option value="农业银行" @if(isset($data['bank_name']) && $data['bank_name'] == '农业银行' ) selected @endif >中国农业银行</option>
                                        <option value="光大银行" @if(isset($data['bank_name']) && $data['bank_name'] == '光大银行' ) selected @endif >中国光大银行</option>
                                        <option value="民生银行" @if(isset($data['bank_name']) && $data['bank_name'] == '民生银行' ) selected @endif >中国民生银行</option>
                                        <option value="中信银行" @if(isset($data['bank_name']) && $data['bank_name'] == '中信银行' ) selected @endif >中信银行</option>
                                        <option value="兴业银行" @if(isset($data['bank_name']) && $data['bank_name'] == '兴业银行' ) selected @endif >兴业银行</option>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <th><span style="color: red">*</span>银行卡号：</th>
                                <td>
                                    <input type="number" id="" name="info[bank_num]" value="{{ $data['bank_num'] or ''}}" class="form-control" required>
                                </td>
                            </tr>

                            <tr>
                                <th><span style="color: red">*</span>支付宝账号：</th>
                                <td>
                                    <input type="text" id="" name="info[alipay]" value="{{ $data['alipay'] or ''}}" class="form-control" required>
                                </td>
                            </tr>

                            <tr>
                                <th><span style="color: red">*</span>微信账号：</th>
                                <td>
                                    <input type="text" id="" name="info[wechat]" value="{{ $data['wechat'] or ''}}" class="form-control" required>
                                </td>
                            </tr>

                            </tbody>
                        </table>
                        <div style="margin-top: 20px;text-align: center;">
                            <input type="hidden" name="id" value="{{ $data['id'] or '' }}">
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
@endsection