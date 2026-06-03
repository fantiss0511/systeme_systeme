
/*  
  -------------------------------------------------------------------------------------
  -----      Initialize tooltips and popovers, and retrieve the 'dir' value.      -----
  -------------------------------------------------------------------------------------
*/

// Initialize tooltips if they exist
const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
if (tooltipTriggerList.length > 0) {
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
}

// Initialize popovers if they exist
const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]');
if (popoverTriggerList.length > 0) {
    const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl));
}

// Get the value of the 'dir' attribute, or set it to 'ltr' if it doesn't exist
var htmlElement = document.querySelector('html');
if (htmlElement) {
    var textDirectionOfTheDom = htmlElement.getAttribute('dir') || 'ltr';
}





/*  
  ------------------------------------------------------------------------------------
  -----      Loader animation before displaying the page and initialize AOS      -----
  ------------------------------------------------------------------------------------
*/

window.addEventListener("load", function(event){
    var loaderWrapper = document.querySelector('.loader-wrapper');
    if (loaderWrapper) {
        // Start the fade-out transition
        loaderWrapper.classList.remove("opacity-100", "w-100");
        loaderWrapper.classList.add("opacity-0", "w-0");

        // After the transition duration, set display to none
        setTimeout(() => {
            loaderWrapper.classList.remove("d-flex");
            loaderWrapper.classList.add("d-none");
        }, 1000); // Match this duration with the transition duration

    } 

    // After the transition duration, check if AOS is defined and the first [data-aos] element exists
    setTimeout(() => {
        if (typeof AOS === 'object' && document.querySelector('[data-aos]')) {
            AOS.init({
                offset: 0,
                once: true,
            });
        }
    }, 500); // Set this duration with half of the transition duration  
})


