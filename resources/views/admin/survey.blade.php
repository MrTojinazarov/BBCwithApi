@extends('admin.main')

@section('title', 'So\'rovnoma')

@section('content')
<div class="container">
    <h2>So'rovnomalar</h2>

    @foreach ($savols as $savol)
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ $savol->name }}</h5>
                <br>
                <ul>
                    @foreach ($savol->variants as $variant)
                    <li>
                        {{ $variant->name }}
                        <form action="{{ route('variant.destroy', $variant->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Variantni o\'chirishga ishonchingiz komilmi?')">O'chirish</button>
                        </form>
                    </li>
                    <br>
                @endforeach                
                </ul>
                <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#updateSurveyModal-{{ $savol->id }}">
                    Yangilash
                </button>
                <form action="{{ route('survey.destroy', $savol->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm ms-2">O'chirish</button>
                </form>
            </div>
        </div>

        <!-- Update Modal for the survey -->
        <div class="modal fade" id="updateSurveyModal-{{ $savol->id }}" tabindex="-1" aria-labelledby="updateSurveyModalLabel-{{ $savol->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateSurveyModalLabel-{{ $savol->id }}">So'rovnomani Yangilash</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('survey.update', $savol->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="savol_name">So'rovnoma Savoli</label>
                                <input type="text" name="savol_name" id="savol_name" class="form-control" value="{{ $savol->name }}" required>
                            </div>

                            <div class="form-group mt-3">
                                <label for="is_active">Faollik</label>
                                <input type="checkbox" name="is_active" id="is_active" value="1" {{ $savol->is_active ? 'checked' : '' }}>
                                <label for="is_active">Aktiv</label>
                            </div>

                            <div class="form-group mt-3">
                                <label for="variants">Variantlar</label>
                                <div id="variant-container-{{ $savol->id }}">
                                    @foreach ($savol->variants as $variant)
                                        <input type="text" name="variants[]" class="form-control mb-2" value="{{ $variant->name }}" required>
                                    @endforeach
                                </div>
                                <button type="button" onclick="addVariant('{{ $savol->id }}')" class="btn btn-secondary mt-2">Yana variant qo'shish</button>
                            </div>

                            <button type="submit" class="btn btn-primary mt-3">Yangilash</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#createSurveyModal">
        Yangi So'rovnoma Qo'shish
    </button>

    <!-- Modal for creating a new survey -->
    <div class="modal fade" id="createSurveyModal" tabindex="-1" aria-labelledby="createSurveyModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createSurveyModalLabel">Yangi So'rovnoma Yaratish</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('survey.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="savol_name">So'rovnoma Savoli</label>
                            <input type="text" name="name" id="savol_name" class="form-control" required>
                        </div>

                        <div class="form-group mt-3">
                            <label for="is_active">Faollik</label>
                            <input type="checkbox" name="is_active" id="is_active" value="1">
                            <label for="is_active">Aktiv</label>
                        </div>

                        <div class="form-group mt-3">
                            <label for="variants">Variantlar</label>
                            <div id="variant-container">
                                <input type="text" name="variants[]" class="form-control mb-2" placeholder="Variant nomini kiriting" required>
                                <input type="text" name="variants[]" class="form-control mb-2" placeholder="Variant nomini kiriting" required>
                            </div>
                            <button type="button" onclick="addVariant()" class="btn btn-secondary mt-2">Yana variant qo'shish</button>
                        </div>

                        <button type="submit" class="btn btn-primary mt-3">Saqlash</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
