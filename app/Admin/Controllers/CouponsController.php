<?php

namespace App\Admin\Controllers;

use App\Models\Coupon;
use Carbon\Carbon;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class CouponsController extends Controller
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

            $content->header('优惠券管理');
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

            $content->header('优惠券管理');
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

            $content->header('优惠券管理');
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
        return Admin::grid(Coupon::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->column('title','优惠券名称');
            $grid->column('par_value','面值|单位:元');
            $grid->column('more_value','满多少可用|单位:元');
            $grid->column('quantum','数量');
            $grid->column('receive','领取人数');
            $grid->column('start_at','开始时间');
            $grid->column('end_at','结束时间');
            $grid->column('状态')->display(function(){
              $start = Carbon::parse($this->start_at);
              $end = Carbon::parse($this->end_at);
              $now = Carbon::now();
              if ($this->status == 1) {
                if($now->lt($start)) { return '<span class="badge">敬请期待</span>'; }
                if ($now->between($start, $end)) {
                   if($this->status == 1) {
                     return '<span class="label label-success">火热进行中</span>';
                   }
                   return '<span class="badge">还没开始就注定已经结束~_~</span>';
                }
                if ($now->gt($end)) { return '<span class="badge">活动结束</span>'; }
              } else {
                return '<span class="badge">不参与活动</span>';
              }

            });
            $grid->filter(function($filter){
                $filter->disbaleIdFilter();
                $filter->like('title','关键词');
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
        return Admin::form(Coupon::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->text('title','优惠券主题');
            $form->currency('par_value','面值')->symbol('￥');
            $form->currency('more_value','满减')->symbol('￥');
            $form->number('quantum', '数量')->min(1);
            $form->datetimeRange('start_at', 'end_at', '有效期限');
            $states = [
                    'on'  => ['value' => 1, 'text' => '参与', 'color' => 'success'],
                    'off' => ['value' => 0, 'text' => '不参与', 'color' => 'danger'],
                ];
            $form->switch('status','参与活动?')->states($states);
            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
