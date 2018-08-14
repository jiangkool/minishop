<?php

namespace App\Admin\Controllers;

use App\Models\Evaluate;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class EvaluateController extends Controller
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

            $content->header('评论管理');
            $content->description('description');

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

            $content->header('评论管理');
            $content->description('description');

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

            $content->header('评论管理');
            $content->description('description');

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
        return Admin::grid(Evaluate::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->order_id('订单ID');
            $grid->product_id('商品名称')->display(function(){
                return $this->procduct->title;
            });
            $grid->column('参数')->display(function(){
                $p_item=ProductItem::find($this->order_item_id);
                return $p_item->norm;
            });
            $grid->content('评价内容');
            $grid->images('图片')->map(function($path){
                return config('admin.url').'/'.$path;
            })->image('',50,50);
            $states = [
                    'on'  => ['value' => 1, 'text' => '显示', 'color' => 'primary'],
                    'off' => ['value' => 0, 'text' => '隐藏', 'color' => 'default'],
                ];
            $grid->status('状态')->switch($states);
            $grid->created_at();
            $grid->disableCreateButton();
            
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Evaluate::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
