@php
	if(!isset($disabled)){
		$disabled = false;
	}
@endphp

<div class="col-md-6">
	<div class="md-form ">
		<input 	type="text"
				id="username"
				class="form-control"
				value="{{ $value }}"
				{{ $disabled ? 'disabled' : '' }}
				>
		<label for="username">{{ $label }}</label>
	</div>
</div>