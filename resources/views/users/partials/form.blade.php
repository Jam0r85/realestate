<div class="field">
    <label class="label" for="title">Title</label>
    <p class="control">
        <input type="text" name="title" class="input" value="{{ isset($user) ? $user->title : old('title') }}" />
    </p>
</div>

<div class="field">
    <label class="label" for="first_name">First Name</label>
    <p class="control">
        <input type="text" name="first_name" class="input" value="{{ isset($user) ? $user->first_name : old('first_name') }}" />
    </p>
</div>

<div class="field">
    <label class="label" for="last_name">Last Name</label>
    <p class="control">
        <input type="text" name="last_name" class="input" value="{{ isset($user) ? $user->last_name : old('last_name') }}" />
    </p>
</div>

<div class="field">
    <label class="label" for="company_name">Company Name</label>
    <p class="control">
        <input type="text" name="company_name" class="input" value="{{ isset($user) ? $user->company_name : old('company_name') }}" />
    </p>
</div>

@if (!isset($user))
    <div class="field">
        <label class="label" for="email">E-Mail Address</label>
        <p class="control">
            <input type="email" name="email" class="input" value="{{ old('email') }}" />
        </p>
    </div>
@endif

<div class="field">
    <label class="label" for="phone_number">Mobile Phone</label>
    <p class="control">
        <input type="text" name="phone_number" class="input" value="{{ isset($user) ? $user->phone_number : old('phone_number') }}" />
    </p>
</div>

<div class="field">
    <label class="label" for="phone_number_other">Other Phone Number</label>
    <p class="control">
        <input type="text" name="phone_number_other" class="input" value="{{ isset($user) ? $user->phone_number_other : old('phone_number_other') }}" />
    </p>
</div>