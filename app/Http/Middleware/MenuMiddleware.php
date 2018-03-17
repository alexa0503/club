<?php

namespace App\Http\Middleware;

use Closure;
use Menu;
use Auth;

class MenuMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $admin = Auth::guard('admin')->user();
        Menu::make('menu', function ($menu)use($admin) {
            $blocks = config('custom.blocks');

            $menu->add('论坛管理', ['url'=>url('/bbs/admin.php'),'class'=>'bg-palette1']);

            //页面管理
            if($admin->hasPermissionTo('页面管理') && $admin->hasAnyRole(['管理员'])){
                $menu1 = $menu->add('首页管理', ['url'=>route('page.block.index',['page'=>1]),'class'=>'openable bg-palette2']);
                foreach($blocks[1] as $key=>$value){
                    $menu1->add($value, ['url'=>route('page.block.index',['page'=>1,'name'=>$key]),'class'=>'bg-palette2']);
                }
                $menu1->add('新增', ['url'=>route('page.block.create',['page'=>1]),'class'=>'bg-palette2']);


                $menu2 = $menu->add('商场首页', ['url'=>route('page.block.index',['page'=>2]),'class'=>'openable bg-palette3']);
                foreach($blocks[2] as $key=>$value){
                    $menu2->add($value, ['url'=>route('page.block.index',['page'=>2,'name'=>$key]),'class'=>'bg-palette3']);
                }
                $menu2->add('新增', ['url'=>route('page.block.create',['page'=>2]),'class'=>'bg-palette2']);
            }
            //产品管理
            if($admin->hasPermissionTo('产品管理')){
                $menu2 = $menu->add('产品管理', ['url'=>route('item.index'),'class'=>'openable bg-palette3']);
                $menu2->add('查看', ['url'=>route('item.index'),'class'=>'bg-palette3']);
                $menu2->add('新增', ['url'=>route('item.create'),'class'=>'bg-palette3']);
            }
            //订单管理
            if($admin->hasPermissionTo('订单管理')){
                $menu->add('订单管理', ['url'=>route('order.index'),'class'=>'bg-palette4']);
            }
            //认证记录
            if($admin->hasPermissionTo('认证记录') && $admin->hasAnyRole(['管理员'])){
                $menu->add('认证记录', ['url'=>route('verify.index'),'class'=>'bg-palette5']);
                $menu->add('推荐购车', ['url'=>route('reference.index'),'class'=>'bg-palette6']);
            }
            //会员积分
            if($admin->hasPermissionTo('会员积分') && $admin->hasAnyRole(['管理员'])){
                $menu3 = $menu->add('会员积分', ['url'=>route('credit.index'),'class'=>'openable bg-palette7']);
                $menu3->add('查看', ['url'=>route('credit.index'),'class'=>'bg-palette3']);
                $menu3->add('新增', ['url'=>route('credit.create'),'class'=>'bg-palette3']);
                $menu3->add('dms数据', ['url'=>route('credit.dms'),'class'=>'bg-palette3']);
            }
            //粉丝数据
            if($admin->hasPermissionTo('粉丝数据') && $admin->hasAnyRole(['管理员'])){
                /*************************2017-11-17  添加数据导出模块*************************/
                $menu->add('粉丝数据', ['url'=>route('members.index'),'class'=>'bg-palette7']);
                /*************************2017-11-17  添加数据导出模块*************************/
            }

            //供应商管理
            if($admin->hasPermissionTo('权限管理') && $admin->hasAnyRole(['管理员'])){
                $permission = $menu->add('权限管理', ['url'=>route('permission.index'),'class'=>'openable bg-palette7']);
                $permission->add('查看', ['url'=>route('permission.index'),'class'=>'bg-palette7']);
                $permission->add('新增', ['url'=>route('permission.create'),'class'=>'bg-palette7']);
            }

            //供应商管理
            if($admin->hasPermissionTo('供应商管理') && $admin->hasAnyRole(['管理员'])){
                $dealer = $menu->add('供应商管理', ['url'=>route('dealer.index'),'class'=>'openable bg-palette8']);
                $dealer->add('查看', ['url'=>route('dealer.index'),'class'=>'bg-palette8']);
                $dealer->add('新增', ['url'=>route('dealer.create'),'class'=>'bg-palette8']);
            }            
           
        });
        return $next($request);
    }
}
