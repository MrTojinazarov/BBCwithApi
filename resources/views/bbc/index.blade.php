@extends('bbc.main')

@section('content')
    <div class="container-fluid">
        <div class="container">
            <div class="row mt-3">
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-12">
                            <div class="section-title">
                                <h4 class="m-0 text-uppercase font-weight-bold">News</h4>
                                <a class="text-secondary font-weight-medium text-decoration-none" href="{{ route('bbc.index') }}">View All</a>
                            </div>
                        </div>
    
                        @foreach($posts as $post)
                        <div class="col-lg-6">
                            <div class="position-relative pb-3 h-100 d-flex flex-column" style="height: 450px;">
                                <img class="img-fluid w-100" src="{{ asset($post->img) }}" style="object-fit: cover; height: 220px;">
                                <div class="bg-white border border-top-0 p-4 flex-grow-1">
                                    <div class="mb-2">
                                        <a class="badge badge-primary text-uppercase font-weight-semi-bold p-2 mr-2" href="{{ route('bbc.category', $post->category_id) }}">
                                            {{ $categories->find($post->category_id)->name }}
                                         </a>
                                        <a class="text-body" href=""><small>{{ $post->created_at->format('M d, Y') }}</small></a>
                                    </div>
                                    <a class="h5 d-block mb-3 text-secondary text-uppercase font-weight-bold" href="{{route('bbc.single', $post->id)}}">{{ Str::limit($post->title, 80) }}</a>
                                    <p class="m-0">{{ Str::limit($post->description, 60) }}</p>
                                </div>
                                <div class="d-flex justify-content-between bg-white border border-top-0 p-4">
                                    <div class="d-flex align-items-center">
                                        <img class="rounded-circle mr-2" src="img/user.jpg" width="25" height="25" alt="">
                                        <small>{{ $post->author ?? 'Author' }}</small>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <small class="ml-3">
                                            <i class="far fa-eye mr-2"></i>{{ $post->views_count }}
                                        </small>
                                        
                                        <small class="ml-3">
                                            <form action="{{ route('posts.like', $post->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <input type="hidden" name="post_id" value="{{ $post->id }}">
                                                <input type="hidden" name="value" value="1">
                                                <button type="submit" class="btn btn-link {{ $post->likes_count ? 'text-danger' : '' }}">
                                                    <i class="far fa-thumbs-up mr-2"></i>{{ $post->likes_count }}
                                                </button>
                                            </form>
                                        </small>
                                        
                                        <small class="ml-3">
                                            <form action="{{ route('posts.dislike', $post->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <input type="hidden" name="post_id" value="{{ $post->id }}">
                                                <input type="hidden" name="value" value="-1">
                                                <button type="submit" class="btn btn-link {{ $post->dislikes_count ? 'text-danger' : '' }}">
                                                    <i class="far fa-thumbs-down mr-2"></i>{{ $post->dislikes_count }}
                                                </button>
                                            </form>
                                        </small>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        
                        @endforeach
    
                        <div class="col-lg-12 mb-3">
                            <a href=""><img class="img-fluid w-100" src="img/ads-728x90.png" alt=""></a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="pagination">
                                {{ $posts->links() }}
                            </div>
                        </div>
                    </div>
                    
                </div>
    
                <div class="col-lg-4">
                    <div class="mb-3">
                        <div class="section-title mb-0">
                            <h4 class="m-0 text-uppercase font-weight-bold">Latest news</h4>
                        </div>
                        <div class="bg-white border border-top-0 p-3">
                            @foreach($new_posts as $new_post)
                            <div class="d-block w-100 text-dark text-decoration-none mb-3 news-item" style="background: #f8f9fa; padding: 10px; border-radius: 8px;">
                                <a class="news-title h5 d-block mb-1 text-uppercase font-weight-bold" href="{{route('bbc.single', $new_post->id)}}">{{ Str::limit($new_post->title, 80) }}</a>
                                <p class="news-description">{{ Str::limit($new_post->description, 65) }}</p>
                                <div class="mt-1">
                                    <a class="new_post_text-category font-weight-semi-bold mr-2" href="{{ route('bbc.category', $new_post->category_id) }}">
                                        {{ $categories->find($new_post->category_id)->name }}
                                    </a>                                    
                                    <a class="text-body" href=""><small>{{ $post->created_at->format('M d, Y') }}</small></a>
                                </div>
                            </div>
                        @endforeach
                        
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="section-title mb-0">
                            <h4 class="m-0 text-uppercase font-weight-bold">Tags</h4>
                        </div>
                        <div class="bg-white border border-top-0 p-3">
                            <div class="d-flex flex-wrap m-n1">
                                @foreach ($categories as $category)
                                <a href="{{ route('bbc.category', $category->id) }}" class="btn btn-sm btn-outline-secondary m-1">{{ $category->name }}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    
@endsection
