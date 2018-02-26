<?php
/**
 * Created by PhpStorm.
 * User: lilei
 * Date: 17-6-13
 * Time: 下午1:06
 */

namespace App\Sysadmin\Controllers;

use App\Models\Order;
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
        return $this->render('/deliver/product_list',['deliver'=>$deliver]);
    }

    //添加发货单商品
    public function add_deliver_product()
    {
        return $this->render('/deliver/add_deliver_product');
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