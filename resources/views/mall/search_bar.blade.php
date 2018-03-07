            <div class="search_bar">
                <form class="form-inline form-search" method="GET" enctype="application/x-www-form-urlencoded" action="/mall/search">
                    <div class="form-group">
                        <input name="keywords" class="form-control" placeholder="输入关键词" value="{{ Request::input('keywords') }}">
                    </div>
                    <div class="form-group">
                        <label for="">风迷币:</label>
                        <input name="point_min" style="max-width:60px" class="form-control" placeholder="" value="{{ Request::input('point_min') }}">
                        -
                        <input name="point_max" style="max-width:60px" class="form-control" placeholder="" value="{{ Request::input('point_max') }}">
                    </div>
                    <div class="form-group">
                        <select class="form-control" name="cat_id">
                            <option value="">选择分类/所有</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}"  {{ Request::input('cat_id') == $category->id ? 'selected="selected"' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <select class="form-control" name="order_name">
                            <option value="created_at" {{ Request::input('order_name') == 'created_at' ? 'selected="selected"' : '' }}>按时间</option>
                            <option value="name" {{ Request::input('order_name') == 'name' ? 'selected="selected"' : '' }}>按名称</option>
                            <option value="price" {{ Request::input('order_name') == 'price' ? 'selected="selected"' : '' }}>按价格</option>
                        </select>
                        <select class="form-control" name="order_type">
                            <option value="ASC" {{ Request::input('order_type') == 'ASC' ? 'selected="selected"' : '' }}>递增</option>
                            <option value="DESC" {{ Request::input('order_type') == 'DESC' ? 'selected="selected"' : '' }}>递减</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-sm">查询</button>
                    </div>
                </form>
            </div>