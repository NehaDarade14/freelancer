@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>Search Freelancers</h3>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('freelancers.search') }}">
                    @csrf
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label for="skills">Skills</label>
                                <input type="text" name="skills" id="skills" class="form-control mb-2" placeholder="e.g. Laravel, React" value="{{ request('skills') }}">
                            </div>

                            <div class="col-md-3">
                                <label for="rating">Minimum Rating</label>
                                <select name="rating" id="rating" class="form-control">
                                    <option value="">Any Rating</option>
                                    <option value="1" {{ request('rating') == 1 ? 'selected' : '' }}>1+ Stars</option>
                                    <option value="2" {{ request('rating') == 2 ? 'selected' : '' }}>2+ Stars</option>
                                    <option value="3" {{ request('rating') == 3 ? 'selected' : '' }}>3+ Stars</option>
                                    <option value="4" {{ request('rating') == 4 ? 'selected' : '' }}>4+ Stars</option>
                                    <option value="5" {{ request('rating') == 5 ? 'selected' : '' }}>5 Stars</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label for="available">Availability</label>
                                <select name="available" id="available" class="form-control">
                                    <option value="">Any Availability</option>
                                    <option value="full_time" {{ request('available') == 'full_time' ? 'selected' : '' }}>Full Time</option>
                                    <option value="part_time" {{ request('available') == 'part_time' ? 'selected' : '' }}>Part Time</option>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary mt-4">Search</button>
                            </div>
                        </div>
                    </form>

                    <div class="freelancers-list">
                        @foreach($freelancers as $freelancer)
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            @if($freelancer->user_photo != '')
                                                <img class="rounded-circle" width="80" src="{{ url('/') }}/public/storage/users/{{ $freelancer->user_photo }}"  alt="{{ $freelancer->name }}">
                                            @else
                                                <img class="rounded-circle" width="80" src="{{ url('/') }}/public/img/no-image.png"  alt="{{ $freelancer->name }}">
                                            @endif

                                            <h4 class="mt-3">{{ ucfirst($freelancer->name) }}</h4>
                                            <p class="text-muted">
                                            @if(!empty($freelancer->skills))
                                                @foreach(explode(',', $freelancer->skills) as $skill)
                                                    <span class="badge badge-primary">{{ trim($skill) }}</span>
                                                @endforeach
                                            @endif

                                            </p>
                                                @php
                                        $rating = round($freelancer->ratings->avg('work_rating'), 1);
                                        $fullStars = floor($rating);
                                        $halfStar = ($rating - $fullStars) >= 0.5;
                                        $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
                                        
                                    @endphp

                                    @for ($i = 0; $i < $fullStars; $i++)
                                        <i class="fa fa-star text-warning"></i>
                                    @endfor

                                    @if ($halfStar)
                                        <i class="fa fa-star-half text-warning"></i>
                                    @endif

                                    @for ($i = 0; $i < $emptyStars; $i++)
                                        <i class="fa fa-star-o text-warning"></i>
                                    @endfor

                                    <span class="ml-2">({{ $rating }} stars)</span>
                                            <p> Availability: {{ ucfirst(str_replace('_', ' ', $freelancer->available)); }}</p>
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <a href="{{ route('freelancer-profile', $freelancer->id) }}" class="btn btn-outline-primary"> <i class="dwg-eye mr-1"></i>View Profile</a>
                                            <a href="{{ route('projects.create', ['freelancer_id' => $freelancer->id]) }}"
                                                class="btn btn-primary">
                                                <i class="dwg-briefcase mr-1"></i>Hire
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4">
                        {{ $freelancers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 