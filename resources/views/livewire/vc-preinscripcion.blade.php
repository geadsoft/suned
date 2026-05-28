@extends('layouts.master-without-nav')
@section('title')
@lang('translation.signin')
@endsection
@section('content')
<style>

.info-card{
    min-width: 200px;
    padding: 10px 15px;
    border-radius: 12px;
    border: 1px solid rgba(255,255,255,0.25);
    background: rgba(255,255,255,0.08);
    backdrop-filter: blur(4px);
    color: #fff;
    transition: all .3s ease;
}

.info-card:hover{
    transform: translateY(-3px);
    background: rgba(255,255,255,0.12);
}

.icon-box{
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: rgba(255,255,255,0.10);
    display:flex;
    align-items:center;
    justify-content:center;
    font-size: 30px;
    color: #fff;
}

.info-card h4{
    font-size: 22px;
    line-height: 1;
    color: #fff;
}

.info-card small{
    font-size: 18px;
    opacity: .9;
}

</style>
<div class="auth-page-wrapper pt-5">
    <!-- auth page bg -->
    <div class="auth-one-bg-position auth-one-bg"  id="auth-particles">
        <div class="bg-overlay"></div>

        <div class="shape">
            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1440 120">
                <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
            </svg>
        </div>
    </div>

    <!-- auth page content -->
    <div class="auth-page-content">
        <div class="container">
            <div class="row mb-3">
                <div class="col-lg-8">
                    <span class="badge fs-6 px-4 py-2 mb-3 shadow-sm"
                        style="
                            background:#c1121f;
                            border:1px solid rgba(255,255,255,.2);
                            border-radius:10px;
                        ">Proceso Académico 2026 - 2027
                    </span>
                    <div class="text-white" style="font-size:30px;">
                        <label>Sistema de Preinscripción Estudiantil</label>
                    </div>
                    <div class="text-white fs-20">
                        <p class="fs-5">
                            Complete la ficha acumulativa del estudiante para iniciar
                            el proceso de <br> admisión en la <strong>Unidad Educativa American School.</strong>
                        </p>
                    </div>
                    <div class="d-flex gap-3 flex-wrap">

                        <!-- CARD DIGITAL -->
                        <div class="info-card">
                            <div class="d-flex align-items-center">

                                <div class="icon-box">
                                    <i class="ri-computer-line"></i>
                                </div>

                                <div class="ms-3">
                                    <h4 class="mb-0 fw-bold">100%</h4>
                                    <small>Digital</small>
                                </div>

                            </div>
                        </div>

                        <!-- CARD SEGURIDAD -->
                        <div class="info-card">
                            <div class="d-flex align-items-center">

                                <div class="icon-box">
                                    <i class="ri-shield-check-line"></i>
                                </div>

                                <div class="ms-3">
                                    <h4 class="mb-0 fw-bold">Seguro</h4>
                                    <small>Protección de datos</small>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="rounded-4 shadow-lg">

                            <img src="{{ URL::asset('assets/images/preinscripcion.png')}}"
                                 alt="American School"
                                 style="max-height:250px;">

                        </div>
                </div>
            </div>
            <!-- end row -->

            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-12">
                    <div class="card mt-1">
                        
                            <div class="card">
                                <div class="card-body">
                                    <form action="#" class="form-steps" autocomplete="off">
                                        <div class="text-center pt-3 pb-4 mb-1">
                                            <h5>Admision - Ficha Acumulativa</h5>
                                        </div>
                                        <div id="custom-progress-bar" class="progress-nav mb-4">
                                            <div class="progress" style="height: 1px;">
                                                <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>

                                            <ul class="nav nav-pills progress-bar-tab custom-nav" role="tablist">
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link rounded-pill active" data-progressbar="custom-progress-bar" id="pills-gen-info-tab" data-bs-toggle="pill" data-bs-target="#pills-gen-info" type="button" role="tab" aria-controls="pills-gen-info" aria-selected="true" data-position="0">1</button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link rounded-pill" data-progressbar="custom-progress-bar" id="pills-info-desc-tab" data-bs-toggle="pill" data-bs-target="#pills-info-desc" type="button" role="tab" aria-controls="pills-info-desc" aria-selected="false" data-position="1" tabindex="-1">2</button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link rounded-pill" data-progressbar="custom-progress-bar" id="pills-success-tab" data-bs-toggle="pill" data-bs-target="#pills-success" type="button" role="tab" aria-controls="pills-success" aria-selected="false" data-position="2" tabindex="-1">3</button>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="tab-content">
                                            <div class="tab-pane fade active show" id="pills-gen-info" role="tabpanel" aria-labelledby="pills-gen-info-tab">
                                                <div>
                                                    <div class="mb-4">
                                                        <div>
                                                            <h5 class="mb-1">DATOS DE IDENTIFICACIÓN/ INFORMACIÓN</h5>
                                                            <p class="text-muted">Fill all Information as below</p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="gen-info-email-input">Email</label>
                                                                <input type="email" class="form-control" id="gen-info-email-input" placeholder="Enter email" required="">
                                                                <div class="invalid-feedback">Please enter an email address</div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="gen-info-username-input">User Name</label>
                                                                <input type="text" class="form-control" id="gen-info-username-input" placeholder="Enter user name" required="">
                                                                <div class="invalid-feedback">Please enter a user name</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label" for="gen-info-password-input">Password</label>
                                                        <input type="password" class="form-control" id="gen-info-password-input" placeholder="Enter Password" required="">
                                                        <div class="invalid-feedback">Please enter a password</div>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-start gap-3 mt-4">
                                                    <button type="button" class="btn btn-success btn-label right ms-auto nexttab nexttab" data-nexttab="pills-info-desc-tab"><i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Go to more info</button>
                                                </div>
                                            </div>
                                            <!-- end tab pane -->

                                            <div class="tab-pane fade" id="pills-info-desc" role="tabpanel" aria-labelledby="pills-info-desc-tab">
                                                <div>
                                                    <div class="text-center">
                                                        <div class="profile-user position-relative d-inline-block mx-auto mb-2">
                                                            <img src="assets/images/users/user-dummy-img.jpg" class="rounded-circle avatar-lg img-thumbnail user-profile-image" alt="user-profile-image">
                                                            <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                                                                <input id="profile-img-file-input" type="file" class="profile-img-file-input" accept="image/png, image/jpeg">
                                                                <label for="profile-img-file-input" class="profile-photo-edit avatar-xs">
                                                                    <span class="avatar-title rounded-circle bg-light text-body">
                                                                        <i class="ri-camera-fill"></i>
                                                                    </span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <h5 class="fs-14">Add Image</h5>

                                                    </div>
                                                    <div>
                                                        <label class="form-label" for="gen-info-description-input">Description</label>
                                                        <textarea class="form-control" placeholder="Enter Description" id="gen-info-description-input" rows="2" required=""></textarea>
                                                        <div class="invalid-feedback">Please enter a description</div>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-start gap-3 mt-4">
                                                    <button type="button" class="btn btn-link text-decoration-none btn-label previestab" data-previous="pills-gen-info-tab"><i class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i> Back to General</button>
                                                    <button type="button" class="btn btn-success btn-label right ms-auto nexttab nexttab" data-nexttab="pills-success-tab"><i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Submit</button>
                                                </div>
                                            </div>
                                            <!-- end tab pane -->

                                            <div class="tab-pane fade" id="pills-success" role="tabpanel" aria-labelledby="pills-success-tab">
                                                <div>
                                                    <div class="text-center">

                                                        <div class="mb-4">
                                                            <lord-icon src="https://cdn.lordicon.com/lupuorrc.json" trigger="loop" colors="primary:#0ab39c,secondary:#405189" style="width:120px;height:120px"></lord-icon>
                                                        </div>
                                                        <h5>Well Done !</h5>
                                                        <p class="text-muted">You have Successfully Signed Up</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end tab pane -->
                                        </div>
                                        <!-- end tab content -->
                                    </form>
                                </div>
                                <!-- end card body -->
                            </div>
                        
                    </div>
                    <!-- end card -->

                    <!--<div class="mt-4 text-center">
                        <p class="mb-0">¿No tienes una cuenta? <a href="register" class="fw-semibold text-primary text-decoration-underline"> Signup </a> </p>
                    </div>-->

                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end auth page content -->

    <!-- footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center">
                        <p class="mb-0 text-muted">&copy; <script>document.write(new Date().getFullYear())</script> Elaborado por </i> Tnlg. Christian Galarza L.</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- end Footer -->
</div>
@endsection
@section('script')
<script src="{{ URL::asset('assets/libs/particles.js/particles.js.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/pages/particles.app.js') }}"></script>
<script src="{{ URL::asset('assets/js/pages/password-addon.init.js') }}"></script>

@endsection



