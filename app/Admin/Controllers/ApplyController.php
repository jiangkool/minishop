<?php

namespace App\Admin\Controllers;

use App\Models\Apply;
use App\Models\User;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Extensions\Tools\ApplyTool;
use Illuminate\Http\Request;

class ApplyController extends Controller
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

            $content->header('申请管理');
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

            $content->header('编辑');
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

            $content->header('新增');
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
        return Admin::grid(Apply::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->parent_id('上级推荐人')->display(function($parent_id){
                $user=User::find($parent_id);
                return $user->name;
            });
            $grid->username('申请人');
            $grid->phone('电话');
            $grid->wechat('微信号');
            $grid->areas('省市区');
            $grid->details('详细地址');
            $grid->status('状态')->display(function($status){
                //申请状态 0=待审核，1=通过，2=拒绝
                switch ($status) {
                    case 1:
                        return '<span class="label label-success">通过</span>';
                        break;
                    case 2:
                        return '<span class="label label-default">拒绝</span>';
                        break;
                    default:
                        return '<span class="label label-default">待审核</span>';
                        break;
                }
            });
            $grid->actions(function($actions){
                if ($actions->row->status==2) {
                    $actions->append(new ApplyTool($actions->getKey(),1));
                }else if($actions->row->status==1){
                    $actions->append(new ApplyTool($actions->getKey(),2));
                }else{
                    $actions->append(new ApplyTool($actions->getKey(),0));
                }
                
            });
            $grid->created_at();
            //$grid->updated_at();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Apply::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->text('username','申请人');
            $form->mobile('phone','电话');
            $form->text('wechat','微信号');
            $form->text('areas','省市区');
            $form->text('details','详细地址');
            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }

    public function operate(Request $request,Apply $apply)
    {
        $apply->status=$request->action;
        $apply->save();
        return response()->json(['status'=>1,'message'=>'操作成功！'],201);
    }
}
