@extends('bbc.main')

@section('content')
    <!-- News With Sidebar Start -->
    <div class="container-fluid">
        <div class="container">
            <div class="row mt-4">
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-12">
                            <div class="section-title">
                                <h4 class="m-0 text-uppercase font-weight-bold">News</h4>
                                <a class="text-secondary font-weight-medium text-decoration-none"
                                    href="{{ route('bbc.index') }}">View All</a>
                            </div>
                        </div>
                    </div>
                    <!-- News Detail Start -->
                    <div class="row">
                        <div class="col-12">
                            <div class="position-relative mb-3">
                                <img class="img-fluid w-100" src="{{ asset($post->img) }}" style="object-fit: cover;">
                                <div class="bg-white border border-top-0 p-4">
                                    <div class="mb-3">
                                        <a class="badge badge-primary text-uppercase font-weight-semi-bold p-2 mr-2"
                                            href="">{{ $categories->find($post->category_id)->name }}</a>
                                        <a class="text-body"
                                            style="font-size: 20px;"><small>{{ $post->created_at->format('M d, Y') }}</small></a>
                                    </div>
                                    <h1 class="mb-3 text-secondary text-uppercase font-weight-bold">{{ $post->title }}</h1>
                                    <p>{{ $post->text }}</p>
                                </div>
                                <div class="d-flex justify-content-between bg-white border border-top-0 p-4">
                                    <div class="d-flex align-items-center">
                                        <img class="rounded-circle mr-2" src="img/user.jpg" width="25" height="25"
                                            alt="">
                                        <small>{{ $post->author ?? 'Author' }}</small>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <small class="ml-3">
                                            <i class="far fa-eye mr-2"></i>{{ $views_count }}
                                        </small>
                                        <small class="ml-3">
                                            <form action="{{ route('posts.like', $post->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                <input type="hidden" name="post_id" value="{{ $post->id }}">
                                                <input type="hidden" name="value" value="1">
                                                <button type="submit"
                                                    class="btn btn-link {{ \App\Models\LikeOrDislike::where('post_id', $post->id)->where('user_id', auth()->id())->where('value', 1)->exists()? 'text-danger': '' }}">
                                                    <i class="far fa-thumbs-up mr-2"></i>{{ $likes_count }}
                                                </button>
                                            </form>
                                        </small>
                                        <small class="ml-3">
                                            <form action="{{ route('posts.dislike', $post->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                <input type="hidden" name="post_id" value="{{ $post->id }}">
                                                <input type="hidden" name="value" value="-1">
                                                <button type="submit"
                                                    class="btn btn-link {{ \App\Models\LikeOrDislike::where('post_id', $post->id)->where('user_id', auth()->id())->where('value', -1)->exists()? 'text-danger': '' }}">
                                                    <i class="far fa-thumbs-down mr-2"></i>{{ $dislikes_count }}
                                                </button>
                                            </form>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- News Detail End -->

                    <!-- Comment List Start -->
                    <div class="mb-3">
                        <div class="section-title mb-0">
                            <h4 class="m-0 text-uppercase font-weight-bold">{{ $comments->count() }} Comments</h4>
                        </div>
                        <div class="bg-white border border-top-0 p-4">
                            @foreach ($comments as $comment)
                                <div class="media mb-4">
                                    <img src="{{ asset('img/user.jpg') }}" alt="Image" class="img-fluid mr-3 mt-1"
                                        style="width: 45px;">
                                    <div class="media-body">
                                        <h6><a class="text-secondary font-weight-bold"
                                                href="#">{{ $comment->user->name }}</a>
                                            <small><i>{{ $comment->created_at->format('d M Y') }}</i></small>
                                        </h6>
                                        <p>{{ $comment->body }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Comment List End -->

                    <!-- Comment Form Start -->
                    <div class="mb-3">
                        <div class="section-title mb-0">
                            <h4 class="m-0 text-uppercase font-weight-bold">Leave a comment</h4>
                        </div>
                        <div class="bg-white border border-top-0 p-4">
                            <form action="{{ route('comments.store', ['post' => $post->id]) }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="message">Message *</label>
                                    <textarea id="message" name="message" cols="30" rows="5" class="form-control"></textarea>
                                </div>
                                <div class="form-group mb-0">
                                    <input type="submit" value="Leave a comment"
                                        class="btn btn-primary font-weight-semi-bold py-2 px-3">
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Comment Form End -->
                </div>

                <div class="col-lg-4">
                    <div class="mb-3">
                        <div class="section-title mb-0">
                            <h4 class="m-0 text-uppercase font-weight-bold">Latest news</h4>
                        </div>
                        <div class="bg-white border border-top-0 p-3">
                            @foreach ($new_posts as $new_post)
                                <div class="d-block w-100 text-dark text-decoration-none mb-3 news-item"
                                    style="background: #f8f9fa; padding: 10px; border-radius: 8px;">
                                    <a class="news-title h5 d-block mb-1 text-uppercase font-weight-bold"
                                        href="{{ route('bbc.single', $new_post->id) }}">{{ Str::limit($new_post->title, 80) }}</a>
                                    <p class="news-description">{{ Str::limit($new_post->description, 65) }}</p>
                                    <div class="mt-1">
                                        <a class="new_post_text-category font-weight-semi-bold mr-2"
                                            href="{{ route('bbc.category', $new_post->category_id) }}">
                                            {{ $categories->find($new_post->category_id)->name }}
                                        </a>
                                        <a class="text-body"
                                            href=""><small>{{ $post->created_at->format('M d, Y') }}</small></a>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>

                    <!-- Tags Start -->
                    <div class="mb-3">
                        <div class="section-title mb-0">
                            <h4 class="m-0 text-uppercase font-weight-bold">Tags</h4>
                        </div>
                        <div class="bg-white border border-top-0 p-3">
                            <div class="d-flex flex-wrap m-n1">
                                @foreach ($categories as $category)
                                    <a href="{{ route('bbc.category', $category->id) }}"
                                        class="btn btn-sm btn-outline-secondary m-1">{{ $category->name }}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <!-- Tags End -->
                </div>
            </div>
        </div>
    </div>
    <!-- News With Sidebar End -->
@endsection
