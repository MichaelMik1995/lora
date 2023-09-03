export default class Animation {
    constructor() {
    }
    /**
     *
     * @param target_object
     * @param angle
     * @param duration
     */
    rotate(target_object, angle, duration) {
        var duration_time = parseInt(duration);
        var angle_int = parseInt(angle);
        //Simply rotate the element
        target_object[0].style.transition = `transform ${duration_time}ms`;
        target_object[0].style.transform = `rotateZ(${angle_int}deg)`;
    }
    translate(target_object, vector, direction_operator, duration) {
        var direction;
        if (vector == "X") {
            $(target_object[0]).animate({ left: direction_operator + "=" + parseInt(duration) + "px" }, 1000);
        }
        else if (vector == "Y") {
            $(target_object[0]).animate({ top: direction_operator + "=" + parseInt(duration) + "px" }, 1000);
        }
    }
    /**
     *
     * @param target_object
     * @param scroll_duration
     */
    anchor(target_object, scroll_duration) {
    }
}
