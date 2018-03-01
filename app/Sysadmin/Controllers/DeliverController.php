<?php
/**
 * Created by PhpStorm.
 * User: lilei
 * Date: 17-6-13
 * Time: 下午1:06
 */

namespace App\Sysadmin\Controllers;

use App\Models\Account;
use App\Models\Order;
use App\Models\OrderInfo;
use App\Models\Product;
use function GuzzleHttp\Promise\all;
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
        $order = Order::find()->joinWith('userInfo')->joinWith('accountInfo');
        if (!empty($vars['title'])) {
            $order->andWhere(['like', 'order.order_no', trim($vars['title'])]);
        }
        $urlPattern = toRoute('deliver/index/(:num)?' . $_SERVER['QUERY_STRING']);
        $data = Order::getModelPageList($order, 'order.*', null, null, null, $urlPattern, $currentPage);
        return $this->render('/deliver/index', [
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
        //获取收款账户
        $accounts = Account::find()->asArray()->all();
        if ($id) {
            $deliver_info = Order::findOne($id)->toArray();
        }
        return $this->render('/deliver/add', ['data' => $deliver_info, 'accounts' => $accounts]);
    }

    //保存发货单
    public function ajax_save_deliver()
    {
        if (Request::isMethod('post')) {
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
        $deliver = Order::find()->where(['order.id' => $id])->joinWith('accountInfo')->asArray()->one();
        $product_list = OrderInfo::find()->joinWith('product')->where(['order_id' => $id])->asArray()->all();
        return $this->render('/deliver/product_list', ['deliver' => $deliver, 'list' => $product_list]);
    }

    //添加发货单商品
    public function add_deliver_product()
    {
        $id = Request::query()->get('zget0');
        $orderInfoId = Request::query()->get('zget1');
        $orderInfoId = $orderInfoId ? $orderInfoId : '0';
        $orderInfo = [];
        if ($orderInfoId) {
            $orderInfo = OrderInfo::find()->where(['order_info.id' => $orderInfoId])->joinWith('product')->asArray()->one();
        }
        $products = Product::find()->joinWith('categorys')->asArray()->all();
        return $this->render('/deliver/add_deliver_product', [
            'products' => $products,
            'id' => $id,
            'orderInfoId' => $orderInfoId,
            'orderInfo' => $orderInfo
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
            if (!isset($product_id) || $product_id == '') {
                die('请选择发货单商品！');
            } else {
                $product = Product::findOne($product_id)->toArray();
            }
            $data['order_id'] = $deliver['id'];
            $data['order_no'] = $deliver['order_no'];
            $data['product_id'] = $product_id;
            $data['product_price'] = $product['sell_price'];
            $data['num'] = Request::request()->get('product_num');
            $data['remark'] = Request::request()->get('remark');
            $total_price = $product['sell_price'] * $data['num'];
            $data['product_sku'] = $product['sku'];
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
                $this->redirect('/sysadmin/deliver/product_list?id=' . $id);
            } else {
                echo 2;
                die;
            }
        }
    }

    /**
     * 删除发货单
     */
    public function ajax_delete()
    {
        $id = Request::request()->getInt('id');
        if ($id) {
            $model = Order::findOne(['id' => $id]);
            $is_success = $model->delete();
            if ($is_success) {
                $res = ['code' => 1001, 'msg' => '删除成功！'];
            } else {
                $res = ['code' => 2001, 'msg' => '删除失败！'];
            }
            return $this->json($res);
        }
    }

    /**
     * 删除发货单商品
     */
    public function ajax_delete_product()
    {
        $id = Request::request()->getInt('id');
        if ($id) {
            $model = OrderInfo::findOne(['id' => $id]);
            $is_success = $model->delete();
            if ($is_success) {
                $res = ['code' => 1001, 'msg' => '删除成功！'];
            } else {
                $res = ['code' => 2001, 'msg' => '删除失败！'];
            }
            return $this->json($res);
        }
    }

    /**
     * 生成发货单
     */
    public function detail()
    {
        $id = Request::query()->getInt('zget0');
        if ($id) {
            //查看该发货单下手否有商品
            $deliver_product = OrderInfo::find()->where(['order_id' => $id])->count();
            if (!$deliver_product) {
                die('请添加发货单商品！');
            } else {
                $deliverInfo = Order::find()->joinWith('userInfo')->joinWith('accountInfo')->where(['order.id'=>$id])->asArray()->one();
                $model = OrderInfo::find()->where(['order_id' => $id]);
                $deliver_products = $model->joinWith('product')->asArray()->all();
                //获取商品总数量
                $totalNum = $model->sum('num');
                $totalMoney = $model->sum('total_money');
                return $this->render('/deliver/detail', [
                    'list' => $deliver_products,
                    'deliverInfo' => $deliverInfo,
                    'totalNum' => $totalNum,
                    'totalMoney' => $totalMoney,
                ]);
            }
        }
    }

    private function json_callback($data, $parent = 'parent', $method = 'show_message')
    {
        if (is_array($data)) {
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