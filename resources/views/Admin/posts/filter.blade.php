<div class="card-body">
    <form action="{{ route('admin.posts.index') }}">
        <div class="row">
            <div class="col-2">

                <div class="form-group">
                    <select name="sort_by" class="form-control">

                        <option selected disabled value="">Sort By</option>
                        <option value="id">id</option>
                        <option value="name">Name</option>
                        <option value="created_at">Create_At</option>
                    </select>
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <select name="order_by" class="form-control">
                        <option selected disabled value="">Order By</option>

                        <option value="asc">Ascending</option>
                        <option value="desc">Descending</option>
                    </select>
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <select name="status" class="form-control">
                        <option selected disabled value="">Status</option>

                        <option value="1">Active</option>
                        <option value="0">Not Active</option>
                    </select>
                </div>
            </div>
            <div class="col-1">
                <div class="form-group">
                    <select name="limit_by" class="form-control">
                        <option selected disabled value="">Limit</option>
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="40">40</option>
                    </select>
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <input class="form-control" name="keyword" placeholder="Search Here.....">
                </div>
            </div>
            <div class="col-1">
                <div class="form-group">
                    <button type="submit" class="btn btn-info">Search</button>
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-category">
                        Create Category
                    </button>
                </div>
            </div>
        </div>
    </form>
    <!-- Button trigger modal -->

</div>