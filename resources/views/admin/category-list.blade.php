@extends('admin.loyout')

@section('content')
    <main class="wrapper admin-users">
        @include("admin.nav-menu", ['title_page' => $data['title_page']])
        <div class="dashboard-wrapper">
            @include("admin.sidebar")
            <div class="profile__wrapper category-list">
                <a href="{{route("admin.category.create")}}" class="link-cat create-new">Add new category</a>
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
