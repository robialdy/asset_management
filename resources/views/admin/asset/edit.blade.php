@extends('template.templateAdmin')

@section('title', $title)

@section('content')


<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Edit Asset</h3>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="">Assets</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

 <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col">
                    <h4 class="card-title">Form</h4>
                </div>
                <div class="text-end col">
                    <button type="button" class="btn btn-outline-primary" id="add-button">Add Detail</button>
                </div>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('asset.update', $asset->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name"> Asset Name<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="full-name" placeholder="Enter Name" name="name" value="{{ old('name', $asset->name) }}">
                            @error('name')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="category">Category<span class="text-danger">*</span></label>
                            <select class="form-select" id="category" name="category">
                                <option selected disabled>Select Category</option>
                                <option value="Elektronik" @if(old('category', $asset->category) == 'Elektronik') selected @endif>Elektronik</option>
                                <option value="Furniture" @if(old('category', $asset->category) == 'Furniture') selected @endif>Furniture</option>
                                <option value="Peralatan" @if(old('category', $asset->category) == 'Peralatan') selected @endif>Peralatan</option>
                            </select>
                            @error('category')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        @if (request()->is('admin/available-asset*'))
                        <div class="form-group">
                            <label for="image">Image <small class="text-muted"><i>Max 5MB!</i></small></label>
                            <div class="input-group mb-3">
                                <input type="file" class="form-control" id="image" name="image">
                            </div>
                        </div>
                        @endif

                        <small class="text-muted fst-italic mb-3">Click add details to add details!</small>

                        @foreach ($detailAsset as $dasset)
                        <div class="row mb-3">
                            <input type="hidden" name="detail[{{ $loop->index }}][id]" value="{{ $dasset->id }}">
                            <div class="col-lg-6">
                                <label for="">Title</label>
                                <input class="form-control" type="text" placeholder="Enter Title" value="{{ $dasset->title }}" name="detail[{{ $loop->index }}][title]">
                            </div>
                            <div class="col-lg-6">
                                <label for="">Description</label>
                                <input class="form-control" type="text" placeholder="Enter Description" value="{{ $dasset->description }}" name="detail[{{ $loop->index }}][ddescription]">
                            </div>
                        </div>
                        @endforeach

                    <div id="input-container">
                        <!-- Input fields will be appended here -->
                    </div>

                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="code-asset">Code Asset<span class="text-danger">*</span> <small class="text-muted"><i>Generate Automatics!</i></small></label>
                            <input type="text" class="form-control" id="code-asset" name="code_asset" value="{{ $asset->code_asset }}" disabled>
                            @error('code-asset')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Description<span class="text-danger">*</span></label>
                            <textarea class="form-control" name="description" id="description" rows="4">{{ old('description', $asset->description) }}</textarea>
                            @error('description')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>


                    {{-- SCRIPT --}}
                    <script>
                    document.getElementById('add-button').addEventListener('click', function () {
                    const container = document.getElementById('input-container');
                    const inputGroup = document.createElement('div');
                    inputGroup.classList.add('row', 'mb-3');

                     const index = container.children.length;

                    const createInputColumn = (labelText, placeholderText, name) => {
                        const col = document.createElement('div');
                        col.classList.add('col-lg-6');

                        const label = document.createElement('label');
                        label.innerHTML = `${labelText}<span class="text-danger">*</span>`;

                        const input = document.createElement('input');
                        input.type = 'text';
                        input.classList.add('form-control');
                        input.setAttribute('placeholder', placeholderText);
                        input.name = `data[${index}][${name}]`;
                        input.required = true;

                        col.appendChild(label);
                        col.appendChild(input);
                        return col;
                    };

                    const titleCol = createInputColumn('Title', 'Enter Title', 'title');
                    const descriptionCol = createInputColumn('Description', 'Enter Description', 'ddescription');

                    inputGroup.appendChild(titleCol);
                    inputGroup.appendChild(descriptionCol);
                    container.appendChild(inputGroup);
                    });
                    </script>

                        @if (!request()->is('admin/available-asset*'))
                        <div class="modal fade text-left modal-borderless" id="message" tabindex="-1" aria-labelledby="myModalLabel1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Message</h5>
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                        <div class="row">
                                            <div class="col mb-2">
                                                <div class="form-group">
                                                    <textarea class="form-control" name="message" id="message" rows="4" placeholder="Enter Message" required></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <button type="button" class="btn btn-light-primary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Send</button>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                        @endif

                    <div class="text-end">
                        @if (!request()->is('admin/available-asset*'))
                            <button type="submit" class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#message">Edit</button>
                        @else
                        <button type="submit" class="btn btn-primary mt-2">Edit</button>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
