<table class="table table-hover table-responsive">
    <thead>
    <th>Brother</th>
    @foreach($contractType::getRequirementClasses() as $requirement)
        <th>
            {{$requirement::$name}}
        </th>
    @endforeach
    <th></th>
    </thead>
    @foreach($brothers as $brother)
        <?php $contract = $brother->contractForSemester(null);?>
        <tr
                @if($contract->isComplete())
                    class="success"
                @endif
                >
            <td>{{$brother->getFullDisplayName()}}</td>

            @foreach($contract->requirements as $requirement)
                <td>
                    {{round($requirement->getValue(),2)}}/{{$requirement->getThreshold()}}
                    @if($requirement->isComplete())
                        <span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span>
                    @endif
                </td>
            @endforeach
            <td><a target="_blank" href="{{route('user_status',['id'=>$brother->id])}}" class="btn btn-primary">Details</a></td>
        </tr>
    @endforeach
</table>