<div class="list-group border">
    <ul class="list-group list-group-flush">
        @foreach (auth()->user()->activities->take(6) as $activity)
            <li class="list-group-item" style="font-size: 0.8rem">
                {{-- {{ $activity->activitable_type}} --}}
                @if ($activity->activitable_type=== "App\Models\Project")
                    <a href="{{ route('project.show',$activity->activitable_id) }}" class="text-decoration-none">
                @endif
                <span>{{ $activity->description }}</span> By <span>{{ $activity->getOwner->name }}</span><br/> <span class="text-muted mr-auto">{{ $activity->updated_at->diffForHumans() }}</span>
                @if ($activity->activitable_type=== "App\Models\Project")
                    </a>
                @endif
            </li>
        @endforeach
    </ul>
</div>