import GDebug from "../model/GDebug.js";
import Animation from "../model/Animation.js";
export default class EventController {
    constructor() {
        this.Events = [
            "click",
            "mouseenter",
            "mouseleave",
            "mousemove",
            "mousedown",
            "mouseup",
            "mouseover",
            "mouseout",
            "keypress",
            "keydown",
            "keyup",
            "change",
            "submit",
            "reset",
            "focus",
            "blur",
            "resize",
        ];
        this._debug = new GDebug();
        this._debug.log("EventController initialized");
    }
    /**
     *
     * @param event_name            :String
     * @param source_object         :ObjectElement
     * @param target_object         :ObjectElement
     * @param handled_function      :CallbackFunction
     * @param params                :Array<any>
     */
    Event(event_name, model_object, source_object, handled_function, params) {
        source_object.on(event_name, (e) => {
            e.preventDefault();
            const target_object_attr = source_object.attr("g-target");
            let target_object;
            if (target_object_attr === undefined) {
                target_object = source_object;
            }
            else {
                target_object = $(target_object_attr);
            }
            //model_object = "Animation"
            const className = model_object;
            /**
             * Initialize the model
             */
            if (className === "Animation") {
                const animation = new Animation();
                animation[handled_function](target_object, ...params);
            }

            this._debug.log("[GE_Debug]: Mouse enter on: " + target_object + " with function: " + handled_function + " with params: " + params);

        });
    }
    MouseEnterEvent(object, handled_function, params) {
        this._debug.log("[GE_Debug]: Mouse enter on: " + object + "with function: " + handled_function + " with params: " + params);
    }
    CallModels(handled_function) {
    }
}
