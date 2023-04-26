@extends('admin.loyout')

@section('content')
    <main class="wrapper admin-users settings-page">
        @include("admin.nav-menu", ['title_page' => $data['title_page']])
        <div class="dashboard-wrapper">
            @include("admin.sidebar")
            <div class="profile__wrapper category-list">
                <form action="{{route("admin.settingsPageSave")}}" method="POST">
                    @csrf
                    <div class="col row-field">
                        <div class="form_input_wrap">
                            <input type="number" id="count_posts" name="count_posts" min="1" required value="{{$data['setting']['count_posts']}}">
                            <label for="count_posts">Allowed project post quantity</label>
                        </div>
                    </div>

                    <div class="form-profile__bottom">
                        <button type="submit" class="btn btn--solid btn--arrow send send-form">Save</button>
                    </div>
                </form>
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

    .settings-page .form-profile__bottom{
        margin-top: 15px;
    }
</style>
