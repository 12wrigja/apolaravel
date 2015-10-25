@extends('templates.crud_template')

@section('crud_form')

    <user-search-view inline-template>
        <h2>Chapter Member Search</h2>

        <p>This page allows you to browse all APO Theta Upsilon Members, both past and present. To help you find people
            faster, enter a name into the search box.</p>

        {!! Form::open(['url'=>'#','v-el'=>'searchBox']) !!}
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Search for..." v-model="query">
            <span class="input-group-btn">
                <button class="btn btn-default">Search</button>
             </span>
        </div>
        {!! Form::close() !!}

        <h3 v-show="isLoading">Loading...</h3>

        <div id="resultsArea" v-el="resultsArea" v-show="isNotLoading">
            <ul class="list-group">
                <li class="list-group-item" v-repeat="user in displayUsers">
                    <div class="row">
                        <div class="col-sm-4">
                            <img v-attr="src: user.image" alt="" class="img-thumbnail img-responsive">
                        </div>
                        <div class="col-sm-8">
                            <h1>@{{user.first_name}} @{{ user.last_name }}</h1>
                            <h4><a href="@{{ user.href }}">View Profile</a></h4>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </user-search-view>


@endsection