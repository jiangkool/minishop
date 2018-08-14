<?php

namespace App\Admin\Controllers;

use App\Models\Payment;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class PaymentController extends Controller
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

            $content->header('支付记录');
            $content->description('description');

            $content->body($this->grid());
        });
    }

   

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Payment::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->user_id('用户ID');
            $grid->paiedtotal('订单已付金额');
            $grid->type('付款方式')->display(function($type){
                return $type==1?'<span class="label label-default">M币支付</span>':'<span class="label label-default">微信支付</span>';
            });
            $grid->status('付款状态')->display(function($status){
                 return $status==1?'<span class="label label-default">已支付</span>':'<span class="label label-default">未支付</span>';
            });
            $grid->created_at();
            $grid->updated_at();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Payment::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
