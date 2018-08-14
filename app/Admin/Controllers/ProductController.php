<?php

namespace App\Admin\Controllers;

use App\Models\Product;
use App\Models\Category;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Extensions\Tools\ButtonTool;
use Illuminate\Http\Request;

class ProductController extends Controller
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

            $content->header('商品管理');
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

            $content->header('商品管理');
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

            $content->header('商品管理');
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
        return Admin::grid(Product::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->category_id('所属分类')->display(function($category_id){
                $cate=Category::find($category_id);
                return $cate->title;
            });
            $grid->column('title','名称');
            $grid->images('图片')->map(function ($path) {
                    return config('app.url').'/uploads/'. $path;
                })->image('',50,50);

            $grid->pre_price('原价');  
            $grid->diff_price('差价');
            $grid->share_price('分享赚');
            $grid->sale_num('销量');
            $grid->column('库存')->display(function(){
                return $this->product_items->sum('quantity');
            });
            //0=普通商品,1=今日推荐,2=独家定制,3=限时秒杀,4=M币专区
            $grid->type('商品类型')->display(function($type){
                switch ($type) {
                    case 0:
                        return '<span class="label label-info">普通商品</span>';
                        break;
                    case 1:
                        return '<span class="label label-info">今日推荐</span>';
                        break;
                    case 2:
                        return '<span class="label label-info">独家定制</span>';
                        break;
                    case 3:
                        return '<span class="label label-info">限时秒杀</span>';
                        break;
                    case 4:
                        return '<span class="label label-info">M币专区</span>';
                        break;
                    default:
                        return '<span class="label label-info">普通商品</span>';
                        break;
                }
            });

            $grid->status('状态')->display(function($a){
                return $a==1?'<span class="label label-success">在售</span>':'<span class="label label-default">下架</span>';
            });

            //状态 0=下架,1=在售
            $grid->actions(function($actions){
                if ($actions->row->status==1) {
                    $actions->append(new ButtonTool($actions->getKey(),'0','下架','/admin/product'));
                }else{
                     $actions->append(new ButtonTool($actions->getKey(),'1','上架','/admin/product'));
                }

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
        return Admin::form(Product::class, function (Form $form) {

            $form->tab('基本信息',function($form){
               // $form->display('id', 'ID');
                $form->select('category_id', '所属分类')->options(Category::buildSelectOptions($nodes = [], $parentId = 0, $prefix = ''));
                $form->text('title','名称');
                $form->multipleImage('images','产品图片')->removable();
                $form->currency('diff_price','差价')->symbol('￥');
                $form->currency('share_price','分享赚')->symbol('￥');

            })->tab('产品描述',function($form){
                $options=[
                    0=>'普通商品',
                    1=>'今日推荐',
                    2=>'独家定制',
                    3=>'限时秒杀',
                    4=>'M币专区',
                ];
                $form->select('type','产品所属活动')->options($options);
                $form->switch('status','上架？')->states(['1'=>'上架','0'=>'下架']);
                $form->textarea('description','描述');

            })->tab('规格参数', function ($form) {

               $form->hasMany('product_items', '', function(Form\NestedForm $form) {
                   $form->text('norm', '规格')->setWidth(2, 2);
                   $form->currency('unit_price','单价')->symbol('￥');
                   $form->number('quantity', '库存')->rules('regex:/^[0-9]*$/', [
                       'regex' => '库存必须为正整数',
                   ])->default(0);
                   $form->switch('status','上架？')->states(['1'=>'上架','0'=>'下架']);
                   $form->divide();
               });

            })->tab('产品详情',function($form){
                $form->editor('content','内容');

            });

            $form->saved(function(Form $form){
                $product=Product::find($form->model()->id);
                $items=$product->product_items;
                $product->pre_price=count($items)>0 ? collect($items)->min('unit_price'):0;
                $product->save();
            });

   
        });
    }

    public function operate(Product $product,Request $request)
    {
        $product->status=$request->action;
        $product->save();
        return response()->json(['message' => '更新成功！', 'status' => 1], 200);

    }
}
