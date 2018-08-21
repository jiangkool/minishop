<?php

namespace App\Api\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Dingo\Api\Routing\Helpers;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductItem;
use App\Models\Coupon;
use App\Http\Requests\OrderStoreRequest;
use Pay;

class OrderController extends Controller
{
    use Helpers;

    public function __construct(){
    	$this->middleware(['token']);
    }

    public function index(OrderStoreRequest $request)
    {
        $total=0;
        $items=json_decode($request->goodsJsonStr,true);
        foreach ($items as $item) {
            $pitem=ProductItem::where('id',$item['propertyChildId'])->first();
            $total+=($pitem->unit_price)*($item['number']);
        }
        $data['amountTotle']=$total;
        if ($request->calculate) {
            return $this->response->array($data);
        }else{
            $rorder_data['user_id']=auth('api')->user()->id;
            $rorder_data['consignee']=isset($request->consignee)?$request->consignee:auth('api')->user()->name;
            $rorder_data['phone']=$request->phone;
            $rorder_data['address']=$request->province_str.$request->city_str.($request->district_str?:'').$request->address;
            $rorder_data['tradetotal']=$total;
            $rorder_data['preferentialtotal']=isset($request->couponId)?Coupon::find($request->couponId)->par_value:0;
            $rorder_data['total']=$total-$rorder_data['preferentialtotal'];
            $rorder_data['out_trade_no']=date('Ymd',time()).time().mt_rand(0,10);
            $order=Order::create($rorder_data);

            $orderItem['order_id']=$order->id;
            $orderItem['user_id']=$rorder_data['user_id'];
            foreach ($items as $item) {
                
                \DB::transaction(function () use ($item,$orderItem) {
                    $good=Product::find($item['goodsId']);
                    $pitem=ProductItem::where('id',$item['propertyChildId'])->lockForUpdate()->first();
                    $images=$good->images;
                    $orderItem['pic']=env('APP_UPLOAD_URL').$images['0'];
                    $orderItem['product_id']=$item['goodsId'];
                    $orderItem['title']=$good->title;
                    $orderItem['norm']=$pitem->norm;
                    $orderItem['num']=$item['number'];
                    $orderItem['pre_price']=$pitem->unit_price;
                    $orderItem['total_price']=($pitem->unit_price)*($item['number']);
                    OrderItem::create($orderItem);
                    $pitem->decrement('quantity',$item['number']);
                });
                
            }

        }
        

    }

    public function orderStatus()
    {
    	//count_id_no_pay count_id_no_transfer count_id_no_confirm count_id_no_reputation count_id_success
        //订单状态 0=待付,1=待发货,2=待收获,3=待评价,4=已完成
       $user_id=auth('api')->user()->id;
       $data['count_id_no_pay']=Order::where('user_id',$user_id)->where('status',0)->count();
       $data['count_id_no_transfer']=Order::where('user_id',$user_id)->where('status',1)->count();
       $data['count_id_no_confirm']=Order::where('user_id',$user_id)->where('status',2)->count();
       $data['count_id_no_reputation']=Order::where('user_id',$user_id)->where('status',3)->count();
       $data['count_id_success']=Order::where('user_id',$user_id)->where('status',4)->count();
       $data['code']=201;
       return $this->response->array($data);

    }

    public function list(Request $request)
    {
        $status=$request->status;
        $user_id=auth('api')->user()->id;
        $data['orderList']=Order::where('user_id',$user_id)->where('status',$status)->with('orderItems')->orderBy('created_at','desc')->get();
        $data['code']=201;
        return $this->response->array($data);

    }

    public function destory(Request $request)
    {
        $order=Order::find($request->orderId);
        $order->delete();
        $data['code']=201;
        return  $this->response->array($data);
    }

    public function pay(Request $request)
    {
        $data=$request->all();
        $orderItem=Order::find($data['nextAction']['id']);
        $order = [
            'out_trade_no' => $orderItem->out_trade_no,
            'body' => $data['remark'],
            'total_fee'      => $orderItem->total,
            'openid' => 'onkVf1FjWS5SBIixxxxxxxxx',
        ];

        $result = Pay::wechat()->mp($order);

        return $result;
    }

}
