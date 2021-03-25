<form id="formContact" method="POST" action="{{ route('web.enquiry.submit') }}">
  {{ csrf_field() }}
  <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
    <label class="control-label">Name</label>
    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>

    @if ($errors->has('name'))
        <span class="help-block text-danger">
            <strong>{{ $errors->first('name') }}</strong>
        </span>
    @endif
  </div>
  <div class="form-group{{ $errors->has('phone_number') ? ' has-error' : '' }}">
    <label class="control-label">Phone Number</label>
    <input type="tel" name="phone_number" class="form-control" value="{{ old('phone_number') }}" required>

    @if ($errors->has('phone_number'))
        <span class="help-block text-danger">
            <strong>{{ $errors->first('phone_number') }}</strong>
        </span>
    @endif
  </div>
  <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
    <label class="control-label">Email Address</label>
    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>

    @if ($errors->has('email'))
        <span class="help-block text-danger">
            <strong>{{ $errors->first('email') }}</strong>
        </span>
    @endif
  </div>
  <div class="form-group{{ $errors->has('interest') ? ' has-error' : '' }}">
    <label class="control-label">Interested In</label>
    <div>
      @php
      $interests = [
        'Course price and contents',
        'Class schedule',
        'Mplus trading account opening',
        'Weekly market POV registration',
        'SI station subscription',
        'Others'
      ];
      @endphp
      @foreach($interests as $i => $interest)
        <div class="custom-control custom-checkbox">
          <input type="checkbox" name="interest[]" class="custom-control-input" id="interest{{$i}}" value="{{ $interest }}" @if(in_array($interest, old('interest', [])))checked @endif>
          <label class="custom-control-label" for="interest{{$i}}">{{ $interest }}</label>
        </div>
      @endforeach
    </div>

    @if ($errors->has('interest'))
        <span class="help-block text-danger">
            <strong>{{ $errors->first('interest') }}</strong>
        </span>
    @endif
  </div>
  <div class="form-group{{ $errors->has('message') ? ' has-error' : '' }}">
    <label class="control-label">Enquiry</label>
    <textarea name="message" class="form-control" required>{{ old('message') }}</textarea>

    @if ($errors->has('message'))
        <span class="help-block text-danger">
            <strong>{{ $errors->first('message') }}</strong>
        </span>
    @endif
  </div>
  <div class="form-actions">
    <button type="submit" class="btn btn-theme px-3 d-sm-block">Send</button>
  </div>
</form>