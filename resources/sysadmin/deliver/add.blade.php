@extends('sysadmin.layout')

@section('title', '')

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
                    <form action="{{ toRoute('deliver/ajax_save_deliver') }}" method="post">
                        <table class="table">
                            <tbody>
                            <tr>
                                <th><span style="color: red">*</span>客 &nbsp;&nbsp;&nbsp;&nbsp; 户：</th>
                                <td>
                                    <input type="text" id="" name="info[customer]" value="{{ $data['customer'] or ''}}" class="form-control" required>
                                </td>
                            </tr>

                            <tr>
                                <th><span style="color: red">*</span>日 &nbsp;&nbsp;&nbsp;&nbsp; 期：</th>
                                <td>
                                    <input type="text" id="" name="info[order_date]" value="{{ $data['order_date'] or ''}}" class="form-control" required>
                                </td>
                            </tr>

                            <tr>
                                <th><span style="color: red">*</span>联 &nbsp;系&nbsp;人：</th>
                                <td>
                                    <input type="text" id="" name="info[contact]" value="{{ $data['contact'] or ''}}" class="form-control" required>
                                </td>
                            </tr>

                            <tr>
                                <th><span style="color: red">*</span>联系电话：</th>
                                <td>
                                    <input type="text" id="" name="info[mobile]" value="{{ $data['mobile'] or ''}}" class="form-control" required>
                                </td>
                            </tr>

                            <tr>
                                <th>结算方式：</th>
                                <td>
                                    <input type="text" id="" name="info[pay_type]" value="{{ $data['pay_type'] or ''}}" class="form-control">
                                </td>
                            </tr>

                            <tr>
                                <th><span style="color: red">*</span>送货地址：</th>
                                <td>
                                    <input type="text" id="" name="info[deliver_addr]" value="{{ $data['deliver_addr'] or ''}}" class="form-control" required>
                                </td>
                            </tr>

                            <tr>
                                <th><span style="color: red">*</span>销售人员：</th>
                                <td>
                                    <input type="text" id="" name="info[sale_user]"  value="{{ $data['sale_user'] or ''}}" class="form-control" required>
                                </td>
                            </tr>

                            <tr>
                                <th>审 &nbsp;&nbsp;&nbsp;&nbsp; 核：</th>
                                <td>
                                    <input type="text" id="" name="info[approver]" value="{{ $data['approver'] or ''}}" class="form-control">
                                </td>
                            </tr>

                            <tr>
                                <th>收&nbsp;&nbsp; 款&nbsp;&nbsp; 人:</th>
                                <td>
                                    <select name="info[account_id]" id="" class="form-control" required>
                                        @foreach($accounts as $account)
                                            <option @if($data['account_id'] == $account['id']) selected @endif value="{{ $account['id'] }}">{{ $account['account_name'] }}</option>
                                        @endforeach
                                    </select>
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