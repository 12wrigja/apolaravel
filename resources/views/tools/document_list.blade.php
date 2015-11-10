@extends('templates.crud_template')

@section('crud_form')
    <h1>Document Center</h1>
    <p>Below is a list of documents used by APO TY. If there are any documents available for specific membership
        positions, those will be grouped by position below as well.</p>

    @if(count($files['public']) > 0)
        <h3>Public Files</h3>
        <table class="table">
            <thead>
            <th class="col-md-6">File Name</th>
            <th class="col-md-6 text-right">Download</th>
            </thead>
            @foreach($files['public'] as $file)
                <tr>
                    <td>
                        {{$file['filename']}}
                    </td>
                    <td class="text-right">
                        <a href="{{route('retrieve_document',['filename'=>$file['fullpath']])}}"
                           class="btn btn-primary">Download</a>
                    </td>
                </tr>
            @endforeach
        </table>
    @endif

    @if(array_key_exists('members',$files) && count($files['members']) > 0)
        <h3>Member Files</h3>
        <table class="table">
            <thead>
            <th class="col-md-6">File Name</th>
            <th class="col-md-6 text-right">Download</th>
            </thead>
            @foreach($files['members'] as $file)
                <tr>
                    <td>{{$file['filename']}}</td>
                    <td class="text-right"><a href="{{route('retrieve_document',['filename'=>$file['fullpath']])}}"
                           class="btn btn-primary">Download</a></td>
                </tr>
            @endforeach
        </table>
    @endif

    @if(count($files) > 2)
        @foreach($files as $key=>$collection)
            @if(!($key == 'members' || $key == 'public') && count($files[$key])>0)
                <h3>{{$key}} Files</h3>
                <table class="table">
                    <thead>
                    <th class="col-md-6">File Name</th>
                    <th class="col-md-6 text-right">Download</th>
                    </thead>
                    @foreach($files[$key] as $file)
                        <tr>
                            <td>{{$file['filename']}}</td>
                            <td class="text-right">
                                <a href="{{route('retrieve_office_document',['office'=>$file['office'],'filename'=>$file['filename']])}}"
                                   class="btn btn-primary">Download</a></td>
                        </tr>
                    @endforeach
                </table>
            @endif
        @endforeach
    @endif


@endsection