<?php

namespace App\Admin\Controllers;

use App\Models\Category;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Extensions\Tools\ButtonTool;
use Encore\Admin\Widgets\Box;
use Encore\Admin\Layout\Row;
use Encore\Admin\Layout\Column;
use Encore\Admin\Auth\Database\Role;
use Encore\Admin\Tree;

class CategoryController extends Controller
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

            $content->header('分类管理');
            $content->description('列表');
            $content->row(function (Row $row) {
                $row->column(6, Category::tree(function ($tree) {
                      $tree->branch(function ($branch) {
                          $src = config('app.url'). '/uploads/' . $branch['icon'] ;
                          $logo = "<img src='$src' style='max-width:30px;max-height:30px' class='img'/>";
                          return "$logo {$branch['id']} - {$branch['title']}  ";
                      });
                    })->render());

                $row->column(6,function (Column $column) {
                    $form = new \Encore\Admin\Widgets\Form();
                    $form->action(admin_base_path('category'));

                    $form->select('parent_id', trans('admin.parent_id'))->options(Category::buildSelectOptions($nodes = [], $parentId = 0, $prefix = ''));
                    $form->text('title', trans('admin.title'))->rules('required');
                    $form->image('icon', trans('admin.icon'));
                    $form->hidden('_token')->default(csrf_token());
                    $form->number('sort', '排序')->default(0);
                    $column->append((new Box(trans('admin.new'), $form))->style('success'));
                });

            });

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

            $content->header('分类管理');
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

            $content->header('分类管理');
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
        return Admin::grid(Category::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
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
        return Admin::form(Category::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->select('parent_id', trans('admin.parent_id'))->options(Category::buildSelectOptions($nodes = [], $parentId = 0, $prefix = ''));
            $form->text('title','类目名称');
            $form->image('icon','类目图标');
            $form->number('sort', '排序')->default(0);
            $states=[
                'on'  => ['value' => 1, 'text' => '启用', 'color' => 'success'],
                'off' => ['value' => 0, 'text' => '禁用', 'color' => 'danger'],
            ];
            $form->switch('status')->states($states)->default(1);
            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }



}
