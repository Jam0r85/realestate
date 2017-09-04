<div class="form-group">
    <label for="title">Title</label>
    <input type="text" name="title" class="form-control" value="{{ isset($user) ? $user->title : old('title') }}" />
</div>

<div class="form-group">
    <label for="first_name">First Name</label>
    <input type="text" name="first_name" class="form-control" value="{{ isset($user) ? $user->first_name : old('first_name') }}" />
</div>

<div class="form-group">
    <label for="last_name">Last Name</label>
    <input type="text" name="last_name" class="form-control" value="{{ isset($user) ? $user->last_name : old('last_name') }}" />
</div>

<div class="form-group">
    <label for="company_name">Company Name</label>
    <input type="text" name="company_name" class="form-control" value="{{ isset($user) ? $user->company_name : old('company_name') }}" />
</div>

@if (!isset($user))
    <div class="form-group">
        <label for="email">E-Mail Address</label>

        <input type="email" name="email" class="form-control" value="{{ old('email') }}" />

    </div>
@endif

<div class="form-group">
    <label for="phone_number">Mobile Phone</label>
    <input type="text" name="phone_number" class="form-control" value="{{ isset($user) ? $user->phone_number : old('phone_number') }}" />
    <small id="phoneNumberHelpBlock" class="form-text text-muted">
        Mobile phone numbers are automatically converted to international format.
    </small>
</div>

<div class="form-group">
    <label for="phone_number_other">Other Phone Number</label>
    <input type="text" name="phone_number_other" class="form-control" value="{{ isset($user) ? $user->phone_number_other : old('phone_number_other') }}" />
</div>