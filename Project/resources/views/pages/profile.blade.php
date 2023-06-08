@extends('layouts.app')

@section('title', 'Tech4You')

@section('content')


<main>
	<div class="container my-5">
		<nav class="path" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active" style="color: black;">Profile</li>
            </ol>
        </nav>
		<div class="row" style="border-left: 0.5rem solid red; margin-bottom: 2rem;"><h2>My Profile</h2></div>
		<form action="{{ route('saveUserProfile', ['id' => $user->id]) }}"  method="POST" class="row d-flex justify-content-center my-4" style="background-color: white; padding: 1rem; border-radius:10px;">
			@csrf
			<h4 class="mb-4" style="text-decoration: underline 4px red">Personal Info</h4>
			<div class="col-md-6">
				<div class="form-group mb-4">
					<label class="profile_details_text">Name:</label>
					<input type="text" name="username" class="form-control" value="{{ $user->name }}" required>
				</div>
				<div class="form-group mb-4">
					<label class="profile_details_text">Email Address:</label>
					<input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label class="profile_details_text">Phone Number:</label>
					<input type="tel" name="phonenumber" class="form-control" value="{{ $user->phonenumber }}" pattern=[0-9]{9}>
				</div>
			</div>
			<button class="btn btn-danger btn-lg" onclick="" type="submit" style="width: 10rem; margin-top: 20px;">Save</button>
		</form>
		<form action="{{ route('saveUserPassword', ['id' => $user->id]) }}"  method="POST" class="row d-flex justify-content-center my-4">
			@csrf
			<div class="row d-flex justify-content-center my-4" style="background-color: white; padding: 1rem; border-radius:10px;">
				<h4 class="mb-4" style="text-decoration: underline 4px red">Change Password</h4>
				<div class="col-md-6">
					<div class="form-group mb-4">
						<label class="profile_details_text">Old Password:</label>
						<input type="password" name="oldPassword" class="form-control"required>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group mb-4">
						<label class="profile_details_text">New Password:</label>
						<input type="password" name="newPassword" class="form-control" required>
					</div>
					<div class="form-group mb-4">
						<label class="profile_details_text">Confirm New Password:</label>
						<input type="password" name="confirmPassword" class="form-control" required>
					</div>
				</div>
				<button class="btn btn-danger btn-lg" onclick="" style="width: 10rem">Save</button>
			</div>
		</form>
		@if(!Auth::user()->isAdmin())
			<div class="row d-flex justify-content-center my-4" style="background-color: white; padding: 1rem; border-radius:10px;">
				<h4 class="mb-4" style="text-decoration: underline 4px red">Billing Address</h4>
				<div class="mb-4" style="display: flex; justify-content: space-evenly; flex-wrap: wrap; gap: 2rem;">
					@foreach(Auth::user()->address()->get() as $address)
						<div class="address_card" style="height: auto">
							<p><strong>Street: </strong>{{$address->street}}<p>
							<p><strong>City: </strong>{{$address->city}}, {{$address->country}}</p>
							<p><strong>Postal Code: </strong>{{$address->postalcode}}</p>
							<div class="edit_del_btn">
								<button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#removeAddress{{$address->id}}"><i class="fas fa-trash"></i></button>
							</div>
						</div>
						<div class="modal fade" id="removeAddress{{$address->id}}" tabindex="-1" aria-labelledby="removeAddressLabel" aria-hidden="true">
							<div class="modal-dialog modal-dialog-centered">
								<div class="modal-content">
									<div class="modal-header">
										<h1 class="modal-title fs-5" id="removeAddress{{$address->id}}Header">Remove Address</h1>
										<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
									</div>
									<div class="modal-body">  
										After this action this address will be removed from your account.
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
										<button type="button" class="btn btn-danger" onclick="removeAddress({{ $address->id }}, {{ Auth::user()->id }})">Remove</button>
									</div>
								</div>
							</div>
						</div>
					@endforeach
				</div>
				<button class="btn btn-danger btn-lg" onclick="" style="width: 10rem" data-bs-toggle="modal" data-bs-target="#addAddress{{$user->id}}">Add Address</button>
			</div>
			<div class="row d-flex justify-content-center my-5" style="background-color: white; padding: 1rem; border-radius:10px;" id="delete_account">
				<h4 class="mb-4" style="text-decoration: underline 4px red">Delete Account</h4>
				<div class="mb-4" style="display: flex; justify-content: space-evenly; flex-wrap: wrap; gap: 2rem;">
					<p>Your personal information will be deleted and you will lose your orders records! </p>
				</div>
				<button class="btn btn-danger btn-lg" style="width: 15rem" data-bs-toggle="modal" data-bs-target="#deleteProfile{{$user->id}}">Delete account</button>
			</div>
		@endif
	</div>
	<div class="modal fade" id="deleteProfile{{$user->id}}" tabindex="-1" aria-labelledby="deleteProfileLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h1 class="modal-title fs-5" id="deleteProfile{{$user->id}}Header">Delete Profile</h1>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">  
					After this action your account will be deleted.
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
					<button type="button" class="btn btn-danger" onclick="deleteAccount()">Delete</button>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="addAddress{{$user->id}}" tabindex="-1" aria-labelledby="addAddressLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h1 class="modal-title fs-5" id="addAddress{{$user->id}}Header">Add Address</h1>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">  
					<div class="mb-3">
						<label for="address_country" class="form-label">Country</label>
						<input type="text" class="form-control" id="address_country">
					</div>
					<div class="mb-3">
						<label for="address_city" class="form-label">City</label>
						<input type="text" class="form-control" id="address_city">
					</div>
					<div class="mb-3">
						<label for="address_street" class="form-label">Street</label>
						<input type="text" class="form-control" id="address_street">
					</div>
					<div class="mb-3">
						<label for="address_postalCode" class="form-label">Postal Code</label>
						<input type="text" class="form-control" id="address_postalCode">
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
					<button type="button" class="btn btn-danger" onclick="addAddress({{$user->id}})">Add</button>
				</div>
			</div>
		</div>
	</div>
</main>

@endsection
