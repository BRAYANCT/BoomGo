<footer class="page-footer text-center font-small">
	<div class="container">
		<div class="row">

		</div><!--/row-->
	</div><!--/container-->
	{{-- © 2019 Desarrollado por Wasp Soluciones --}}
	<!--Copyright-->
	<div class="footer-copyright py-3 text-center text-dark">
	  	<div class="container-fluid">
			<div class="row">
				<div class="col-sm-12 text-md-right">
					@php
			          $anioInicio = 2020;
			        @endphp
			        @if ($anioInicio < date('Y'))
			            © {{ $anioInicio }} - {{ date('Y') }} 
			        @else
			            ©  {{ date('Y') }}
			        @endif
			        Desarrollado por <a href="https://waspsoluciones.com/" class="text-dark font-weight-bold" target="_blank" >
			        	Wasp soluciones
			        </a>
				</div>
				{{-- <hr class="w-100 clearfix d-sm-none">
				<div class="col-sm-6 text-md-right">
					
					<a href="https://waspsoluciones.com/" taget="_blank">
						Wasp soluciones
					</a>
				</div> --}}
			</div>
	   </div>
	</div><!--/ footer-copyright -->
</footer>