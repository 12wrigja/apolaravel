<table class="table table-hover table-responsive">
    <thead>
    <th>Brother</th>
    @foreach($contractType::getRequirementClasses() as $requirement)
        <th class="text-center">
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
            <td>{{$brother->fullDisplayName()}}</td>

            @foreach($contract->requirements as $requirement)
                <td class="text-center">
                    {{round($requirement->getValue(),2)}}/{{$requirement->getThreshold()}}
                    @if($requirement->isComplete())
                        <span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span>
                    @endif
                </td>
            @endforeach
            <td class="text-center"><a target="_blank" href="{{route('user_status',['id'=>$brother->id])}}" class="btn btn-primary">Details</a></td>
        </tr>
    @endforeach
</table>