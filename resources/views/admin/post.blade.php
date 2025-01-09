@extends('admin.main')

@section('content')

    <div class="row mb-3">
        <div class="col-12">
            <h1>Posts</h1>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createPostModal">
                Create New Post
            </button>
        </div>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Category</th>
                <th>Title</th>
                <th>Description</th>
                <th>Text</th>
                <th>Image</th>
                <th>Likes</th>
                <th>Dislikes</th>
                <th>Views</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($posts as $post)
                <tr>
                    <td>{{ $post->id }}</td>
                    <td>{{ $post->category->name }}</td>
                    <td>{{ $post->title }}</td>
                    <td>
                        <span class="description-preview">{{ Str::limit($post->description, 100) }}</span>
                        @if (strlen($post->description) > 100)
                            <a href="#" class="show-more" data-full-text="{{ $post->description }}">more</a>
                            <a href="#" class="show-less" style="display: none;">less</a>
                        @endif
                    </td>
                    <td>
                        <span class="text-preview">{{ Str::limit($post->text, 100) }}</span>
                        @if (strlen($post->text) > 100)
                            <a href="#" class="show-more" data-full-text="{{ $post->text }}">more</a>
                            <a href="#" class="show-less" style="display: none;">less</a>
                        @endif
                    </td>                                     
                    <td><img src="{{ asset($post->img) }}" style="width: 350px;" alt="{{ $post->title }}" class="img-fluid"></td>
                    <td>{{ $post->likes }}</td>
                    <td>{{ $post->dislikes }}</td>
                    <td>{{ $post->views }}</td>
                    <td>
                        <button type="button" style="width: 90px;" class="btn btn-warning" data-toggle="modal"
                            data-target="#editPostModal{{ $post->id }}">
                            Update
                        </button>

                        <form action="{{ route('post.destroy', $post->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="width: 90px;" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>

                <div class="modal fade" id="editPostModal{{ $post->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="editPostModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editPostModalLabel">Edit Post</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{ route('post.update', $post->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="title">Post Title:</label>
                                        <input type="text" name="title" value="{{ $post->title }}"
                                            class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Description:</label>
                                        <textarea name="description" class="form-control" rows="3" required>{{ $post->description }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="text">Text:</label>
                                        <textarea name="text" class="form-control" rows="3" required>{{ $post->text }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <input type="hidden" name="old_img" value="{{ $post->img }}">
                                        <label for="img" class="form-label">Image</label>
                                        <input type="file" class="form-control" name="img" id="img">
                                        <img src="{{ asset($post->img) }}" style="width: 120px;" alt="Not img">
                                    </div>
                                    <div class="form-group">
                                        <label for="category_id">Category:</label>
                                        <select name="category_id" class="form-control" required>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ $post->category_id == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </tbody>
    </table>

    <div class="modal fade" id="createPostModal" tabindex="-1" role="dialog" aria-labelledby="createPostModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createPostModalLabel">Create New Post</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="title">Post Title:</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description:</label>
                            <textarea name="description" class="form-control" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="text">Text:</label>
                            <textarea name="text" class="form-control" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="img">Image:</label>
                            <input type="file" name="img" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="category_id">Category:</label>
                            <select name="category_id" class="form-control" required>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
