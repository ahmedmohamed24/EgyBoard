<div class="list-group border">
    <ul class="list-group list-group-flush">
        @foreach (auth()->user()->activities->take(6) as $activity)
            <li class="list-group-item" style="font-size: 0.8rem">
                @if ($activity->activitable_type=== "App\Models\Project")
                    <a href="{{ route('project.show',$activity->activitable_id) }}" class="text-decoration-none">
                @elseif ($activity->activitable_type=== "App\Models\Task")
                    <a href="{{ route('project.show',$activity->activitable->project) }}" class="text-decoration-none">
                    <span class="font-weight-bolder mr-auto">{{ Str::limit($activity->activitable->body,10,'...' )}}</span>
                @endif
                <span> {{ $activity->description }} </span> By <span>{{ $activity->getOwner->name }}</span> <br/>
                <span class="text-muted mr-auto">{{ $activity->updated_at->diffForHumans() }}</span>
                @if ($activity->activitable_type=== "App\Models\Project")
                    </a>
                @elseif ($activity->activitable_type=== "App\Models\Task")
                    </a>
                @endif
            </li>
        @endforeach
    </ul>
</div>