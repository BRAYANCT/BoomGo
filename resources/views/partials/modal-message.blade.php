<script type="text/javascript">
	
	@if(Session::has('modalMessage'))
		
		let mensajeModal = function(){
			fg.modalMessageObject(@json(Session::get('modalMessage')));
		}

		@php
			Session::forget('modalMessage');
		@endphp	
	@else
		@if(isset($errors))	
			let mensajeModal = function(){
				@if(count( $errors ) > 0 )
					fg.modalMessage({!!json_encode($errors -> all())!!},'error');
				@endif	
			
				@if(isset($data['valida']))
					@if(count($data['mensaje'])>0)
						@if($data['valida'] == -1 )
							fg.modalMessage({!!json_encode($data['mensaje'])!!},'danger');
						@else
							fg.modalMessage({!!json_encode($data['mensaje'])!!},'success');
						@endif
					@endif
				@endif
			}	
		@endif
	@endif

</script>

