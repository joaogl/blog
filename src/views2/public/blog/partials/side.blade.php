
<!-- Blog Search Well -->
<!--<div class="well">
    <h4>Blog Search</h4>
    <div class="input-group bloodhound bs-example">
        <input type="text" class="form-control typeahead tt-query" placeholder="Search in blog">
        <span class="input-group-btn">
            <button class="btn btn-default" type="button">
                <span class="glyphicon glyphicon-search"></span>
            </button>
        </span>
    </div>
</div>-->

<!-- Blog Categories Well -->
<div class="well">
    <h4>Blog Categories</h4>
    <div class="row">
        <div class="col-lg-6">
            <ul class="list-unstyled">

                @if (sizeof(array_chunk($categories->toArray(), (sizeof($categories->toArray()) / 2) + 1,  true)) > 0)

                    @foreach(array_chunk($categories->toArray(), (sizeof($categories->toArray()) / 2) + 1,  true)[0] as $item)
                        <li>
                            <a href="{{ url('category/' . $item['id']) }}">{{ $item['name'] }}</a>
                        </li>
                    @endforeach

                @endif

            </ul>
        </div>
        <!-- /.col-lg-6 -->
        <div class="col-lg-6">
            <ul class="list-unstyled">

                @if (sizeof(array_chunk($categories->toArray(), (sizeof($categories->toArray()) / 2) + 1,  true)) > 1)

                    @foreach(array_chunk($categories->toArray(), (sizeof($categories->toArray()) / 2) + 1,  true)[1] as $item)
                        <li>
                            <a href="{{ url('category/'. $item['id']) }}">{{ $item['name'] }}</a>
                        </li>
                    @endforeach

                @endif

            </ul>
        </div>
        <!-- /.col-lg-6 -->
    </div>
    <!-- /.row -->
</div>