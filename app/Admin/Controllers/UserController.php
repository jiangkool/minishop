<?php

namespace App\Admin\Controllers;

use App\Models\User;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Illuminate\Http\Request;
use App\Admin\Extensions\Tools\ApplyTool;

class UserController extends Controller
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

            $content->header('会员管理');
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

            $content->header('会员管理');
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

            $content->header('会员管理');
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
        return Admin::grid(User::class, function (Grid $grid) {

            $grid->id('ID')->sortable();

            $grid->column('name','帐号');
            $grid->column('email','邮件');
            $grid->column('nickname','昵称');
            $grid->column('gender','性别')->display(function($gender){
                return $gender==1?'男':'女';
            });
            $grid->column('avatar','头像')->image('',100,100);

             $grid->column('用户信息')->display(function(){
              return "<table class='table' style='width:300px;'>"
              ."<tr><th>总计消费</th><td>". $this->spend_total ."</td></tr>"
              ."<tr><th>当月消费</th><td>". $this->spend_current ."</td></tr>"
              ."<tr><th>总计收入</th><td>". $this->earn_total ."</td></tr>"
              ."<tr><th>当前余额</th><td>". $this->balance ."</td></tr>"
              ."<tr><th>当前M币</th><td>". $this->m_current ."</td></tr>"
              ."</table>";
            
            });
            $grid->column('status','用户身份')->display(function($status){
                return $status == 1 ? '<i class="label label-success">会员</i>' : '<i class="label label-default">游客</i>';
            });
            $grid->column('联系方式')->display(function(){
                return "<table class='table' style='width:300px;'>"
              ."<tr><th>手机号</th><td>". $this->phone ."</td></tr>"
              ."<tr><th>省份</th><td>". $this->areas ."</td></tr>"
              ."<tr><th>地址</th><td>". $this->address ."</td></tr>"
              ."</table>";
            });
            $grid->filter(function($filter){
                $filter->disableIdFilter();
                $filter->like('name','帐号');
            });
            $grid->disableCreateButton();
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
        return Admin::form(User::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->text('name','帐号');
            $form->text('email','邮件');
            $form->mobile('phone','电话')->options(['mask' => '999 9999 9999']);
            $form->radio('gender','性别')->options([0=>'女',1=>'男'])->default(0);
            $form->image('avatar','头像');

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
