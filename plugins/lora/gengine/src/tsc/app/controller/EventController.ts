import GDebug from "../model/GDebug.js";
import Animation from "../model/Animation.js";

export default class EventController 
{
    public Events: Array<String> = [
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

    private _debug: GDebug = new GDebug();

    constructor() 
    {
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
    public Event(event_name: string, model_object: string, source_object: any, handled_function: string, params: Array<any>): void
    {
        source_object.on(event_name, (e: any) => {
            e.preventDefault();
            const target_object_attr: string = source_object.attr("g-target");
            let target_object: HTMLElement | any;

            if (target_object_attr === undefined) {
                target_object = source_object;
            } else {
                target_object = $(target_object_attr);
            }

            //model_object = "Animation"
            const className = model_object;

            /**
             * Initialize the model
             */
            if(className === "Animation")
            {
                const animation = new Animation();
                animation[handled_function](target_object, ...params);
            }

        });
    }

    public MouseEnterEvent(object: any, handled_function: string, params: Array<any>): void
    {
        this._debug.log("[GE_Debug]: Mouse enter on: "+object + "with function: "+ handled_function + " with params: "+params);
    }

    private CallModels(handled_function: string)
    {
        
    }

}