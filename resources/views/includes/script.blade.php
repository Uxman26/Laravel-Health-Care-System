<script src="{{asset('public/front_assets/js/popper.min.js')}}"></script>
  <script src="{{asset('public/front_assets/js/jquery.min.js')}}" type="text/javascript"></script> 
  <script src="{{asset('public/front_assets/js/bootstrap.bundle.js')}}" type="text/javascript"></script>  
  <script src="{{asset('public/front_assets/js/owl.carousel.min.js')}}" type="text/javascript"></script>   
  <script src="{{asset('public/front_assets/js/datepicker.js')}}" type="text/javascript"></script> 
  @if(Route::is('employee.password'))
  @else  
  <script src="{{asset('public/front_assets/js/custom.js')}}" type="text/javascript"></script>  
  @endif  
  <script src="{{asset('public/front_assets/js/go_to_top.js')}}" type="text/javascript"></script> 
  <script src="{{asset('public/front_assets/js/datepicker.js')}}" type="text/javascript"></script> 
  <script src="{{asset('public/front_assets/js/bootstrap.min.js')}}" type="text/javascript"></script> 
  <script src="{{asset('public/front_assets/js/jquery-ui.js')}}" type="text/javascript"></script>    
  <!-- <script src="{{asset('public/front_assets/js/go_to_top.js')}}" type="text/javascript"></script>  -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script> 
  <!-- <script src="{{asset('public/front_asset/sweetalert/dist/sweetalert2.min.js')}}" type="text/javascript" charset="utf-8"></script>  -->
<script>
  $('.close').click(function(){
    // alert alert-success alert-dismissible
    $('.alert').hide();
  })


</script>

<script>
 
// $('.popup_images_slider').owlCarousel({
//   loop:true,
//   dots:false,
//   autoplay:false,
//   center: true,
//   nav:true,
  
//   stagePadding: 500,
//   margin:350,
//   items:3,
		
//   responsive:{

//       320:{

//          stagePadding: 100,
//   		margin:150,
// 		items:1,
//       },
// 	  480:{

//           stagePadding: 100,
//   		margin:150,
// 		items:1,
//       },
//       767:{

// 		stagePadding: 100,
//   		margin:150,
// 		items:1,
//       },
//       991:{

// 		stagePadding: 0,
//   		margin:250,
// 		items:3,
//       },
// 	  1199:{

// 		stagePadding: 0,
//   		margin:250,
// 		items:3,
//       },
// 	  1399:{

// 		stagePadding: 0,
//   		margin:250,
// 		items:3,
		
//       }
//   }
// })
</script>