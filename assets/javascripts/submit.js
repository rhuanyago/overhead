// JavaScript source code
/**
  Requires:
    Spin.js (http://fgnass.github.com/spin.js/)
    Spin.js jQuery plugin (https://gist.github.com/1290439)
  Usage: $(#your-id).spinSubmit();
  For best results, change the 'small' to - small:{lines:12,length:3,width:2,radius:4} in the jQuery plugin
  Changelog:
  ----------
  0.32 (15Feb 2012) - Added width and height contraints based on initial text
  0.31 (15Feb 2012) - Added ontouchend event handler
  0.3  (14Feb 2012) - Added conditions to add an icon or remove the text
  0.2               - Changed to use <a> or <button>
  0.1               - Swap submit <input> for anchors
**/


$.fn.spinSubmit = function () {

    // Check if we are dealing with an input
    if (this.is('input')) {

        // If we are, chuck 'em out
        return this;
    }

    // Uncomment to add an icon with js (to keep things semantic)
    // Adding .show() allows the element to be hidden in css to prevent FOUC
    // var icon = this.append('<span class="icon"></span>').show();

    // When clicking (or tapping) the submit button
    this.on('click ontouchend', function (e) {

        // Stop the form submitting normally
        e.preventDefault();

        // Cache $(this) for speed
        var $this = $(this),
            h     = $this.height(),
            w     = $this.width();

        // If this button is disabled
        if ($this.attr('disabled') == 'disabled') {

            // If it is, chuck 'em out
            return this;

        } else {

            // Unbind the click event
            $this.off('click');

            // Disabled it
            $this.attr('disabled', 'disabled');

            // Add a loading class to the button
            $this.addClass('loading').css({
                'height' : h,
                'width'  : w
            });

            // Using spin.js to create a spinner
            if (!icon) {
                $this.text('<h1>Carregando...</h1>').spin('small');
            } else {
                $this.find('.icon').spin('small');
            }

            // Delay the form submission to apply the animations
            setTimeout(function () {
                
                // Find the closest form and submit it
                $this.closest('form').submit()

            // Delay the submit so we can initialise the spinner
            // 400 ms is the optimal time to give the user an impression of speed
            }, 400);
        
        }

    });

    // return the new object for chainability
    return this;

}

