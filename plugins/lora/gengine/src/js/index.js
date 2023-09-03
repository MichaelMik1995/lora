/**
 * This is the main entry point for the application.
 */
import GEngine from './GEngine.js';
const gengine = new GEngine();
$(document).on('DOMContentLoaded', function (event) {
    $('[g-event]').each(function () {
        gengine.eventHandler($(this));
    });
    $('[g-callback]').each(function () {
        gengine.eventHandler($(this), "g-callback");
    });
});
