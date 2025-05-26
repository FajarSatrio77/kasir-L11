<div>
    <div class="container py-4">
        <div class="row">
            <!-- Form Kategori -->
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        {{ $isEditing ? 'Edit Kategori' : 'Tambah Kategori Baru' }}
                    </div>
                    <div class="card-body">
                        @if (session()->has('message'))
                            <div class="alert alert-success" role="alert">
                                {{ session('message') }}
                            </div>
                        @endif
                        <form wire:submit.prevent="{{ $isEditing ? 'update' : 'create' }}">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Kategori</label>
                                <input type="text" wire:model="name" id="name" class="form-control" placeholder="Masukkan nama kategori">
                                @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Deskripsi</label>
                                <textarea wire:model="description" id="description" rows="3" class="form-control" placeholder="Masukkan deskripsi kategori"></textarea>
                                @error('description') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary flex-fill">
                                    {{ $isEditing ? 'Update Kategori' : 'Tambah Kategori' }}
                                </button>
                                @if($isEditing)
                                    <button type="button" wire:click="cancel" class="btn btn-secondary flex-fill">Batal</button>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Daftar Kategori -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-light">
                        <b>Daftar Kategori</b>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nama</th>
                                        <th>Deskripsi</th>
                                        <th style="width: 120px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($categories as $category)
                                        <tr>
                                            <td>{{ $category->name }}</td>
                                            <td>{{ Str::limit($category->description, 50) }}</td>
                                            <td>
                                                <button wire:click="edit({{ $category->id }})" class="btn btn-sm btn-warning me-1">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button wire:click="delete({{ $category->id }})" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center text-muted">Belum ada kategori yang ditambahkan</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {{ $categories->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 