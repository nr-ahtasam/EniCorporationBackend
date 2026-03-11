@extends('admin.layout.layout')
@section('content')
<div class="container mt-4">
  <div class="row g-4 align-items-start">
    <div class="col-lg-5">
      <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
          <h5 class="mb-0">{{ isset($editNavbar) ? 'Edit Nav Bar' : 'Nav Bar Form' }}</h5>
          @if (isset($editNavbar))
            <span class="badge bg-light text-dark">Editing #{{ $editNavbar->id }}</span>
          @endif
        </div>

        <div class="card-body">
          @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
          @endif

          <form
            method="POST"
            action="{{ isset($editNavbar) ? route('navbar.form.update', $editNavbar->id) : route('navbar.form.submit') }}"
            enctype="multipart/form-data"
          >
            @csrf
            @if (isset($editNavbar))
              @method('PUT')
            @endif

            <div class="mb-3">
              <label for="phone" class="form-label">Phone Number</label>
              <input
                type="tel"
                name="phone"
                class="form-control @error('phone') is-invalid @enderror"
                id="phone"
                placeholder="Enter phone number"
                value="{{ old('phone', $editNavbar->phone ?? '') }}"
                required
              >
              @error('phone')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-3">
              <label for="image" class="form-label">Image</label>
              <input
                type="file"
                name="image"
                class="form-control @error('image') is-invalid @enderror"
                id="image"
                accept="image/*"
                @if (!isset($editNavbar)) required @endif
              >
              @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            @if (isset($editNavbar) && $editNavbar->image_path)
              <div class="mb-3">
                <label class="form-label d-block">Current Image</label>
                <img
                  src="{{ asset('storage/' . $editNavbar->image_path) }}"
                  alt="Current navbar image"
                  style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px;"
                >
              </div>
            @endif

            <div class="d-flex gap-2 pt-2 flex-wrap">
              <button type="submit" class="btn btn-primary">{{ isset($editNavbar) ? 'Update' : 'Submit' }}</button>
              @if (isset($editNavbar))
                <a href="{{ route('navbar.form') }}" class="btn btn-outline-secondary">Cancel</a>
              @endif
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="col-lg-7">
      <div class="card shadow-sm">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Navbar Data</h5>
          <span class="badge bg-light text-dark">{{ $navbars->count() }} records</span>
        </div>

        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-striped table-hover mb-0 align-middle">
              <thead class="table-light">
                <tr>
                  <th>ID</th>
                  <th>Phone</th>
                  <th>Image</th>
                  <th>Status</th>
                  <th>Created At</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($navbars as $item)
                  <tr class="@if ($item->is_active) table-success @endif">
                    <td>{{ $item->id }}</td>
                    <td class="text-nowrap">{{ $item->phone }}</td>
                    <td>
                      <img
                        src="{{ asset('storage/' . $item->image_path) }}"
                        alt="Navbar image"
                        style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;"
                      >
                    </td>
                    <td>
                      @if ($item->is_active)
                        <span class="badge bg-success">Active</span>
                      @else
                        <span class="badge bg-secondary">Inactive</span>
                      @endif
                    </td>
                    <td class="text-nowrap">{{ $item->created_at?->format('d M Y, h:i A') }}</td>
                    <td>
                      <div class="d-flex gap-1 flex-wrap">
                        <a href="{{ route('navbar.form.edit', $item->id) }}" class="btn btn-sm btn-outline-warning">Edit</a>

                        <form class="m-0" method="POST" action="{{ route('navbar.form.delete', $item->id) }}" onsubmit="return confirm('Are you sure you want to delete this row?')">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>

                        <form class="m-0" method="POST" action="{{ route('navbar.form.active', $item->id) }}">
                          @csrf
                          @method('PATCH')
                          <button type="submit" class="btn btn-sm btn-success" @if ($item->is_active) disabled @endif>
                            {{ $item->is_active ? 'Active' : 'Make Active' }}
                          </button>
                        </form>
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="6" class="text-center py-4">No navbar data found.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
