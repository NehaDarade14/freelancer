@extends('layouts.main')

@section('content')
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3>{{ ucfirst($freelancer->name) }}'s Profile</h3>
                        </div>

                        <div class="card-body">
                            <div class="text-right mb-4">
                                <a href="{{ route('projects.create', ['freelancer_id' => $freelancer->id]) }}"
                                    class="btn btn-primary mr-2">
                                    <i class="dwg-briefcase mr-2"></i>Initiate Project
                                </a>
                                <a href="{{ route('messages.index', ['user_id' => $freelancer->id]) }}"
                                    class="btn btn-success">
                                    <i class="dwg-message mr-2"></i>Send Message
                                </a>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#reviewsModal">
                                    View Reviews
                                </button>

                            </div>
                            <div class="row mb-4">
                                <div class="col-md-4 text-center">
                                        @if($freelancer->user_photo != '')
                                        <img class="rounded-circle" width="150" src="{{ url('/') }}/public/storage/users/{{ $freelancer->user_photo }}"  alt="{{ $freelancer->name }}">
                                        @else
                                        <img class="rounded-circle" width="150" src="{{ url('/') }}/public/img/no-image.png"  alt="{{ $freelancer->name }}">
                                        @endif

                                    <h5 class="mt-3">{{ ucfirst($freelancer->name) }}</h5>
                                    <p class="text-muted">
                                        Availability: {{ ucfirst(str_replace('_', ' ', $freelancer->available)); }}
                                    </p>
                                    <p class="text-muted">
                                        Experience: {{ $freelancer->experience ? $freelancer->experience .' year' : '' }}
                                    </p>


                                    
                                </div>

                                <div class="col-md-8">
                                    <h5>Skills</h5>
                                    <div class="mb-3">
                                        @foreach(explode(',', $freelancer->skills) as $skill)
                                            <span class="badge badge-primary">{{ trim($skill) }}</span>
                                        @endforeach
                                    </div>

                                    <h5>Rating</h5>
                                    <div class="mb-3">
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
                                    </div>

                                    <h5>Portfolio</h5>

                                    <div class="mb-3">
                                        <div class="card">
                                            <div class="card-body">
                                                @if($freelancer->facebook_url)
                                                    <a href="{{$freelancer->facebook_url }}" target="_blank" class="btn btn-sm btn-outline-primary">Facebook View</a>
                                                @endif
                                                @if($freelancer->twitter_url)
                                                    <a href="{{$freelancer->twitter_url }}" target="_blank" class="btn btn-sm btn-outline-primary">Twitter View</a>
                                                @endif
                                                @if($freelancer->gplus_url)
                                                    <a href="{{$freelancer->gplus_url }}" target="_blank" class="btn btn-sm btn-outline-primary">Gplus View</a>
                                                @endif
                                                @if($freelancer->instagram_url)
                                                    <a href="{{$freelancer->instagram_url }}" target="_blank" class="btn btn-sm btn-outline-primary">Instagram View</a>
                                                @endif
                                                @if($freelancer->linkedin_url)
                                                    <a href="{{$freelancer->linkedin_url }}" target="_blank" class="btn btn-sm btn-outline-primary">LinkedIn View</a>
                                                @endif
                                                @if($freelancer->pinterest_url)
                                                    <a href="{{$freelancer->pinterest_url }}" target="_blank" class="btn btn-sm btn-outline-primary">Pinterest View</a>
                                                @endif
                                                @if($freelancer->github_url)
                                                    <a href="{{$freelancer->github_url }}" target="_blank" class="btn btn-sm btn-outline-primary">GitHub View</a>
                                                @endif
                                                @if($freelancer->other)
                                                    <a href="{{$freelancer->other }}" target="_blank" class="btn btn-sm btn-outline-primary">Other View</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                    <h5>Professional Bio</h5>
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <p> {{$freelancer->professional_bio}} </p>
                                            </div>
                                        </div>
                                    </div>
                                    @if($hasActiveProject)
                                        <div class="mt-4">
                                            <h5>Contact Information</h5>
                                            <div class="card">
                                                <div class="card-body">
                                                    <p><strong>Email:</strong> {{ $freelancer->email }}</p>
                                                    @if($freelancer->phone)
                                                        <p><strong>Phone:</strong> {{ $freelancer->phone }}</p>
                                                    @endif
                                                    @if($freelancer->address)
                                                        <p><strong>Address:</strong> {{ $freelancer->address }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    <h5 class="mt-4">Notification Settings</h5>
                                    <div class="mb-3">
                                        <div class="card">
                                            
                                            <div class="card-body">
                                                <form method="POST" action="{{ route('notification.settings.update') }}">
                                                    @csrf
                                                    <div class="form-check mb-3">
                                                        <input type="hidden" name="project_updates" value="0">
                                                        <input class="form-check-input" type="checkbox" name="project_updates" id="project_updates" value="1"
                                                            {{ $notificationSettings->project_updates ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="project_updates">
                                                            Project Updates
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input type="hidden" name="messages" value="0">
                                                        <input class="form-check-input" type="checkbox" name="messages" id="messages" value="1"
                                                            {{ $notificationSettings->messages ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="messages">
                                                            Messages
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input type="hidden" name="payments" value="0">
                                                        <input class="form-check-input" type="checkbox" name="payments" id="payments" value="1"
                                                            {{ $notificationSettings->payments ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="payments">
                                                            Payment Notifications
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input type="hidden" name="new_jobs" value="0">
                                                        <input class="form-check-input" type="checkbox" name="new_jobs" id="new_jobs" value="1"
                                                            {{ $notificationSettings->new_jobs ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="new_jobs">
                                                            New Jobs
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input type="hidden" name="application_updates" value="0">
                                                        <input class="form-check-input" type="checkbox" name="application_updates" id="application_updates" value="1"
                                                            {{ $notificationSettings->application_updates ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="application_updates">
                                                            Application Update
                                                        </label>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Save Settings</button>
                                                </form>

                                            </div>
                                        </div>
                                    </div>

                                </div>                                       
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
<div class="modal fade" id="reviewsModal" tabindex="-1" role="dialog" aria-labelledby="reviewsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Client Reviews</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @php
                    $reviews = $freelancer->ratings->take(5);
                @endphp

                <div id="review-list">
                    @foreach ($reviews as $review)
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-2">
                                    <div>
                                        <strong>{{ $review->user->name ?? 'Anonymous Client' }}</strong>
                                        <span class="text-muted ml-2">•{{ $review->created_at->format('M d, Y') }}</span>
                                    </div>
                                    <div class="star-ratings">

                                        @php
                                            $ratings = round($review->avg('work_rating'), 1);
                                            $fullStarss = floor($ratings);
                                            $halfStars = ($ratings - $fullStarss) >= 0.5;
                                            $emptyStarss = 5 - $fullStarss - ($halfStars ? 1 : 0);
                                            
                                        @endphp

                                        @for ($i = 0; $i < $fullStarss; $i++)
                                            <i class="fa fa-star text-warning"></i>
                                        @endfor

                                        @if ($halfStars)
                                            <i class="fa fa-star-half text-warning"></i>
                                        @endif

                                        @for ($i = 0; $i < $emptyStarss; $i++)
                                            <i class="fa fa-star-o text-warning"></i>
                                        @endfor
                                    </div>
                                </div>
                                @if($review->review_text)
                                    <p class="mb-0">{{ $review->review_text }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <nav aria-label="Review pagination">
                    <ul class="pagination justify-content-center mt-3">
                        <li class="page-item disabled" id="prevPage">
                            <a class="page-link" href="#" tabindex="-1">Previous</a>
                        </li>
                        <li class="page-item" id="nextPage">
                            <a class="page-link" href="#">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>


    @include('script')
    <script>
document.addEventListener('DOMContentLoaded', function () {
    const allReviews = @json($freelancer->ratings);
    const perPage = 5;
    let currentPage = 1;

    function getStarHTML(work_rating) {
        const rating = Math.round(work_rating * 10) / 10;
        const fullStars = Math.floor(rating);
        const halfStar = rating - fullStars >= 0.5;
        const emptyStars = 5 - fullStars - (halfStar ? 1 : 0);

        let starsHTML = '';
        for (let i = 0; i < fullStars; i++) {
            starsHTML += '<i class="fa fa-star text-warning"></i>';
        }
        if (halfStar) {
            starsHTML += '<i class="fa fa-star-half text-warning"></i>';
        }
        for (let i = 0; i < emptyStars; i++) {
            starsHTML += '<i class="fa fa-star-o text-warning"></i>';
        }
        
        return starsHTML;
    }

    function renderReviews() {
        const start = (currentPage - 1) * perPage;
        const end = start + perPage;
        const reviewsToShow = allReviews.slice(start, end);
        const reviewList = document.getElementById('review-list');

        reviewList.innerHTML = reviewsToShow.map(review => {
            const name = review.user?.name || 'Anonymous Client';
            const createdAt = new Date(review.created_at).toLocaleDateString('en-US', {
                month: 'short',
                day: '2-digit',
                year: 'numeric'
            });
            const starsHTML = getStarHTML(review.work_rating);
            const reviewText = review.review_text ? `<p class="mb-0">${review.review_text}</p>` : '';

            return `
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <div>
                                <strong>${name}</strong>
                                <span class="text-muted ml-2">•${createdAt}</span>
                            </div>
                            <div class="star-ratings">
                                ${starsHTML}
                            </div>
                        </div>
                        ${reviewText}
                    </div>
                </div>
            `;
        }).join('');

        document.getElementById('prevPage').classList.toggle('disabled', currentPage === 1);
        document.getElementById('nextPage').classList.toggle('disabled', end >= allReviews.length);
    }

    document.getElementById('prevPage').addEventListener('click', function (e) {
        e.preventDefault();
        if (currentPage > 1) {
            currentPage--;
            renderReviews();
        }
    });

    document.getElementById('nextPage').addEventListener('click', function (e) {
        e.preventDefault();
        if ((currentPage * perPage) < allReviews.length) {
            currentPage++;
            renderReviews();
        }
    });

    $('#reviewsModal').on('shown.bs.modal', renderReviews);
});
</script>


@endsection 