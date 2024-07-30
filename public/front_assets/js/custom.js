/* add/remove headerfixed */
$(document).ready(function() {
    $(window).scroll(function() {
     if ($(document).scrollTop() > 31) {
          $("header").addClass("headerfixed");
        } else {
    $("header").removeClass("headerfixed");
        }
      });
});
   
$(document).ready(function() {
	$(".top_menu_click").click(function() {
		$(".aft_log_top_menu").slideToggle("slow");
	});
});

function addBG() {
  if ( $('.left-bar').hasClass('left100') ) {
    $('.left-bar').removeClass('left100');
    $('.left-bar').addClass('left0');  
} else {
  $('.left-bar.left0').removeClass('left0');
  $('.left-bar').addClass('left100');   
}  
} 

$( function() {
	$( "#datepicker" ).datepicker();
} );
  

/* scroll-to-top button */
/* $(document).ready(function(){
    var scrollToTopBtn = document.querySelector("#scrollToTopBtn");
    var rootElement = document.getElementsByClassName("showBtn");    
    function handleScroll() {
      var scrollTotal = rootElement.scrollHeight - rootElement.clientHeight;
      if (rootElement.scrollTop / scrollTotal > 0.3) {
        scrollToTopBtn.classList.add("showBtn");
      } else {
        scrollToTopBtn.classList.remove("showBtn");
      }
    }    
    function scrollToTop() {
      rootElement.scrollTo({
        top: 0,
        behavior: "smooth"
      });
    }
    if(scrollToTopBtn){        
        scrollToTopBtn.addEventListener("click", scrollToTop);
    }
    document.addEventListener("scroll", handleScroll);
  }); */


  const togglePassword = document.querySelector('#togglePassword');
  const password = document.querySelector('#id_password');
togglePassword.addEventListener('click', function (e) {
const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
password.setAttribute('type', type);
this.classList.toggle('fa-eye-slash');
});

const togglePassword2 = document.querySelector('#togglePassword2');
  const password2 = document.querySelector('#id_password2');
togglePassword2.addEventListener('click', function (e) {
const type = password2.getAttribute('type') === 'password' ? 'text' : 'password';
password2.setAttribute('type', type);
this.classList.toggle('fa-eye-slash');
});







