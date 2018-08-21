<?php

namespace App\Api\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Dingo\Api\Routing\Helpers;
use App\Models\User;
use App\Models\Address;
use App\Transformers\UserTransformer;
use App\Http\Requests\AddressStoreRequest;

class UserController extends Controller
{
    use Helpers;

    public function __construct()
    {
    	$this->middleware(['token']);
    }

    public function login(Request $request)
    {	
    	//dd($request->userinfo);
    	$userInfo=$request->userinfo;
    	$user=User::find($request->uid);
    	$user->nickname=$userInfo['nickName'];
    	$user->avatar=$userInfo['avatarUrl'];
    	$user->gender=$userInfo['gender'];
    	$user->save();
    	return $this->response->item($user,new UserTransformer)->setStatusCode(201);
    }

    public function coupon(Request $request,$id)
    {
        $user=User::where('id',$id)->first();
        $coupons= $user->coupons->where('status',$request->status);
        //dd($coupons->all());
        $data['coupons']=$coupons->all();
        $data['code']=201;
        return $this->response->array($data);
    }

    public function addresses(Request $request)
    {
        $user = auth('api')->user();
        if ($request->status==1) {
            $data['addresses']=$user->addresses->where('status',1)->flatten()->all();
        }else{
            $data['addresses']=$user->addresses;
        }
        
        $data['code']=201;
        return $this->response->array($data);
    }

    public function setDefaultAddress(Request $request)
    {
        \DB::transaction(function () use ($request) {
            $user = auth('api')->user()->addresses()->update(['status'=>0]);
            Address::where('id',$request->id)->update(['status'=>1]);
        });
        

    }

    public function addressStore(AddressStoreRequest $request)
    {
        $data=$request->all();
        $rData['code']=201;

         if ($request->isMethod('POST')) {
             $addressData=collect($data)->except('id')->all();
             $addressData['user_id']=auth('api')->user()->id;
             \DB::transaction(function () use($addressData,$rData) {
                auth('api')->user()->addresses()->update(['status'=>0]);
                if (!Address::create($addressData)) {
                     $rData['msg']='新增地址失败！';
                     $rData['code']=401;
                }

             });

         }else{

        \DB::transaction(function () use($data,$rData,$request) {
            $addressModel=Address::find($request->id);
            auth('api')->user()->addresses()->update(['status'=>0]);
            if (!$addressModel->update($data)) {
                     $rData['msg']='修改地址失败！';
                     $rData['code']=401;
            }
         });

         }
         return $this->response->array($rData);
    }

    public function addressDetails(Request $request)
    {
        $data['data']=Address::find($request->id);
        $data['code']=201;
        return $this->response->array($data);
    }

    public function addressDestroy(Request $request)
    {
        $address=Address::find($request->id);
        $address->delete();
    }


}
