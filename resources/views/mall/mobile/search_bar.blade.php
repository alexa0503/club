            <div class="search_bar">
                <form class="" method="GET" enctype="application/x-www-form-urlencoded" action="/mall/search">
                    <div class="row">
                    <div class="col-xs-4">
                        <input name="keywords" style="max-width:100px" class="input-sm" placeholder="输入关键词" value="{{ Request::input('keywords') }}">
                    </div>
                    <div class="col-xs-8">
                    &nbsp;&nbsp;风迷币：
                        <input name="point_min" style="max-width:40px" class=" input-sm" placeholder="" value="{{ Request::input('point_min') }}">
                        -
                        <input name="point_max" style="max-width:40px" class="input-sm" placeholder="" value="{{ Request::input('point_max') }}">
                    </div>
                    </div>
                    <div class="row" style="margin-top:10px;">
                    <div class="col-xs-8">
                        <select class="input-sm" name="order_name">
                            <option value="created_at" {{ Request::input('order_name') == 'created_at' ? 'selected="selected"' : '' }}>按时间</option>
                            <option value="point" {{ Request::input('order_name') == 'point' ? 'selected="selected"' : '' }}>按风迷币</option>
                        </select>
                        <select class="input-sm" name="order_type">
                            <option value="ASC" {{ Request::input('order_type') == 'ASC' ? 'selected="selected"' : '' }}>递增</option>
                            <option value="DESC" {{ Request::input('order_type') == 'DESC' ? 'selected="selected"' : '' }}>递减</option>
                        </select>
                    </div>
                    <div class="col-xs-4">
                        <input type="hidden" name="cat_id" value="{{ Request::input('cat_id') }}" />
                        <button class="btn btn-sm">查询</button>
                    </div>
                    </div>
                    
                </form>
            </div>