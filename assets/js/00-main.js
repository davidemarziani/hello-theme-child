/****************************************
 * HTC - Custom js
 */

/* Current year in footer copyright */
/*<span class="current-year-footer">2022</span>*/
jQuery(document).ready(function () {
    var currentYear = new Date().getFullYear();
    jQuery('.current-year-footer').html(currentYear);
});

/****************************************
 * Remove # from "Scroll down" button URL
 */
jQuery(document).ready(function () {
    const scrollDownButton = jQuery('.htc-scroll-down-button');

    scrollDownButton.click(() => {
        setTimeout(() => {
            removeHash();
        }, 5);

        function removeHash() {
            history.replaceState('', document.title, window.location.origin + window.location.pathname);
        }
    });
});
