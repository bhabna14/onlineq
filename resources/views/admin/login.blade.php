<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Admin Login | {{ config('app.name') }}</title>

	<!-- Global stylesheets -->
	<link href="{{ asset('/assets') }}/admin/fonts/inter/inter.css" rel="stylesheet" type="text/css">
	<link href="{{ asset('/assets') }}/admin/icons/phosphor/styles.min.css" rel="stylesheet" type="text/css">
	<link href="{{ asset('/assets') }}/admin/css/ltr/all.min.css" id="stylesheet" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script src="{{ asset('/assets') }}/admin/demo/demo_configurator.js"></script>
	<script src="{{ asset('/assets') }}/admin/js/bootstrap/bootstrap.bundle.min.js"></script>
	<!-- /core JS files -->

</head>

<body class="bg-dark">

	<!-- Page content -->
	<div class="page-content">

		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Inner content -->
			<div class="content-inner">

				<!-- Content area -->
				<div class="content d-flex justify-content-center align-items-center">

					<!-- Login form -->
					<form class="login-form" action="{{ route('admin.login.post') }}" method="POST">
                        @csrf
						<div class="card mb-0">
							<div class="card-body">
								<div class="text-center mb-3">
									<div class="d-inline-flex align-items-center justify-content-center mb-4 mt-2">
										<img src="{{ asset('/assets') }}/images/flag.gif" class="h-48px" alt="">
										<img src="{{ asset('/assets') }}/images/sjs-new-logo.gif" class="h-48px" alt="">
									</div>
									<h5 class="mb-0">Login to your account</h5>
									<span class="d-block text-muted">Enter your credentials below</span>
								</div>

								<div class="mb-3">
									<label class="form-label">Email</label>
									<div class="form-control-feedback form-control-feedback-start">
										<input name="email" type="email" class="form-control" placeholder="Enter your email" value="{{ old('email') }}">
										<div class="form-control-feedback-icon">
											<i class="ph-user-circle text-muted"></i>
										</div>
                                        @error('email')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
									</div>
								</div>

								<div class="mb-3">
									<label class="form-label">Password</label>
									<div class="form-control-feedback form-control-feedback-start">
										<input name="password" type="password" class="form-control" placeholder="Enter your password" value="{{ old('password') }}">
										<div class="form-control-feedback-icon">
											<i class="ph-lock text-muted"></i>
										</div>
                                        @error('password')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
									</div>
								</div>

								<div class="mb-3">
									<button type="submit" class="btn btn-primary w-100">Sign in</button>
								</div>
							</div>
						</div>
					</form>
					<!-- /login form -->

				</div>
				<!-- /content area -->

			</div>
			<!-- /inner content -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->

	<!-- Theme JS files -->
	<script src="{{ asset('/assets') }}/admin/js/app.js"></script>
	<!-- /theme JS files -->

</body>
</html>
