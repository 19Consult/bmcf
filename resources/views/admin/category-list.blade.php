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
