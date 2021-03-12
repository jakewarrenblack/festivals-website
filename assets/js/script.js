

/*Not using window.onLoad because this script is needed at load time!*/
/*I don't want to wait for images to load before having this script ready to go.*/
$(document).ready(function() {


scrollDownBtn = document.getElementById("scrollDown");
 mainImg = document.getElementById("mainImg");
//Find our button
backTopBtn = document.getElementById("backTop");
window.onscroll = function () {
    backTop()
    scrollDown();
};


/*When we scroll below the hero image, hide the floating arrow*/
function scrollDown(){
  if (document.body.scrollTop > (mainImg.offsetHeight - mainImg.offsetHeight/2) || document.documentElement.scrollTop > (mainImg.offsetHeight- mainImg.offsetHeight/2)) {
    scrollDownBtn.style.display = "none";
} else {
  scrollDownBtn.style.display = "block";
}
}

function backTop() {
    if (document.body.scrollTop > window.innerHeight || document.documentElement.scrollTop > window.innerHeight ) {
        backTopBtn.style.display = "block";
    } else {
        backTopBtn.style.display = "none";
    }
}

  var collapseBtn = document.getElementById("collapseButton");
  var collapsedElems = document.getElementsByClassName("collapse");

  /*Initalising to 0*/
var counter = 0;

/*Change the innerHTML of the 'see more' button when clicked*/
  function changeHTML() {
    counter++;
    if(counter % 2 != 0){
      collapseBtn.innerHTML = "See Less"
    }else{
      collapseBtn.innerHTML = "See More"
  }
}

collapseBtn.addEventListener("click",changeHTML);

  /*Only apply this script on large screens, I don't like the fade effect on mobile*/
if($(window).width() >= 1024){
  
    // First check if the user is on a small screen. If not, get all divs with classname "collapse".
    // Apply the "show" classname to these, to make them appear even though they're collapsable.
    // This means they'll show up on desktop but be collapsed on mobile.
   
  for(var i=0; i<collapsedElems.length; i++){
    collapsedElems[i].classList.add("show");
  }

  // alert('found')
  $(window).scroll(function() {
    var windowBottom = $(this).scrollTop() + $(this).innerHeight();

    /*Apply this function to each element with classname "fade"*/ 
    $(".fade").each(function() {
      var objectBottom = $(this).offset().top + $(this).outerHeight();
      
      /* If the element is completely within bounds of the window, fade it in */
      if (objectBottom-500 < windowBottom) { //object comes into view (scrolling down)
        if ($(this).css("opacity")==0) {$(this).fadeTo(300,1);}
      }
    });
  }).scroll(); //run scroll-handler on page-load
}
});
