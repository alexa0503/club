<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\BlockPost;
use DB;

class BlockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($page)
    {
        $rows = \App\Block::where('page_id',$page)->orderBy('name','DESC')->orderBy('sort_id','ASC')->paginate(20);

        return view('admin/block/index', [
            'rows' => $rows,
            'blocks' => config('custom.blocks'),
            'page' => \App\Page::find($page),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($page)
    {
        return view('admin/block/create', [
            'blocks' => config('custom.blocks'),
            'page' => \App\Page::find($page),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BlockPost $request, $page)
    {
        $block = new \App\Block;

        DB::beginTransaction();
        try{
            $block->page_id = $page;
            $block->name = $request->input('name');
            $block->title = $request->input('title');
            $block->content = $request->input('content') ? : '';
            $block->description = $request->input('description');
            $block->is_posted = $request->input('is_posted');
            $block->sort_id = $request->input('sort_id') ?: 0;
            $block->header_image = $request->input('header_image');
            $block->bkg_image = $request->input('bkg_image');
            $block->gallery = $request->input('gallery');
            $block->link = $request->input('link');
            $block->save();
            DB::commit();

        }catch (Exception $e){
            DB::rollBack();
            return response(['gallery[]' => $e->getMessage()], 422);
        }
        return response([]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($page,$id)
    {
        $row = \App\Block::find($id);
        return view('admin/block/edit', [
            'row' => $row,
            'blocks' => config('custom.blocks'),
            'page' => \App\Page::find($page),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BlockPost $request, $page, $id)
    {
        $block = \App\Block::find($id);

        DB::beginTransaction();
        try{
            $block->title = $request->input('title');
            $block->content = $request->input('content') ? : '';
            $block->description = $request->input('description');
            $block->is_posted = $request->input('is_posted');
            $block->sort_id = $request->input('sort_id') ?: 0;
            $block->header_image = $request->input('header_image');
            $block->bkg_image = $request->input('bkg_image');
            $block->gallery = $request->input('gallery');
            $block->link = $request->input('link');
            $block->save();
            DB::commit();

        }catch (\Exception $e){
            DB::rollBack();
            return response(['gallery[]' => $e->getMessage()], 422);
        }
        return response([]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($page, $id)
    {
        \App\Block::destroy($id);
        return response(['ret'=>0]);
    }

    public function imageDelete()
    {
        return response([]);
    }
}
