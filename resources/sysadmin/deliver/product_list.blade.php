@extends('sysadmin.layout')

@section('title', 'Page Title')

@section('head_css')
    <?=asset_css('/assets/layouts/layout/css/custom.min.css')?>
@endsection

@section('content')
    <div class="page-content">
    @include('/sysadmin/common/crumb')
    <!-- BEGIN PAGE TITLE-->
        <div class="row">
            <div style="margin: 15px ;">
                <a class="btn btn-danger" href="{{ toRoute('deliver/add_deliver_product',['id'=>$deliver['id']]) }}">添加发货单商品 <i class="fa fa-plus"></i></a>
                {{--<form action="{{ toRoute('deliver/index') }}" class="form-inline" method="get">--}}
                    {{--<div class="form-group">--}}
                        {{--<label class="control-label">发货单编号：</label>--}}
                        {{--<input type="text" class="form-control form-control-diy "  placeholder="请输入发货单编号" style="width: 200px" name="title" value="{{ $vars['title'] or '' }}">--}}
                    {{--</div>--}}

                    {{--<button type="submit" class="btn btn-default">查询</button>--}}
                {{--</form>--}}

            </div>
            <div style="font-size: 18px;">订单编号：{{ $deliver['order_no'] }}  &nbsp;&nbsp;客户：{{ $deliver['customer'] }}   &nbsp;&nbsp;联系人：{{ $deliver['contact'] }}   &nbsp;&nbsp;联系电话：{{ $deliver['mobile'] }}</div>
            <br/>
            <div class="col-md-12 col-sm-12">
                <table class="table table-hover">
                    <tr>
                        <th>序号</th>
                        <th>商品代码</th>
                        <th>商品名称</th>
                        <th>规格型号</th>
                        <th>单位</th>
                        <th>仓库</th>
                        <th>数量</th>
                        <th>单价</th>
                        <th>价税合计</th>
                        <th>备注</th>
                        <th>添加时间</th>
                        <th>操作</th>
                    </tr>

                    @if(isset($list))
                        @foreach( $list as $item )
                            <tr>
                                <td><?=$item['id'] ?></td>
                                <td><?=$item['product']['sku'] ?></td>
                                <td><?=$item['product_name'] ?></td>
                                <td><?=$item['product']['format'] ?></td>
                                <td><?=$item['product']['unit'] ?></td>
                                <td>总仓</td>
                                <td><?=$item['num'] ?></td>
                                <td><?=$item['product_price'] ?></td>
                                <td><?=$item['total_money'] ?></td>
                                <td><?=$item['remark'] ?></td>
                                <td><?=toDate($item['created_at'])?></td>
                                <td>
                                    <a href="<?=toRoute('deliver/add_deliver_product/'.$deliver['id'].'/'.$item['id'])?>" class="btn btn-primary">修改</a>
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
                    $.post('<?=toRoute('deliver/ajax_delete')?>',{'id':id},function (res) {
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