<div class="form-group">
    <label for="expires_on">Date of Expiry</label>
    <input type="date" name="expires_on" class="form-control" value="{{ isset($gas) ? $gas->expires_on->format('Y-m-d') : old('expires_on') }}" />
    <small class="form-text text-muted">
        Format: YYYY-MM-DD
    </small>
</div>

<div class="form-group">
    <label for="property_id">Property</label>
    <select name="property_id" class="form-control select2">
        <option value="">Please select..</option>
        @foreach (properties() as $property)
            <option 
                @if (isset($gas) && ($gas->property_id == $property->id)) selected @endif
                @if (old('property_id') == $property->id) selected @endif
                value="{{ $property->id }}">
                {{ $property->select_name }}
            </option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="contractors">Contractor(s)</label>
    <select name="contractors[]" class="form-control select2" multiple>
        <option value="">Please select..</option>
        @foreach (users() as $user)
            <option 
                @if (isset($gas) && ($gas->contractors->contains($user->id))) selected @endif
                value="{{ $user->id }}">
                {{ $user->name }}
            </option>
        @endforeach
    </select>
</div>