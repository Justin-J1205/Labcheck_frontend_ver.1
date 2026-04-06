@if (Auth::user()->role === 'student')
    @if (!$experiment->users->contains(Auth::id()))
        {{-- Show Join Button if they haven't joined yet --}}
        <form action="{{ route('experiments.join', $experiment->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn-join">Join Experiment</button>
        </form>
    @else
        {{-- Show Leave Button if they are already in --}}
        <form action="{{ route('experiments.leave', $experiment->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-leave">Leave Experiment</button>
        </form>
    @endif
@endif
