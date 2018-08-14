<?php

namespace App\Admin\Controllers;

use App\Models\Banner;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Extensions\Tools\ButtonTool;
use Illuminate\Http\Request;

class BannerController extends Controller
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

            $content->header('首页轮播');
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

            $content->header('首页轮播');
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

            $content->header('首页轮播');
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
        return Admin::grid(Banner::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->column('title');
            $grid->image();
            $grid->url();
            $grid->status()->display(function($status){
                return $status==1? '显示':'隐藏';
            });
            $grid->actions(function ($actions) {
              if($actions->getKey() == 1) {
                $actions->disableDelete();
              }
              if ($actions->row->status == 0 && $actions->getKey() != 1) {
                // 添加操作
                $actions->append(new ButtonTool($actions->getKey(), 1, '显示', '/admin/banner'));
              }
              if ($actions->row->status == 1 && $actions->getKey() != 1) {
                $actions->append(new ButtonTool($actions->getKey(), 0, '隐藏', '/admin/banner'));
              }
            });
             $grid->filter(function($filter){
                $filter->disableIdFilter();
                $filter->like('title', '标题');
            });
            $grid->paginate(15);
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
        return Admin::form(Banner::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->text('title', '标题');
            $form->image('image', '图片');
            $form->text('url', '链接');
            $form->switch('status', '显示？');
            $form->text('sort', '权重');
            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }

    public function operate(Banner $banner,Request $request)
    {
        $banner->status=$request->action;

        $banner->save();
        return response()->json(['message' => '更新成功！', 'status' => 1], 201);

    }
}
