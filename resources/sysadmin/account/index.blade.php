@extends('sysadmin.layout')

@section('title', '')

@section('head_css')
    <?=asset_css('/assets/layouts/layout/css/custom.min.css')?>
@endsection

@section('content')
    <div class="page-content">
    @include('/sysadmin/common/crumb')
    <!-- BEGIN PAGE TITLE-->
        <div class="row">
            <div style="margin: 15px ;">
                <a class="btn btn-danger" href="{{ toRoute('account/add') }}">添加收款账户 <i class="fa fa-plus"></i></a>
                <br>  <br>
                <form action="{{ toRoute('account/index') }}" class="form-inline" method="get">
                    <div class="form-group">
                        <label class="control-label">账户名：</label>
                        <input type="text" class="form-control form-control-diy "  placeholder="请输入账户名" style="width: 200px" name="title" value="{{ $vars['title'] or '' }}">
                    </div>

                    <button type="submit" class="btn btn-default">查询</button>
                </form>

            </div>
            <div class="col-md-12 col-sm-12">
                <table class="table table-hover">
                    <tr>
                        <th>序号</th>
                        <th>账户名称</th>
                        <th>银行名称</th>
                        <th>银行卡号</th>
                        <th>支付宝账号</th>
                        <th>微信号</th>
                        <th>添加时间</th>
                        <th>操作</th>
                    </tr>

                    @if(isset($list))
                        @foreach( $list as $item )
                            <tr>
                                <td>{{ $item['id'] }}</td>
                                <td>{{ $item['account_name'] }}</td>
                                <td>{{ $item['bank_name'] }}</td>
                                <td>{{ $item['bank_num'] }}</td>
                                <td>{{ $item['alipay'] }}</td>
                                <td>{{ $item['wechat'] }}</td>
                                <td>{{ toDate($item['created_at']) }}</td>
                                <td>
                                    <a href="<?=toRoute('account/add?id='.$item['id'])?>" class="btn btn-primary">修改</a>
                                    <a class="btn btn-danger" href="javascript:void(0)" onclick="ajaxDelete(<?=$item['id']?>)">删除</a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </table>
                <div class="pagination">
                    {!!  isset($page) ? $page : ''  !!}
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE TITLE-->
    <!-- END PAGE HEADER-->
    <!-- BEGIN DASHBOARD STATS 1-->
    <div class="clearfix"></div>
    <!-- END DASHBOARD STATS 1-->
    </div>
@endsection

@section('footer_js')
    <?=asset_js('/assets/pages/scripts/dashboard.min.js')?>
    <script type="text/javascript">
        function ajaxDelete(id){
            layer.alert('确定删除吗,删除后将不能恢复？', {
                icon: 6
                ,time: 0 //不自动关闭
                ,btn: ['确定', '取消']
                ,area: '200px'
                ,yes: function(index){
                    layer.close(index);
                    $.post('<?=toRoute('account/ajax_delete')?>',{'id':id},function (res) {
                        if(res.code == 1001){
                            layer.alert(res.msg, {
                                icon: 6
                                ,time: 0 //不自动关闭
                                ,btn: ['确定']
                                ,area: '200px'
                                ,yes: function(index){
                                    layer.close(index);
                                    window.location.reload();
                                }
                            });
                        }else{
                            layer.alert(res.msg, {icon: 0,time:0,closeBtn: 0});
                        }
                    },'json');
                }
                ,no: function(index){
                    layer.close(index);
                }
            });
        }
    </script>
@endsection

<style type="text/css">
    .table img{width: 80px;height: 80px}
</style>