@extends('admin.loyout')

@section('content')
    <main class="wrapper admin-users">
        @include("admin.nav-menu", ['title_page' => $data['title_page']])
        <div class="dashboard-wrapper">
            @include("admin.sidebar")
            <div class="profile__wrapper category-list">
                <?php
                $url_form = route("admin.category.create");
                if(!empty($data['type']) && $data['type'] == 'edit'){
                    $url_form = route("admin.category.save", ['id' => $data['category']->id]);
                }
                ?>
                <form action="{{$url_form}}" method="POST">
                    @csrf
                    <input name="category_name" placeholder="Category name" value="{{!empty($data['category']->category_name) ? $data['category']->category_name : ''}}">
                    <button type="submit">Save</button>
                </form>
            </div>
        </div>
    </main>
@endsection



