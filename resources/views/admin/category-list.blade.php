@extends('admin.loyout')

@section('content')
    <main class="wrapper admin-users">
        @include("admin.nav-menu", ['title_page' => $data['title_page']])
        <div class="dashboard-wrapper">
            @include("admin.sidebar")
            <div class="profile__wrapper category-list">
                <div class="div-header2-panel-cat">
                    <a href="{{route("admin.category.create")}}" class="link-cat create-new">Add new category</a>

                    <form action="" method="get" class="form-header2-panel-cat">
                        <input name="q" type="text" value="{{($searchTerm) ? $searchTerm : ''}}">
                        <button class="link-cat" type="submit">Search</button>
                    </form>

                    <a href="{{route("admin.category.list")}}">Reset Search</a>

                    <div class="div-header2-panel-cat-import-exspot">
                        <a href="{{ route('admin.categories.download.exsel') }}" class="btn btn-export-cat link-cat">Category export</a>

                        <form action="{{ route('admin.categories.upload.exsel') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="categories_file" accept=".xlsx, .xls">
                            <button type="submit" class="btn btn-primary btn-export-cat link-cat">Import categories</button>
                        </form>
                    </div>

                </div>


                <ul>
                    @if(!empty($data['category_list']))
                        @foreach($data['category_list'] as $val)
                            <li>
                                <div>
                                    {{$val->category_name}}
                                    <a href="{{route("admin.category.edit", ['id' => $val->id])}}" class="link-cat">Edit</a>
                                </div>
                                <div>
                                    <a href="{{route("admin.category.delete", ['id' => $val->id])}}" class="link-cat">Delete</a>
                                </div>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>
    </main>
@endsection


<style>
    .div-header2-panel-cat-import-exspot {
        border-radius: 5px;
        padding: 10px 10px;
        margin: auto;
    }
    .div-header2-panel-cat-import-exspot .btn-export-cat.link-cat {
        margin-left: 0px;
        background: var(--color-2);
        padding: 5px 10px;
    }
    .div-header2-panel-cat-import-exspot form{
        margin-top: 15px;
        border: 1px dotted var(--color-first);
        border-radius: 5px;
        padding: 10px 10px;
    }
    .div-header2-panel-cat-import-exspot form button{
        margin-top: 10px;
    }

    .div-header2-panel-cat  a.link-cat.create-new{
        padding: 12px 10px;
        background: var(--color-2);
    }
    .form-header2-panel-cat button{
        margin-left: 20px !important;
        background: var(--color-2);
    }
    .form-header2-panel-cat{
        display: flex;
        align-items: center;
        align-content: center;
        margin: 0px 20px;
    }
    .div-header2-panel-cat {
        display: flex;
        flex-direction: row;
        align-content: center;
        align-items: center;
    }
    .category-list li{
        display: flex;
        justify-content: space-between;
        border: 1px solid var(--color-first);
        border-radius: 5px;
        padding: 10px 10px;
        margin: 10px 0px;
    }

    .category-list ul{
        margin-top: 25px;
    }

    .category-list .link-cat{
        border: 1px solid var(--color-first);
        border-radius: 5px;
        padding: 2px 10px;
        margin-left: 20px;
    }

    .link-cat.create-new{
        margin-left: 0px;
    }
</style>
