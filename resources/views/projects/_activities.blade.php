<div class="list-group border">
    <ul class="list-group list-group-flush">
        @foreach (auth()->user()->activities->take(6) as $activity)
            <li class="list-group-item" style="font-size: 0.8rem">
                <span>{{ $activity->description }}</span> By <span>{{ $activity->getOwner->name }}</span><br/> <span class="text-muted mr-auto">{{ $activity->updated_at->diffForHumans() }}</span>
            </li>
        @endforeach
    </ul>
</div>