<?php

namespace App\Http\Middleware;

use Closure;
use Menu;

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
        Menu::make('menu', function ($menu) {
            $menu->add('论坛管理', ['url'=>url('/bbs/admin.php'),'class'=>'bg-palette1']);
            $menu1 = $menu->add('首页管理', ['url'=>route('page.block.index',['page'=>1]),'class'=>'openable bg-palette2']);
            $menu1->add('查看', ['url'=>route('page.block.index',['page'=>1]),'class'=>'bg-palette2']);
            $menu1->add('新增', ['url'=>route('page.block.create',['page'=>1]),'class'=>'bg-palette2']);

            $menu2 = $menu->add('商场首页', ['url'=>route('page.block.index',['page'=>2]),'class'=>'openable bg-palette2']);
            $menu2->add('查看', ['url'=>route('page.block.index',['page'=>2]),'class'=>'bg-palette2']);
            $menu2->add('新增', ['url'=>route('page.block.create',['page'=>2]),'class'=>'bg-palette2']);

            $menu2 = $menu->add('产品管理', ['url'=>route('item.index'),'class'=>'openable bg-palette3']);
            $menu2->add('查看', ['url'=>route('item.index'),'class'=>'bg-palette3']);
            $menu2->add('新增', ['url'=>route('item.create'),'class'=>'bg-palette3']);
        });
        return $next($request);
    }
}
