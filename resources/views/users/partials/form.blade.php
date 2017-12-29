@component('partials.form-group')
    @slot('label')
        Title
    @endslot
    <input type="text" name="title" id="title" class="form-control" value="{{ isset($user) ? $user->title : old('title') }}" />
@endcomponent

@component('partials.form-group')
    @slot('label')
        First Name
    @endslot
    <input type="text" name="first_name" id="first_name" class="form-control" value="{{ isset($user) ? $user->first_name : old('first_name') }}" />
@endcomponent

@component('partials.form-group')
    @slot('label')
        Last Name
    @endslot
    <input type="text" name="last_name" class="form-control" value="{{ isset($user) ? $user->last_name : old('last_name') }}" />
@endcomponent

@component('partials.form-group')
    @slot('label')
        Company Name
    @endslot
    <input type="text" name="company_name" class="form-control" value="{{ isset($user) ? $user->company_name : old('company_name') }}" />
@endcomponent

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