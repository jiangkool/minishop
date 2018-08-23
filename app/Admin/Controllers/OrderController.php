<?php

namespace App\Admin\Controllers;

use App\Models\Order;
use App\Models\User;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class OrderController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('订单管理');
            $content->description('列表');

            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('订单管理');
            $content->description('编辑');

            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('订单管理');
            $content->description('新增');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Order::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->user_id('会员帐号')->display(function($user_id){
                $user=User::find($user_id);
                return $user->nickname;
            });
            $grid->pay_id('支付id');
            $grid->column('收件人信息')->display(function(){
                return "<table class='table' style='width:300px;'>"
              ."<tr><th>姓名</th><td>". $this->consignee ."</td></tr>"
              ."<tr><th>电话</th><td>". $this->phone ."</td></tr>"
              ."<tr><th>收件地址</th><td>". $this->address ."</td></tr>"
              ."</table>";
            });
            $grid->column('付款信息')->display(function(){
                return "<table class='table' style='width:300px;'>"
              ."<tr><th>订单总金额</th><td>". $this->tradetotal ."</td></tr>"
              ."<tr><th>订单优惠金额</th><td>". $this->preferentialtotal ."</td></tr>"
              ."<tr><th>邮费</th><td>". $this->customerfreightfee ."</td></tr>"
              ."<tr><th>订单实付金额</th><td>". $this->total ."</td></tr>"
              ."</table>";
            });
            $grid->out_trade_no('订单号');
            $grid->column('订单信息')->display(function(){
                $str='';
                foreach ($this->orderItems as $item) {
                    $str=$str."<tr><td>". $item->title ."</td><td>". $item->norm ."</td><td>". $item->num ."</td><td>". $item->pre_price ."</td><td>". $item->total_price ."</td></tr>";
                }
                
                return "<table class='table' style='width:300px;'><tr><th>商品名</th><th>规格参数</th><th>数量</th><th>单价</th><th>总价</th></tr>".$str."</table>";
            });
            $grid->freightbillno('物流单号');
            $grid->status('状态')->display(function($status){
                //0=待付,1=失效,2=已付,3=发货,4=已收（待评),5=完成
                switch ($status) {
                    case 0:
                        return '<span class="label label-default">待付</span>';
                        break;
                    case 1:
                        return '<span class="label label-error">失效</span>';
                        break;
                    case 2:
                        return '<span class="label label-default">已付</span>';
                        break;
                    case 3:
                        return '<span class="label label-default">发货</span>';
                        break;
                    case 4:
                        return '<span class="label label-default">已收（待评)</span>';
                        break;
                    case 5:
                        return '<span class="label label-success">完成</span>';
                        break;
                    default:
                        return '<span class="label label-default">待付</span>';
                        break;
                }
            });
            //付款方式 0=微信支付，1=M币支付
            $grid->type('付款方式')->display(function($type){
                return $type==1?'<span class="label label-default">M币支付</span>':'<span class="label label-default">微信支付</span>';
            });
            $grid->remark('买家留言');
            $grid->created_at();
            $grid->updated_at();
            //$grid->disableActions();
            $grid->filter(function($filter){
                $filter->disableIdFilter();
                $filter->like('out_trade_no','订单号');
            });
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Order::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
