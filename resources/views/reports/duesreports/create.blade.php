@extends('templates.crud_template')


@section('crud_form')

    <h1 class="page-header">Manage Dues</h1>

    <p>This is the tool you can use to manage who has payed their dues.</p>

    <p>First, use the search bar to search for a brother. Once you select them, they will be added to the table below,
        and you will be able to either mark them as paying full dues, or a custom amount of their dues.</p>

    <p>If you ever need to edit the amount that someone has payed, simply add them into a report and change the amount -
        the amount reflected on the website is the most recent amount reported.</p>

    <create_dues_report_form inline-template>
        {!! Form::open(['route'=>['report_store','type'=>'dues_reports'],'class'=>'collapse in','v-el'=>'iform'])
        !!}

        <div class="form-horizontal">
            <h2>Brothers</h2>

            <p class="help-block"></p>
            <td><select id="brotherselecter" placeholder="Search for a Brother..." class="form-control"></select></td>
            <!-- Brothers listing -->
            <table class="table table-hover">
                <thead>
                <th class="col-md-3">Brother</th>
                <th class="col-md-2"></th>
                <th class="col-md-5"></th>
                <th class="col-md-2"></th>
                </thead>
                <tbody>
                <tr v-repeat="brother: form.brothers">
                    <td>@{{ brother.name }}</td>
                    <td>
                        <div>
                            {!! Form::select('type', ['full'=>'Full','other'=>'Other'], 'full' ,['class'=>'form-control','v-model'=>'brother.type']) !!}
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            {!! Form::text('brothers.@{{$index}}.value', null, ['class'=>'form-control','v-model'=>'brother.value','v-show'=>'brother.type =="other"']) !!}
                            <p class="help-block"></p>
                        </div>
                    </td>
                    <td>
                        <div class="btn btn-danger" v-on="click: removeBrother(brother)">Remove</div>
                    </td>
                </tr>
                </tbody>
            </table>

            <br>
            <br>

            <div class="form-group">
                {!! Form::submit('Update Dues', ['class'=>'btn btn-primary form-control']) !!}
            </div>
        </div>
        {!! Form::close() !!}

        <div class="alert alert-info alert-important collapse" role="alert" v-el="loadingArea">
            <h3 class="text-center">Updating...</h3>

            <div class="progress">
                <div class="progress-bar  progress-bar-striped active" role="progressbar" aria-valuenow="100"
                     aria-valuemin="0" aria-valuemax="100" style="width:100%"></div>
            </div>
        </div>
        <div class="alert alert-success alert-important collapse" role="alert" v-el="successArea">
            <h3 class="text-center">Dues Updated!</h3>

            <div class="text-center">
                <a class="btn btn-success" href="{{route('home')}}">Return to home</a>
            </div>
        </div>
    </create_dues_report_form>

@endsection