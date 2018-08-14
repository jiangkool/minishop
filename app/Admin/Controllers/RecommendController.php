<?php

namespace App\Admin\Controllers;

use App\Models\Recommend;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class RecommendController extends Controller
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

            $content->header('header');
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
        return Admin::grid(Recommend::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->user_id('会员id');
            $grid->parent_id('上级ID');
            $grid->recommend_num('推荐会员人数');
            $grid->visit_num('引导游客人数');
            $grid->qr_code('二维码');
            $grid->created_at();
            $grid->updated_at();
            $grid->disableCreateButton();
            $grid->actions(function($actions){
                $actions->disableEditButton();
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
        return Admin::form(Recommend::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
