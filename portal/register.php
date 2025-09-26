<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Join Ecommerce Shop - Your premier shopping destination with exclusive member benefits and amazing products.">
	<meta name="keywords" content="ecommerce, shopping, online store, register, sign up, products">
	<meta name="author" content="Ecommerce Shop">
	<link rel="shortcut icon" href="../assets/img/logo.png">
	<link rel="apple-touch-icon" href="../assets/img/logo.png">

	<title>Sign Up - Ecommerce Shop</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/toastr.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" href="css/sweetalert2.min.css">

	<link rel="stylesheet" href="css/intlTelInput.min.css">

	<!-- Confetti Animation Library -->
	<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
	<style type="text/css">
		.iti {
			display: block
		}

		/* Phone input styling */
		.iti__flag-container {
			width: 100px !important;
			min-width: 100px !important;
			height: 100% !important;
		}

		.iti__selected-flag {
			padding: 0 10px !important;
			height: 100% !important;
			display: flex !important;
			align-items: center !important;
		}

		.iti__flag {
			width: 20px !important;
			height: 15px !important;
		}

		.iti__selected-dial-code {
			font-size: 14px !important;
			margin-right: 6px !important;
		}

		.iti input {
			padding-left: 108px !important;
		}

		/* Mobile phone input improvements */
		@media (max-width: 767.98px) {
			.iti {
				width: 100% !important;
			}

			.iti__flag-container {
				height: 100% !important;
				width: 90px !important;
				min-width: 90px !important;
			}

			.iti__selected-flag {
				padding: 0 8px !important;
				height: 100% !important;
				display: flex !important;
				align-items: center !important;
			}

			.iti__flag {
				width: 18px !important;
				height: 13px !important;
			}

			.iti input {
				padding-left: 98px !important;
			}

			.iti__country-list {
				max-height: 200px !important;
				width: 280px !important;
			}
		}
	</style>
	<script src="js/sweetalert2.all.min.js"></script>
	<style>
		:root {
			--inowey-primary: #419e66;
			--inowey-secondary: #419e66;
			--inowey-accent: #419e66;
			--inowey-light: #edf1fb;
			--inowey-dark: #419e66;
		}

		.btn-purple {
			background-color: var(--inowey-primary) !important;
			border-color: var(--inowey-primary) !important;
			color: white !important;
		}

		.btn-purple:hover {
			background-color: var(--inowey-accent) !important;
			border-color: var(--inowey-accent) !important;
			color: white !important;
		}

		.form-signin-heading {
			color: var(--inowey-primary) !important;
		}

		.text-muted a {
			color: var(--inowey-primary) !important;
		}

		.text-muted a:hover {
			color: var(--inowey-accent) !important;
		}

		/* Custom SweetAlert positioning for top-right corner */
		body.swal2-toast-shown .swal2-container.swal2-top-right {
			top: 1em !important;
			right: 1em !important;
		}

		.swal2-popup.swal2-toast.small-swal {
			font-size: 14px !important;
			border-radius: 8px !important;
			max-width: 350px !important;
			min-width: 250px !important;
			width: auto !important;
			word-wrap: break-word !important;
			white-space: normal !important;
		}

		.d-flex {
			align-items: stretch !important;
			min-height: 100vh !important;
		}

		/* Mobile Responsive Fixes */
		.register-container {
			min-height: 100vh;
		}

		/* Confetti Canvas */
		#confetti-canvas {
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			pointer-events: none;
			z-index: 9999;
		}

		/* Password Strength Indicator */
		.password-strength .progress {
			background-color: #e9ecef;
			border-radius: 3px;
		}

		.password-strength .progress-bar {
			transition: width 0.3s ease, background-color 0.3s ease;
		}

		.password-strength .progress-bar.weak {
			background-color: #dc3545;
		}

		.password-strength .progress-bar.medium {
			background-color: #ffc107;
		}

		.password-strength .progress-bar.strong {
			background-color: #28a745;
		}

		.password-strength .progress-bar.very-strong {
			background-color: #20c997;
		}

		/* Compact helper text */
		.password-strength small {
			font-size: 0.75rem;
			line-height: 1.2;
			margin-top: 0.25rem !important;
		}

		/* Success Animation */
		@keyframes successPulse {
			0% {
				transform: scale(1);
			}

			50% {
				transform: scale(1.05);
			}

			100% {
				transform: scale(1);
			}
		}

		@keyframes successShake {

			0%,
			100% {
				transform: translateX(0);
			}

			10%,
			30%,
			50%,
			70%,
			90% {
				transform: translateX(-2px);
			}

			20%,
			40%,
			60%,
			80% {
				transform: translateX(2px);
			}
		}

		.success-animation {
			animation: successPulse 0.6s ease-in-out, successShake 0.6s ease-in-out;
		}

		/* Enhanced button feedback */
		.btn-purple:active {
			transform: scale(0.98);
			transition: transform 0.1s ease;
		}



		/* Override for mobile to allow scrolling */
		@media (max-width: 767.98px) {

			html,
			body {
				height: auto !important;
				min-height: 100vh;
				overflow-x: hidden;
				overflow-y: auto;
				position: relative;
			}

			.d-flex {
				min-height: auto !important;
				height: auto !important;
				align-items: stretch !important;
				position: relative;
			}

			/* Ensure form elements don't get cut off */
			.form-control:focus {
				z-index: 1;
				position: relative;
			}

			/* Improve touch targets on mobile */
			.form-control,
			.btn {
				min-height: 44px;
			}

			/* Ensure proper spacing for form labels */
			.form-label {
				margin-bottom: 0.3rem !important;
				font-size: 0.9rem !important;
			}

			/* Better spacing for form groups */
			.form-group {
				position: relative;
			}
		}

		.form-column {
			display: flex;
			align-items: center;
			justify-content: center;
			padding: 20px;
			min-height: 100vh;
		}

		.brand-column {
			background: linear-gradient(135deg, var(--inowey-primary) 0%, var(--inowey-accent) 100%);
			display: flex;
			align-items: center;
			justify-content: center;
			position: relative;
			overflow: hidden;
			min-height: 100vh;
		}

		/* Mobile Styles */
		@media (max-width: 767.98px) {
			.register-container {
				flex-direction: column !important;
				min-height: auto !important;
				height: auto !important;
				padding-bottom: 50px !important;
			}

			.brand-column {
				min-height: 30vh !important;
				max-height: 30vh;
				order: 1;
			}

			.form-column {
				min-height: auto !important;
				max-height: none !important;
				height: auto !important;
				order: 2;
				padding: 20px 15px 100px 15px !important;
				align-items: flex-start !important;
				display: block !important;
				overflow-y: auto !important;
			}

			.form-column .container-fluid {
				max-width: 600px !important;
				margin: 0 auto !important;
				padding: 0 15px !important;
			}

			.form-column form {
				max-width: 100% !important;
				margin-bottom: 30px !important;
			}

			.brand-content {
				width: 90% !important;
				max-width: 400px;
				margin-top: 15px !important;
			}

			.brand-content h1 {
				font-size: 1.3rem !important;
				margin-bottom: 5px !important;
			}

			.brand-content p {
				font-size: 0.75rem !important;
				margin-bottom: 6px !important;
			}

			.brand-content hr {
				margin: 6px 0 !important;
			}

			.brand-content div {
				margin-top: 8px !important;
			}

			.form-signin-heading {
				font-size: 1.2rem !important;
				text-align: center;
				margin-bottom: 12px !important;
			}

			.form-column .container-fluid {
				padding: 0 !important;
				width: 100%;
			}

			.form-column form {
				width: 100%;
				max-width: 100%;
				margin: 0;
			}

			.row {
				margin: 0 !important;
				margin-bottom: 8px !important;
			}

			.col-sm-6 {
				padding: 0 3px !important;
				margin-bottom: 12px;
				flex: 0 0 100% !important;
				max-width: 100% !important;
			}

			.form-group {
				margin-bottom: 12px !important;
			}

			.form-control {
				padding: 8px 10px;
				font-size: 14px;
				height: auto;
			}

			.password-strength {
				margin-top: 5px !important;
			}

			.password-strength .progress {
				height: 4px !important;
			}

			.password-strength small {
				font-size: 0.7rem !important;
				line-height: 1.1 !important;
			}

			.btn-purple {
				padding: 12px 20px;
				font-size: 16px;
				margin-top: 15px !important;
				margin-bottom: 20px !important;
				width: 100% !important;
			}

			.text-muted {
				font-size: 12px !important;
				margin-bottom: 15px !important;
				text-align: center;
				line-height: 1.3 !important;
			}

			/* Ensure footer text is visible */
			.text-center.text-muted.mt-4 {
				margin-top: 20px !important;
				margin-bottom: 30px !important;
				padding-bottom: 20px !important;
				position: relative;
				z-index: 1;
				display: block !important;
				visibility: visible !important;
				opacity: 1 !important;
			}

			/* Force footer to be visible */
			.text-muted {
				display: block !important;
				visibility: visible !important;
				opacity: 1 !important;
				position: relative !important;
				z-index: 10 !important;
			}

			/* Ensure footer container is visible */
			.form-column .container-fluid {
				position: relative !important;
				min-height: auto !important;
				overflow: visible !important;
			}

			/* Debug footer positioning */
			.text-center.text-muted.mt-4 {
				margin: 20px 0 30px 0 !important;
			}

			/* Ensure form is scrollable on very small screens */
			@media (max-height: 600px) {
				.form-column {
					padding-bottom: 120px !important;
				}

				.register-container {
					padding-bottom: 140px !important;
				}
			}

			/* Extra small devices */
			@media (max-width: 480px) {
				.form-column {
					padding: 15px 10px 90px 10px !important;
				}

				.form-column .container-fluid {
					padding: 0 10px !important;
				}

				.form-signin-heading {
					font-size: 1.1rem !important;
					margin-bottom: 10px !important;
				}

				.form-control {
					padding: 8px 8px;
					font-size: 13px;
				}

				.btn-purple {
					padding: 10px 16px;
					font-size: 15px;
				}

				.text-muted {
					font-size: 11px !important;
				}

				/* Ensure form is fully visible */
				form {
					margin-bottom: 60px !important;
				}

				/* Better spacing for very small screens */
				.form-group {
					margin-bottom: 10px !important;
				}

				.row {
					margin-bottom: 6px !important;
				}
			}

			/* Landscape orientation fixes */
			@media (max-width: 767.98px) and (orientation: landscape) {
				.brand-column {
					min-height: 25vh !important;
					max-height: 25vh;
				}

				.form-column {
					padding: 15px 15px 60px 15px !important;
				}

				.form-signin-heading {
					font-size: 1.1rem !important;
					margin-bottom: 8px !important;
				}

				.form-group {
					margin-bottom: 8px !important;
				}

				.btn-purple {
					margin-top: 10px !important;
					margin-bottom: 15px !important;
				}

				/* Ensure footer is visible in landscape */
				.text-center.text-muted.mt-4 {
					margin-top: 15px !important;
					margin-bottom: 25px !important;
					padding-bottom: 15px !important;
				}
			}
		}

		/* Tablet Styles */
		@media (min-width: 768px) and (max-width: 991.98px) {
			.brand-content {
				width: 80% !important;
			}

			.form-column {
				padding: 30px;
			}
		}

		/* Desktop Styles */
		@media (min-width: 992px) {
			.brand-content {
				width: 300px;
			}
		}

		/* Progress Bar Styles */
		.rp-progress-container {
			margin-bottom: 2rem;
			text-align: center;
		}

		.rp-progress-bar {
			width: 100%;
			height: 8px;
			background: rgba(0, 104, 217, 0.2);
			border-radius: 4px;
			overflow: hidden;
			margin-bottom: 0.5rem;
		}

		.rp-progress-fill {
			height: 100%;
			background: linear-gradient(90deg, var(--inowey-primary), var(--inowey-secondary));
			transition: width 0.3s ease;
			width: 25%;
		}

		.rp-progress-text {
			font-size: 0.9rem;
			color: #666;
			font-weight: 500;
		}

		/* Social Login Styles */
		.rp-social {
			margin-bottom: 1.5rem;
		}

		.rp-social-btn {
			display: flex;
			align-items: center;
			justify-content: center;
			gap: 0.75rem;
			width: 100%;
			padding: 0.75rem 1rem;
			border: 2px solid #e0e0e0;
			border-radius: 8px;
			background: white;
			color: #333;
			text-decoration: none;
			font-weight: 500;
			transition: all 0.3s ease;
			margin-bottom: 1rem;
		}

		.rp-social-btn:hover {
			background: #f8f9fa;
			border-color: #ccc;
			transform: translateY(-1px);
		}

		.rp-social-btn.google-btn {
			border-color: #4285F4;
			color: #4285F4;
		}

		.rp-social-btn.google-btn:hover {
			background: #4285F4;
			color: white;
			border-color: #4285F4;
		}

		.rp-divider {
			text-align: center;
			margin: 1.5rem 0;
			position: relative;
		}

		.rp-divider::before {
			content: '';
			position: absolute;
			top: 50%;
			left: 0;
			right: 0;
			height: 1px;
			background: #e0e0e0;
		}

		.rp-divider span {
			background: white;
			padding: 0 1rem;
			color: #666;
			font-size: 0.9rem;
		}

		/* Step Content Styles */
		.rp-step-content {
			animation: fadeIn 0.3s ease-in-out;
		}

		@keyframes fadeIn {
			from {
				opacity: 0;
				transform: translateY(10px);
			}

			to {
				opacity: 1;
				transform: translateY(0);
			}
		}

		.rp-step-actions {
			display: flex;
			justify-content: space-between;
			margin-top: 2rem;
			gap: 1rem;
		}

		.rp-prev-btn,
		.rp-next-btn,
		.rp-submit {
			padding: 0.75rem 1.5rem;
			border: none;
			border-radius: 8px;
			font-weight: 500;
			cursor: pointer;
			transition: all 0.3s ease;
			flex: 1;
		}

		.rp-prev-btn {
			background: #f8f9fa;
			color: #666;
			border: 2px solid #e0e0e0;
		}

		.rp-prev-btn:hover {
			background: #e9ecef;
		}

		.rp-next-btn,
		.rp-submit {
			background: linear-gradient(135deg, var(--inowey-primary), var(--inowey-secondary));
			color: white;
		}

		.rp-next-btn:hover,
		.rp-submit:hover {
			transform: translateY(-1px);
		}

		/* File Upload Styles */
		.rp-file-upload {
			position: relative;
		}

		.rp-file-upload input[type="file"] {
			position: absolute;
			opacity: 0;
			width: 100%;
			height: 100%;
			cursor: pointer;
		}

		.rp-file-preview {
			border: 2px dashed #e0e0e0;
			border-radius: 8px;
			padding: 2rem;
			text-align: center;
			background: #f8f9fa;
			transition: all 0.3s ease;
			cursor: pointer;
		}

		.rp-file-preview:hover {
			border-color: var(--inowey-primary);
			background: #f0f7ff;
		}

		.rp-file-preview.has-image {
			border-style: solid;
			padding: 1rem;
		}

		.rp-file-preview.has-image img {
			max-width: 100%;
			max-height: 150px;
			border-radius: 8px;
		}

		.rp-file-preview i {
			font-size: 2rem;
			color: #ccc;
			margin-bottom: 0.5rem;
		}

		.rp-file-preview span {
			display: block;
			color: #666;
			font-size: 0.9rem;
		}

		/* Password Input Styles */
		.rp-password-input {
			position: relative;
		}

		.rp-password-toggle {
			position: absolute;
			right: 0.75rem;
			top: 50%;
			transform: translateY(-50%);
			background: none;
			border: none;
			color: #666;
			cursor: pointer;
			padding: 0.25rem;
		}

		.rp-password-toggle:hover {
			color: var(--inowey-primary);
		}

		.rp-password-input input {
			padding-right: 2.5rem;
		}

		/* Password Strength Styles */
		.rp-password-strength {
			margin-top: 0.5rem;
		}

		.rp-strength-bar {
			height: 4px;
			background: #e0e0e0;
			border-radius: 2px;
			overflow: hidden;
		}

		.rp-strength-fill {
			height: 100%;
			transition: all 0.3s ease;
			border-radius: 2px;
		}

		.rp-strength-fill.weak {
			background: #f44336;
			width: 25%;
		}

		.rp-strength-fill.fair {
			background: #ff9800;
			width: 50%;
		}

		.rp-strength-fill.good {
			background: #ffc107;
			width: 75%;
		}

		.rp-strength-fill.strong {
			background: #4caf50;
			width: 100%;
		}

		.rp-strength-text {
			font-size: 0.8rem;
			color: #666;
			margin-top: 0.25rem;
			display: block;
		}

		/* Password Requirements Styles */
		.rp-password-requirements {
			margin-top: 1rem;
			padding: 1rem;
			background: #f8f9fa;
			border-radius: 8px;
			border-left: 4px solid #e0e0e0;
		}

		.rp-requirement {
			display: flex;
			align-items: center;
			margin-bottom: 0.5rem;
			font-size: 0.85rem;
			color: #666;
		}

		.rp-requirement:last-child {
			margin-bottom: 0;
		}

		.rp-requirement i {
			margin-right: 0.5rem;
			font-size: 0.7rem;
		}

		.rp-requirement.valid {
			color: #4caf50;
		}

		.rp-requirement.valid i {
			color: #4caf50;
		}

		/* Email Check Styles */
		.rp-email-check {
			margin-top: 0.25rem;
			font-size: 0.85rem;
			min-height: 1.2rem;
			display: flex;
			align-items: center;
			gap: 0.5rem;
		}

		.rp-email-check.checking {
			color: #ff9800;
		}

		.rp-email-check.available {
			color: #4caf50;
		}

		.rp-email-check.taken {
			color: #f44336;
		}

		.rp-email-check i {
			font-size: 0.8rem;
		}

		/* Summary Styles */
		.rp-summary {
			background: #f8f9fa;
			border-radius: 8px;
			padding: 1.5rem;
			margin-bottom: 1.5rem;
		}

		.rp-summary-item {
			display: flex;
			justify-content: space-between;
			margin-bottom: 0.75rem;
			padding-bottom: 0.75rem;
			border-bottom: 1px solid #e0e0e0;
		}

		.rp-summary-item:last-child {
			margin-bottom: 0;
			padding-bottom: 0;
			border-bottom: none;
		}

		.rp-summary-label {
			font-weight: 500;
			color: #666;
		}

		.rp-summary-value {
			color: #333;
			text-align: right;
		}

		/* Mobile Responsive */
		@media (max-width: 768px) {
			.rp-step-actions {
				flex-direction: column;
			}

			.rp-prev-btn,
			.rp-next-btn,
			.rp-submit {
				width: 100%;
			}

			.rp-social-btn {
				padding: 0.5rem 1rem;
				font-size: 0.9rem;
			}

			.rp-file-preview {
				padding: 1.5rem;
			}

			.rp-summary {
				padding: 1rem;
			}

			.rp-summary-item {
				flex-direction: column;
				gap: 0.25rem;
			}

			.rp-summary-value {
				text-align: left;
			}
		}
	</style>
</head>

<body>
	<!-- Confetti Canvas -->
	<canvas id="confetti-canvas"></canvas>

	<div class="d-flex register-container">
		<div class="col-md-8 col-lg-8 form-column">
			<div class="container-fluid">
				<!-- Progress Indicator -->
				<div class="rp-progress-container">
					<div class="rp-progress-bar">
						<div class="rp-progress-fill" id="progressFill"></div>
					</div>
					<div class="rp-progress-text" id="progressText">Step 1 of 4</div>
				</div>

				<!-- Social Login -->
				<div class="rp-social">
					<a href="../oauth/google-login.php" class="rp-social-btn google-btn" aria-label="Sign up with Google">
						<i class="fab fa-google"></i>
						<span>Continue with Google</span>
					</a>
				</div>

				<div class="rp-divider">
					<span>or register with email</span>
				</div>

				<form style="margin-top: -10px;" action="code.php" id="register_form" method="post" accept-charset="utf-8" enctype="multipart/form-data">
					<input type="hidden" name="register_btn" value="1">
					<h3 class="form-signin-heading" style="color: var(--goprimehost-primary); font-size: 1.7em">Sign Up</h3>
					<p style="margin-bottom: 25px;" class="text-muted">Create your account to access our ecommerce platform and start shopping.</p>

					<!-- Step 1: Personal Information -->
					<div class="rp-step-content" data-step="1">
						<div class="row">
							<div class="form-group col-sm-6">
								<label for="first_name" class="form-label required">First Name </label>
								<input type="text" name="first_name" value="" class="form-control" id="first_name" placeholder="Enter your first name" required="">
							</div>
							<div class="form-group col-sm-6">
								<label for="last_name" class="form-label required">Last Name </label>
								<input type="text" name="last_name" value="" class="form-control" id="last_name" placeholder="Enter your last name" required="">
							</div>
						</div>

						<div class="row">
							<div class="form-group col-sm-12">
								<label for="profile_picture">Profile Picture</label>
								<div class="rp-file-upload">
									<input type="file" name="profile_picture" id="profile_picture" accept="image/*">
									<div class="rp-file-preview" id="filePreview">
										<i class="fas fa-user-circle"></i>
										<span>Click to upload or drag and drop</span>
									</div>
								</div>
							</div>
						</div>

						<div class="rp-step-actions">
							<button type="button" class="rp-next-btn" onclick="nextStep(1)">Next Step</button>
						</div>
					</div>

					<!-- Step 2: Contact Details -->
					<div class="rp-step-content" data-step="2" style="display: none;">
						<div class="row">
							<div class="form-group col-sm-6">
								<label for="phone_input" class="form-label required">Phone Number </label>
								<input type="text" name="phone_number" value="" id="phone_input" class="form-control" placeholder="Enter your phone" required="">
								<input type="hidden" name="full_phone" id="full_phone">
							</div>
							<div class="form-group col-sm-6">
								<label for="email_address" class="form-label required">Email Address </label>
								<input type="text" name="email_address" value="" id="email_address" class="form-control" placeholder="Enter your Email Address" required="">
								<div class="rp-email-check" id="email_check">
									<i class="fas fa-spinner fa-spin" id="email_spinner" style="display: none;"></i>
									<span id="email_status"></span>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="form-group col-sm-4">
								<label for="street_address" class="form-label required">Street Address </label>
								<input type="text" name="street_address" value="" id="street_address" class="form-control" placeholder="Enter your street address" required="">
							</div>
							<div class="form-group col-sm-4">
								<label for="city" class="form-label required">City </label>
								<input type="text" name="city" value="" id="city" class="form-control" placeholder="Enter your city" required="">
							</div>
							<div class="form-group col-sm-4">
								<label for="postal_code" class="form-label required">Postal Code </label>
								<input type="text" name="postal_code" value="" id="postal_code" class="form-control" placeholder="Enter your postal code" required="">
							</div>
						</div>


						<div class="rp-step-actions">
							<button type="button" class="rp-prev-btn" onclick="prevStep(2)">Previous</button>
							<button type="button" class="rp-next-btn" onclick="nextStep(2)">Next Step</button>
						</div>
					</div>

					<!-- Step 3: Security -->
					<div class="rp-step-content" data-step="3" style="display: none;">

						<div class="row">
							<div class="form-group col-sm-6">
								<label for="password" class="form-label required">Password </label>
								<div class="rp-password-input">
									<input type="password" name="password" value="" size="20" id="password" placeholder="Enter your password" class="form-control" required="" autocomplete="nop">
									<button type="button" class="rp-password-toggle" id="passwordToggle">
										<i class="fas fa-eye"></i>
									</button>
								</div>
								<div class="rp-password-strength" id="passwordStrength">
									<div class="rp-strength-bar">
										<div class="rp-strength-fill" id="strengthFill"></div>
									</div>
									<span class="rp-strength-text" id="strengthText">Password strength</span>
								</div>
								<div class="rp-password-requirements">
									<div class="rp-requirement" id="req-length"><i class="fas fa-circle"></i> At least 8 characters</div>
									<div class="rp-requirement" id="req-lowercase"><i class="fas fa-circle"></i> One lowercase letter</div>
									<div class="rp-requirement" id="req-uppercase"><i class="fas fa-circle"></i> One uppercase letter</div>
									<div class="rp-requirement" id="req-number"><i class="fas fa-circle"></i> One number</div>
									<div class="rp-requirement" id="req-special"><i class="fas fa-circle"></i> One special character</div>
								</div>
							</div>
							<div class="form-group col-sm-6">
								<label for="confirm_password" class="form-label required">Confirm Password </label>
								<div class="rp-password-input">
									<input type="password" name="confirm_password" value="" size="20" id="confirm_password" placeholder="Confirm your password" class="form-control" required="" autocomplete="nop">
									<button type="button" class="rp-password-toggle" id="confirmPasswordToggle">
										<i class="fas fa-eye"></i>
									</button>
								</div>
							</div>
						</div>

						<div class="rp-step-actions">
							<button type="button" class="rp-prev-btn" onclick="prevStep(3)">Previous</button>
							<button type="button" class="rp-next-btn" onclick="nextStep(3)">Next Step</button>
						</div>
					</div>

					<!-- Step 4: Review & Submit -->
					<div class="rp-step-content" data-step="4" style="display: none;">
						<h3>Review Your Information</h3>
						<div class="rp-summary">
							<div class="rp-summary-item">
								<span class="rp-summary-label">Name:</span>
								<span class="rp-summary-value" id="summary-name"></span>
							</div>
							<div class="rp-summary-item">
								<span class="rp-summary-label">Email:</span>
								<span class="rp-summary-value" id="summary-email"></span>
							</div>
							<div class="rp-summary-item">
								<span class="rp-summary-label">Phone:</span>
								<span class="rp-summary-value" id="summary-phone"></span>
							</div>
							<div class="rp-summary-item">
								<span class="rp-summary-label">Address:</span>
								<span class="rp-summary-value" id="summary-address"></span>
							</div>
						</div>

						<div class="row">
							<div class="form-group col-sm-12">
								<div class="form-check">
									<input type="checkbox" name="agreed_to_terms" id="agreed_to_terms" class="form-check-input" required="">
									<label for="agreed_to_terms" class="form-check-label">
										I agree to the <a href="../terms.php" target="_blank">Terms & Conditions</a> and <a href="../privacy.php" target="_blank">Privacy Policy</a> *
									</label>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="form-group col-sm-12">
								<div class="form-check">
									<input type="checkbox" name="newsletter" id="newsletter" class="form-check-input">
									<label for="newsletter" class="form-check-label">
										Subscribe to our newsletter for exclusive offers and updates
									</label>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="form-group col-sm-12">
								<div class="form-check">
									<input type="checkbox" name="email_verification" id="emailVerificationCheckbox" class="form-check-input" checked>
									<label for="emailVerificationCheckbox" class="form-check-label">
										Send me a verification email to confirm my account
									</label>
								</div>
							</div>
						</div>

						<div class="rp-step-actions">
							<button type="button" class="rp-prev-btn" onclick="prevStep(4)">Previous</button>
							<button type="submit" id="registerButton" class="rp-submit">Get Started Now <span class="fi fi sr-arrow-right"></span></button>
						</div>
					</div>
				</form>

				<div class="text-center text-muted mt-4" style="font-size: 12.5px; margin-bottom: 20px;"> GoprimeHost Ke 2025 • Powered by <a style="color: var(--inowey-primary)" href="https://www.goprimehost.com" target="_blank">GoprimeHost Ke</a></div>
			</div>
		</div>

		<div class="col-md-4 col-lg-4 brand-column">
			<!-- Geometric Shapes -->
			<div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: rgba(255,255,255,0.2); border-radius: 50%; z-index: 1;"></div>
			<div style="position: absolute; bottom: -30px; left: -30px; width: 150px; height: 150px; background: rgba(255,255,255,0.15); transform: rotate(45deg); z-index: 1;"></div>
			<div style="position: absolute; top: 20%; left: 10%; width: 80px; height: 80px; background: rgba(255,255,255,0.12); border-radius: 20px; transform: rotate(30deg); z-index: 1;"></div>
			<div style="position: absolute; bottom: 30%; right: 15%; width: 60px; height: 60px; background: rgba(255,255,255,0.18); border-radius: 50%; z-index: 1;"></div>
			<div style="position: absolute; top: 50%; left: 5%; width: 40px; height: 40px; background: rgba(255,255,255,0.1); transform: rotate(60deg); z-index: 1;"></div>
			<div style="position: absolute; top: 60%; right: 8%; width: 100px; height: 100px; background: rgba(255,255,255,0.08); border-radius: 30px; transform: rotate(-20deg); z-index: 1;"></div>

			<div class="brand-content" style="position: absolute; z-index: 999; width: 300px; color: white; text-align: center;">
				<div style="margin-bottom: 20px;">
					<img src="../assets/img/logo.png" alt="Ecommerce Shop Logo" style="max-width: 120px; height: auto;">
				</div>
				<h1>Ecommerce Shop</h1>
				<p class="" style="margin-bottom: 4px">Your Shopping Portal</p>
				<hr style="opacity:.2">
				<p>Join our community and discover amazing products with exclusive member benefits.</p>
				<p>*
					<span style="font-weight: bold; color: var(--inowey-light);">
						Make More
					</span>
					
					<span style="font-weight: bold; color: #232f3e;">
						Online
					</span>
					<span style="font-weight: bold; color: var(--inowey-light);">
						For Less*
					</span>	
				</p>
				<div style="margin-top: 2em">
					<p>Already have an account?</p>
					<a class="btn btn-warning" href="login.php"> Login now → <span class="fi fi-sr-interactive"></span></a>
				</div>
			</div>

		</div>
	</div>

	<script src="js/jquery-2.1.1.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/toastr.min.js"></script>
	<script src="js/intlTelInput.min.js"></script>
	<script src="js/jquery.form.min.js"></script>
	<script src="js/jquery.validate.min.js"></script>
	<script src="js/common.js"></script>

	<script type="text/javascript">
		// Password Strength Functions
		function calculatePasswordStrength(password) {
			var score = 0;
			var feedback = [];

			// Length check
			if (password.length >= 8) score += 1;
			if (password.length >= 12) score += 1;
			if (password.length >= 16) score += 1;

			// Character variety checks
			if (/[a-z]/.test(password)) score += 1;
			if (/[A-Z]/.test(password)) score += 1;
			if (/\d/.test(password)) score += 1;
			if (/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password)) score += 1;

			// Bonus for mixed case and numbers
			if (/[a-z]/.test(password) && /[A-Z]/.test(password)) score += 1;
			if (/\d/.test(password) && /[a-zA-Z]/.test(password)) score += 1;

			// Penalty for common patterns
			if (/(.)\1{2,}/.test(password)) score -= 1; // Repeated characters
			if (/123|abc|qwe/i.test(password)) score -= 1; // Common sequences

			// Ensure minimum score
			score = Math.max(0, score);

			// Categorize strength
			if (score <= 2) return {
				level: 'weak',
				score: score,
				percentage: 25
			};
			if (score <= 4) return {
				level: 'medium',
				score: score,
				percentage: 50
			};
			if (score <= 6) return {
				level: 'strong',
				score: score,
				percentage: 75
			};
			return {
				level: 'very-strong',
				score: score,
				percentage: 100
			};
		}

		function updatePasswordStrengthIndicator(strength) {
			var progressBar = $('.password-strength .progress-bar');
			var progressContainer = $('.password-strength .progress');

			// Update progress bar
			progressBar.css('width', strength.percentage + '%');

			// Remove all strength classes
			progressBar.removeClass('weak medium strong very-strong');

			// Add appropriate strength class
			progressBar.addClass(strength.level);

			// Update text color based on strength
			var textColor = '';
			switch (strength.level) {
				case 'weak':
					textColor = '#dc3545';
					break;
				case 'medium':
					textColor = '#ffc107';
					break;
				case 'strong':
					textColor = '#28a745';
					break;
				case 'very-strong':
					textColor = '#20c997';
					break;
			}

			// Update helper text color
			$('.password-strength small').css('color', textColor);
		}

		// Haptic Feedback Function
		function triggerHapticFeedback() {
			// Check if vibration is supported
			if ('vibrate' in navigator) {
				// Create a celebration vibration pattern
				// Pattern: [vibrate, pause, vibrate, pause, vibrate, pause, long vibrate]
				const vibrationPattern = [200, 100, 200, 100, 200, 100, 500];
				navigator.vibrate(vibrationPattern);
			}

			// Fallback: Add visual feedback for devices without vibration
			// Add a subtle shake animation to the button
			const button = document.getElementById('registerButton');
			if (button) {
				button.classList.add('success-animation');
				setTimeout(() => {
					button.classList.remove('success-animation');
				}, 600);
			}
		}

		// Confetti Animation Function
		function triggerConfetti() {
			return new Promise((resolve) => {
				// Trigger haptic feedback immediately
				triggerHapticFeedback();

				// Create multiple confetti bursts
				const duration = 8000; // Extended to 8 seconds
				const animationEnd = Date.now() + duration;
				const defaults = {
					startVelocity: 30,
					spread: 360,
					ticks: 60,
					zIndex: 0
				};

				function randomInRange(min, max) {
					return Math.random() * (max - min) + min;
				}

				const interval = setInterval(function() {
					const timeLeft = animationEnd - Date.now();

					if (timeLeft <= 0) {
						clearInterval(interval);
						return;
					}

					const particleCount = 50 * (timeLeft / duration);

					// Create confetti from multiple angles
					confetti(Object.assign({}, defaults, {
						particleCount,
						origin: {
							x: randomInRange(0.1, 0.3),
							y: Math.random() - 0.2
						}
					}));
					confetti(Object.assign({}, defaults, {
						particleCount,
						origin: {
							x: randomInRange(0.7, 0.9),
							y: Math.random() - 0.2
						}
					}));
				}, 250);

				// Add a special burst effect
				setTimeout(() => {
					confetti({
						particleCount: 100,
						spread: 70,
						origin: {
							y: 0.6
						}
					});
					// Additional haptic feedback for the burst
					if ('vibrate' in navigator) {
						navigator.vibrate([150, 50, 150]);
					}
				}, 500);

				// Add fireworks effect
				setTimeout(() => {
					confetti({
						particleCount: 50,
						angle: 60,
						spread: 55,
						origin: {
							x: 0
						}
					});
					confetti({
						particleCount: 50,
						angle: 120,
						spread: 55,
						origin: {
							x: 1
						}
					});
					// Haptic feedback for fireworks
					if ('vibrate' in navigator) {
						navigator.vibrate([100, 50, 100, 50, 100]);
					}
				}, 1000);

				// Add more bursts for extended celebration
				setTimeout(() => {
					confetti({
						particleCount: 80,
						spread: 90,
						origin: {
							y: 0.8
						}
					});
				}, 2000);

				setTimeout(() => {
					confetti({
						particleCount: 60,
						angle: 45,
						spread: 65,
						origin: {
							x: 0.5
						}
					});
				}, 3000);

				// Final grand finale
				setTimeout(() => {
					confetti({
						particleCount: 150,
						spread: 120,
						origin: {
							y: 0.4
						}
					});
					// Grand finale haptic feedback
					if ('vibrate' in navigator) {
						navigator.vibrate([300, 100, 300, 100, 500]);
					}
				}, 4000);

				// Continuous celebration bursts
				setTimeout(() => {
					confetti({
						particleCount: 70,
						spread: 80,
						origin: {
							x: 0.2,
							y: 0.7
						}
					});
				}, 5000);

				setTimeout(() => {
					confetti({
						particleCount: 70,
						spread: 80,
						origin: {
							x: 0.8,
							y: 0.7
						}
					});
				}, 6000);

				// Final burst
				setTimeout(() => {
					confetti({
						particleCount: 200,
						spread: 180,
						origin: {
							y: 0.5
						}
					});
				}, 7000);

				// Resolve promise after animation completes
				setTimeout(() => {
					resolve();
				}, 8000);
			});
		}

		$(document).ready(function() {
			// Multi-step form management
			let currentStep = 1;
			const totalSteps = 4;

			// Step navigation functions
			window.nextStep = function(step) {
				if (validateStep(step)) {
					currentStep = step + 1;
					showStep(currentStep);
					updateProgress();
				}
			};

			window.prevStep = function(step) {
				currentStep = step - 1;
				showStep(currentStep);
				updateProgress();
			};

			function showStep(step) {
				$('.rp-step-content').hide();
				$(`[data-step="${step}"]`).show();
			}

			function updateProgress() {
				const progress = (currentStep / totalSteps) * 100;
				$('#progressFill').css('width', progress + '%');
				$('#progressText').text(`Step ${currentStep} of ${totalSteps}`);
			}

			function validateStep(step) {
				let isValid = true;

				if (step === 1) {
					if (!$('#first_name').val().trim() || !$('#last_name').val().trim()) {
						alert('Please fill in all required fields');
						isValid = false;
					}
				} else if (step === 2) {
					if (!$('#email_address').val().trim() || !$('#phone_input').val().trim()) {
						alert('Please fill in all required fields');
						isValid = false;
					}
				} else if (step === 3) {
					if (!$('#password').val() || $('#password').val() !== $('#confirm_password').val()) {
						alert('Please check your password');
						isValid = false;
					}
				}
				return isValid;
			}

			// Initialize first step
			showStep(1);
			updateProgress();

			var input = document.querySelector("#phone_input");
			var iti = window.intlTelInput(input, {
				autoPlaceholder: "aggressive",
				geoIpLookup: function(callback) {
					$.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
						var countryCode = (resp && resp.country) ? resp.country : "";
						callback(countryCode);
					});
				},
				nationalMode: true,
				preferredCountries: ['ke', 'ug', 'tz'],
				separateDialCode: true,
				utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/utils.js",
			});

			// Fix input width on page load to match the width after country selection
			setTimeout(function() {
				if (iti) {
					// Set consistent padding for the input
					if (window.innerWidth <= 767) {
						input.style.paddingLeft = '98px';
					} else {
						input.style.paddingLeft = '108px';
					}
				}
			}, 100);

			$.validator.addMethod("noSpace", function(value, element) {
				return value.indexOf(" ") < 0 && value != "";
			}, "Invalid characters, No spaces Allowed");

			// Removed customer type validation as it's not needed for ecommerce

			$.validator.addMethod("strongPassword", function(value, element) {
				// Password must contain at least:
				// - 8 characters minimum
				// - 1 uppercase letter
				// - 1 lowercase letter
				// - 1 number
				// - 1 special character
				var hasUpperCase = /[A-Z]/.test(value);
				var hasLowerCase = /[a-z]/.test(value);
				var hasNumbers = /\d/.test(value);
				var hasSpecialChar = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(value);

				return hasUpperCase && hasLowerCase && hasNumbers && hasSpecialChar;
			}, "Password must contain at least 8 characters with uppercase, lowercase, number, and special character");

			$.validator.addMethod("alphanumeric", function(value, element) {
				return /^[a-zA-Z0-9]+$/i.test(value);
			}, "Only letters and digital allowed.");

			$.validator.addMethod("isValidPhoneNumber", function(value, element, requiredValue) {
				// First check: must contain only valid phone characters
				var validPhonePattern = /^[\d\s\-\(\)\+]+$/;
				if (!validPhonePattern.test(value)) {
					return false;
				}

				// Use intl-tel-input for international phone validation
				try {
					if (iti && typeof iti.isValidNumber === 'function') {
						// Check if the number is valid according to intl-tel-input
						var isValid = iti.isValidNumber();

						// If intl-tel-input says it's valid, accept it
						if (isValid) {
							return true;
						}
					}
				} catch (e) {
					// Fall back to basic validation if intl-tel-input fails
				}

				// Fallback validation: basic international phone number format
				var digitsOnly = value.replace(/\D/g, '');

				// International phone numbers should have 7-15 digits
				if (digitsOnly.length >= 7 && digitsOnly.length <= 15) {
					// Basic pattern check: should not start with 0 if it's international format
					if (value.includes('+') && digitsOnly.startsWith('0')) {
						return false;
					}
					return true;
				}

				return false;
			}, "Please enter a valid phone number (only digits, spaces, hyphens, parentheses, and + allowed)!");



			$.validator.addMethod("isEmailAvailable", function(value, element, requiredValue) {
				var message = "false"; // Default to false (taken) for safety
				$.ajax({
					url: "code.php",
					method: "POST",
					data: {
						check_email: value
					},
					success: function(response) {
						message = response.trim(); // Trim whitespace
					},
					error: function(xhr, status, error) {
						message = "false"; // If AJAX fails, assume taken
					},
					async: false,
				})
				return (message === "true");
			}, "Email is Taken!");

			$.validator.addMethod("isPhoneNumberAvailable", function(value, element, requiredValue) {
				var message = "false"; // Default to false (taken) for safety
				var formattedPhone = value; // Start with raw value

				// Try to get formatted phone number, but don't fail if it doesn't work
				try {
					if (iti && typeof iti.getNumber === 'function') {
						var intlFormatted = iti.getNumber();
						if (intlFormatted && intlFormatted !== "") {
							formattedPhone = intlFormatted;
						}
					}
				} catch (e) {
					// If there's an error with phone formatting, use raw value
				}

				$.ajax({
					url: "code.php",
					method: "POST",
					data: {
						check_phone: formattedPhone
					},
					success: function(response) {
						message = response.trim(); // Trim whitespace
					},
					error: function(xhr, status, error) {
						message = "false"; // If AJAX fails, assume taken
					},
					async: false,
				})
				return (message === "true");
			}, "Phone number is Taken!");

			var register_settings = {
				submitHandler: function(form) {
					$("#registerButton").prop("disabled", true).html("Please wait...");

					var formData = $(form).serialize();

					$.ajax({
						url: 'code.php',
						method: 'POST',
						data: formData,
						dataType: 'json',
						success: function(response) {
							if (response.success) {
								// Show success message first
								Swal.fire({
									position: 'top-end',
									icon: 'success',
									title: response.message,
									showConfirmButton: false,
									timer: 8500, // Extended to match confetti duration
									toast: true,
									width: 'auto',
									padding: '0.1em',
									background: 'white',
									customClass: {
										popup: 'small-swal'
									}
								});

								// Trigger confetti animation and wait for it to complete
								triggerConfetti().then(() => {
									// Wait a bit more for confetti particles to settle
									setTimeout(() => {
										window.location.href = "login.php";
									}, 2000); // 2 seconds after confetti finishes
								});
							} else {
								Swal.fire({
									position: 'top-end',
									icon: 'error',
									title: response.message,
									showConfirmButton: false,
									timer: 2000,
									toast: true,
									width: 'auto',
									padding: '0.1em',
									background: 'white',
									customClass: {
										popup: 'small-swal'
									}
								});
							}
							$("#registerButton").prop("disabled", false).html("Get Started Now <span class=\"fi fi sr-arrow-right\"></span>");
						},
						error: function(xhr, status, error) {
							// Try to parse response as JSON for better error handling
							var errorMessage = 'Registration failed. Please try again.';
							try {
								var response = JSON.parse(xhr.responseText);
								if (response.message) {
									errorMessage = response.message;
								}
							} catch (e) {
								// If response is not JSON, use default message
							}

							Swal.fire({
								position: 'top-end',
								icon: 'error',
								title: errorMessage,
								showConfirmButton: false,
								timer: 3000,
								toast: true,
								width: 'auto',
								padding: '0.1em',
								background: 'white',
								customClass: {
									popup: 'small-swal'
								}
							});
							$("#registerButton").prop("disabled", false).html("Get Started Now <span class=\"fi fi sr-arrow-right\"></span>");
						}
					});
				},
				rules: {
					first_name: "required",
					last_name: "required",
					email_address: {
						required: true,
						isEmailAvailable: true,
					},
					street_address: {
						required: true,
						minlength: 5
					},
					city: {
						required: true,
						minlength: 2
					},
					postal_code: {
						required: true,
						minlength: 3
					},
					agreed_to_terms: {
						required: true
					},
					phone_number: {
						required: true,
						isValidPhoneNumber: true,
						isPhoneNumberAvailable: true
					},
					password: {
						required: true,
						minlength: 8,
						strongPassword: true
					},
					confirm_password: {
						equalTo: "#password"
					}
				},
			};
			// Password strength indicator
			$('#password').on('input', function() {
				var password = $(this).val();
				var strength = calculatePasswordStrength(password);
				updatePasswordStrengthIndicator(strength);
			});

			$('#register_form').on('submit', function(e) {
				// Ensure phone number is captured from the international input
				if (typeof iti !== 'undefined' && iti.getNumber) {
					var fullPhoneNumber = iti.getNumber();
					$('#phone_input').val(fullPhoneNumber);
					$('#full_phone').val(fullPhoneNumber);
				}

				// Ensure terms are agreed to
				if (!$('#agreed_to_terms').is(':checked')) {
					alert('You must agree to the terms and conditions to continue.');
					return false;
				}
			});
			$('#register_form').validate(register_settings);
		});
	</script>
</body>

</html>