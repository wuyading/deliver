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
use Zilf\Facades\Request;

class AccountController extends SysadminBaseController
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
        $account = Account::find();
        if (!empty($vars['title'])) {
            $account-> andWhere(['like','account.account_name',trim($vars['title'])]);
        }
        $urlPattern = toRoute('account/index/(:num)?'.$_SERVER['QUERY_STRING']);
        $data = Account::getModelPageList($account,'account.*',null,null,null , $urlPattern, $currentPage);
        return $this->render('/account/index',[
            'vars' => $vars,
            'list' => $data['list'],
            'page' => $data['page']
        ]);
    }

    //添加收款账户
    public function add()
    {
        $id = Request::query()->getInt('id');
        $account_info = [];
        if($id){
            $account_info = Account::findOne($id)->toArray();
        }
        return $this->render('/account/add',['data'=>$account_info]);
    }

    //保存收款账户
    public function ajax_save_account()
    {
        if(Request::isMethod('post')){
            $id = Request::request()->get('id');
            $data = Request::request()->get('info');
            $data['updated_at'] = time();
            $is_success = false;
            if (!empty($id)) { //修改内容
                $product = Account::findOne($id);
                if ($product) {
                    $product->setAttributes($data);
                    $is_success = $product->update();
                }
            } else { //添加内容
                $data['created_at'] = time();
                $model = new Account();
                $model->setAttributes($data);
                $is_success = $model->save();
            }
            if ($is_success) {
                $this->redirect('/sysadmin/account');
            } else {
            }
        }
    }

    /**
     * 删除收款账户
     */
    public function ajax_delete(){
        $id = Request::request()->getInt('id');
        if($id){
            $model = Account::findOne(['id'=>$id]);
            $is_success = $model->delete();
            if ($is_success) {
                $res = ['code' => 1001, 'msg' => '删除成功！'];
            } else {
                $res = ['code' => 2001, 'msg' => '删除失败！'];
            }
            return $this->json($res);
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