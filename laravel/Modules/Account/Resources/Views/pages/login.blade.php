@extends("system::layouts.base")

@section("base")
	<div class="uk-height-viewport uk-position-relative uk-width-1-1"
		 id="app">

		<ts-activity-notifier>
		</ts-activity-notifier>

		<div class="uk-width-1-1 login-wrapper uk-grid-match " uk-grid>
			<div class="uk-width-1-2@m h-100 bg-ts uk-background-top-center uk-background-cover "
				 style='background-image: url("/images/bg-01.jpeg")'>

			</div>
			<div class="uk-width-1-2@m h-100 uk-position-relative">
				<div class="uk-position-center mw-75 px-14">
					<div class="mb-5 uk-flex uk-flex-center uk-flex-column uk-flex-middle">
						<img src="/images/logo/tslogo1.png" class="uk-display-block" alt="talkstuff"
							 style="height: 70px;
						width: 70px;">
						<h3>Welcome to Talk<span class="fg-ts">S</span>tuff</h3>
					</div>

					<ts-login>

					</ts-login>
				</div>
			</div>
		</div>

		<div class="bg-ts ts-footer"></div>

		<ts-response-messenger>

		</ts-response-messenger>
	</div>
@endsection

@push('scripts')
	<script src="/build/account/js/login.js"></script>
@endpush

@push('styles')
	<link rel="stylesheet" href="/build/account/css/account.css">
@endpush