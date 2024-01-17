@extends('layouts.main')

@section('content')

    <div class="pagetitle">
      <h1>Perfil</h1>
        {{-- <nav>
            <ol class="breadcrumb">
            <li class="breadcrumb-item active"></li>
            </ol>
        </nav> --}}
    </div>
    <!-- End Page Title -->

    @include('messages.message')

    <section class="section profile">
      <div class="row">
        <div class="col-xl-4">

          <div class="card">
            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

              <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">
              <h2>{{$user->name}}</h2>
              <h3>{{$user->company}}</h3>
            </div>
          </div>

        </div>

        <div class="col-xl-8">

          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered">

                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-change-password">Editar perfil</button>
                </li>

              </ul>
              <div class="tab-content pt-2">

                <div class="tab-pane fade show active pt-3" id="profile-change-password">
                  <!-- Change Password Form -->
                  <form action="{{ route('update-password') }}" method="POST">
                    @csrf
                    <div class="row mb-3">
                      <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Actual contraseña</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="old_password" type="password" class="form-control @error('old_password') is-invalid @enderror" id="currentPassword" required placeholder="******">
                        @error('old_password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">Nueva contraseña</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="new_password" type="password" class="form-control @error('new_password') is-invalid @enderror" id="newPassword" required placeholder="******">
                        @error('new_password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Confirmar contraseña</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="new_password_confirmation" type="password" class="form-control" id="renewPassword" required placeholder="******">
                      </div>
                    </div>

                    <div class="text-center">
                      <button type="submit" class="btn btn-primary">Actualizar</button>
                    </div>
                  </form><!-- End Change Password Form -->

                </div>

              </div><!-- End Bordered Tabs -->

            </div>
          </div>

        </div>
      </div>
    </section>


@endsection

@section('script')

@endsection