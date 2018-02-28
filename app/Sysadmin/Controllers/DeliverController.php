<?php
/**
 * Created by PhpStorm.
 * User: lilei
 * Date: 17-6-13
 * Time: 下午1:06
 */

namespace App\Sysadmin\Controllers;

use App\Models\Order;
use App\Models\OrderInfo;
use App\Models\Product;
use Zilf\Facades\Request;

class DeliverController extends SysadminBaseController
{

    public function __construct()
    {
        parent::__construct();

        $this->isLogin();
    }

    //订单列表
    public function index()
    {
        $currentPage = Request::query()->getInt('zget0');
        $currentPage = $currentPage > 0 ? $currentPage : 1;
        $vars = Request::query()->all();
        $order = Order::find();
        if (!empty($vars['title'])) {
            $order-> andWhere(['like','order.order_no',trim($vars['title'])]);
        }
        $urlPattern = toRoute('deliver/index/(:num)?'.$_SERVER['QUERY_STRING']);
        $data = Order::getModelPageList($order,'order.*',null,null,null , $urlPattern, $currentPage);
        return $this->render('/deliver/index',[
            'vars' => $vars,
            'list' => $data['list'],
            'page' => $data['page']
        ]);;
    }

    //添加发货单
    public function add()
    {
        $id = Request::query()->getInt('id');
        $deliver_info = [];
        if($id){
            $deliver_info = Order::findOne($id)->toArray();
        }
        return $this->render('/deliver/add',['data'=>$deliver_info]);
    }

    //保存发货单
    public function ajax_save_deliver()
    {
        if(Request::isMethod('post')){
            $id = Request::request()->get('id');
            $data = Request::request()->get('info');
            $data['updated_at'] = time();
            $data['created_user_id'] = $this->userInfo['id'];
            $is_success = false;
            if (!empty($id)) { //修改内容
                $product = Order::findOne($id);
                if ($product) {
                    $product->setAttributes($data);
                    $is_success = $product->update();
                }
            } else { //添加内容
                $data['order_no'] = getOrderSn();
                $data['created_at'] = time();
                $model = new Order();
                $model->setAttributes($data);
                $is_success = $model->save();
            }
            if ($is_success) {
                $this->redirect('/sysadmin/deliver');
            } else {
            }
        }
    }

    //发货单商品明细
    public function product_list()
    {
        $id = Request::query()->getInt('id');
        $deliver = Order::findOne($id)->toArray();
        $product_list = OrderInfo::find()->joinWith('product')->where(['order_id'=>$id])->asArray()->all();
        return $this->render('/deliver/product_list',['deliver'=>$deliver,'list'=>$product_list]);
    }

    //添加发货单商品
    public function add_deliver_product()
    {
        $id = Request::query()->get('zget0');
        $orderInfoId = Request::query()->get('zget1');
        $orderInfoId = $orderInfoId?$orderInfoId:'0';
        $products = Product::find()->joinWith('categorys')->asArray()->all();
        return $this->render('/deliver/add_deliver_product',[
            'products'=>$products,
            'id' => $id,
            'orderInfoId' => $orderInfoId
        ]);
    }

    //保存发货单商品
    public function ajax_save_deliver_product()
    {
        if (Request::isMethod('post')) {
            $id = Request::request()->get('id');
            $orderInfoId = Request::request()->get('orderInfoId');
            //根据发货单id获取发货单信息
            $deliver = Order::findOne($id)->toArray();
            $product_id = Request::request()->getInt('product_id');
            if(!isset($product_id) || $product_id == ''){
                die('请选择发货单商品！');
            }else{
                $product = Product::findOne($product_id)->toArray();
            }
            $data['order_id'] = $deliver['id'];
            $data['order_no'] = $deliver['order_no'];
            $data['product_id'] = $product_id;
            $data['product_price'] = $product['sell_price'];
            $data['num'] = Request::request()->get('product_num');
            $data['remark'] = Request::request()->get('remark');
            $total_price = $product['sell_price'] * $data['num'];
            $data['product_name'] = $product['name'];
            $data['product_img'] = $product['image'];
            $data['total_money'] = $total_price;
            $data['updated_at'] = time();
            $data['created_user_id'] = $this->userInfo['id'];
            $is_success = false;
            if (!empty($orderInfoId)) { //修改内容
                $orderInfo = OrderInfo::findOne($orderInfoId);
                if ($orderInfo) {
                    $orderInfo->setAttributes($data);
                    $is_success = $orderInfo->update();
                }
            } else { //添加内容
                $data['created_at'] = time();
                $model = new OrderInfo();
                $model->setAttributes($data);
                $is_success = $model->save();
            }
            if ($is_success) {
                $this->redirect('/sysadmin/deliver/product_list?id='.$id);
            } else {
                echo 2;die;
            }
        }
    }

    private function json_callback($data,$parent='parent',$method='show_message'){
        if(is_array($data)){
            $data = json_encode($data);
        }

        echo <<<EOT
        <script type="text/javascript">
            {$parent}.{$method}($data);
        </script>
EOT;
        die();
    }

}