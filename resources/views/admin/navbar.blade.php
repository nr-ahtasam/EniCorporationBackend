@extends('admin.layout.layout')
@section('content')
<div class="container mt-4">
  <div class="card" style="max-width: 420px; margin:auto;">
    <div class="card-header bg-primary text-white">
      <h5 class="mb-0">Nav Bar Form</h5>
    </div>
    <div class="card-body">
      <form method="POST" action="{{ route('navbar.form.submit') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
          <label for="phone" class="form-label">Phone Number</label>
          <input type="tel" name="phone" class="form-control" id="phone" placeholder="Enter phone number" required>
        </div>
        <div class="mb-3">
          <label for="image" class="form-label">Image</label>
          <input type="file" name="image" class="form-control" id="image" accept="image/*" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
  </div>
</div>
@endsection
