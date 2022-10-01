<!DOCTYPE html>
<html class="no-js" lang="en">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="x-ua-compatible" content="ie=edge" />
		<link rel="icon" type="image/x-icon" href="{{ asset('images/icon/IPB.png') }}">
		<title>SV | SIM Ujian</title>
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link
			rel="shortcut icon"
			type="image/png"
			href="{{ asset('images/icon/favicon.ico') }}"
		/>
		<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
		<link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}" />
		<link rel="stylesheet" href="{{ asset('css/themify-icons.css') }}" />
		<link rel="stylesheet" href="{{ asset('css/metisMenu.css') }}" />
		<link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}" />
		<link rel="stylesheet" href="{{ asset('css/slicknav.min.css') }}" />
		<!-- amchart css -->
		<link
			rel="stylesheet"
			href="https://www.amcharts.com/lib/3/plugins/export/export.css"
			type="text/css"
			media="all"
		/>
		<!-- others css -->
		<link rel="stylesheet" href="{{ asset('css/typography.css') }}" />
		<link rel="stylesheet" href="{{ asset('css/default-css.css') }}" />
		<link rel="stylesheet" href="{{ asset('css/styles.css') }}" />
		<link rel="stylesheet" href="{{ asset('css/responsive.css') }}" />
		<!-- modernizr css -->
		<script src="{{ asset('js/vendor/modernizr-2.8.3.min.js') }})"></script>
	</head>

	<body>
		<!--[if lt IE 8]>
			<p class="browserupgrade">
				You are using an <strong>outdated</strong> browser. Please
				<a href="http://browsehappy.com/">upgrade your browser</a> to improve
				your experience.
			</p>
		<![endif]-->
		<!-- preloader area start -->
		<div id="preloader">
			<div class="loader"></div>
		</div>
		<!-- preloader area end -->
		<!-- login area start -->
		<div class="login-area login-s2">
			<div class="container">
				<div class="login-box ptb--100">
					<form class="bg-transparent" action="/login" method="POST">
                        @csrf
						<div class="d-flex justify-content-center mb-5">
							<img src="{{ asset('images/icon/SV_IPB.png') }}" alt="" width="65%">
						</div>

						<div class="login-form-head">
							<p style="font-size: 20px;">Management Information for<br>Examination Administration System<br>Sekolah Vokasi IPB</p>
							<p></p>
						</div>

						@if (session()->has('loginError'))
							<div class="alert alert-danger alert-dismissible fade show" role="alert">
								{{ session('loginError') }}
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							</div>
						@endif

						@if (session()->has('success'))
                            <div class="alert alert-success show" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

						<div class="login-form-body">
							<div class="form-gp">
								<label for="email">Email</label>
								<input type="text" @error('email')
									is-invalid
								@enderror name="email" id="email" required value="{{ old('email')}}"/>
								@error('email')
									<div class="invalid-feedback">
										{{ $message }}
									</div>
								@enderror
								<!-- <i class="ti-user"></i> -->
								<img
									class="user-thumb"
									src="{{ asset('images/author/user.png') }}"
									alt="avatar"
									width="20px"
								/>
								<div class="text-danger"></div>
							</div>
							<div class="form-gp">
								<label for="password">Password</label>
								<input type="password" name="password" id="password" required/>
								<!-- <i class="ti-lock"></i> -->
								<img
									class="user-thumb"
									src="{{ asset('images/icon/lock.png') }}"
									alt="avatar"
									width="20px"
								/>
								<div class="text-danger"></div>
							</div>
	
							<div class="submit-btn-area mb-3">
								<button id="form_submit" type="submit">
									Sign In <i class="ti-arrow-right"></i>
								</button>
							</div>

							<div class="submit-btn-area">
								<a href="/forgotPassword">Forgot Password ?</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<!-- login area end -->

		<!-- jquery latest version -->
		<script src="{{ asset('js/vendor/jquery-2.2.4.min.js') }}"></script>
		<!-- bootstrap 4 js -->
		<script src="{{ asset('js/popper.min.js') }}"></script>
		<script src="{{ asset('js/bootstrap.min.js') }}"></script>
		<script src="{{ asset('js/owl.carousel.min.js') }}"></script>
		<script src="{{ asset('js/metisMenu.min.js') }}"></script>
		<script src="{{ asset('js/jquery.slimscroll.min.js') }}"></script>
		<script src="{{ asset('js/jquery.slicknav.min.js') }}"></script>

		<!-- others plugins -->
		<script src="{{ asset('js/plugins.js') }}"></script>
		<script src="{{ asset('js/scripts.js') }}"></script>
	</body>
</html>
