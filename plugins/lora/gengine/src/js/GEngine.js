import EventController from './app/controller/EventController.js';
import GDebug from './app/model/GDebug.js';
export default class GEngine {
    constructor() {
        this.version = "1.0.0";
        this.event_controller = new EventController();
        this._debug = new GDebug();
        console.log('Plugin GEngine ' + this.version + ' loaded successfully');
    }
    /**
     * After loading page -> handle all events from elements with attribute "gengineEvent"
     *
     * @param object
     * @returns
     */
    eventHandler(object, attribute = "g-event") {
        var attribute_value = object.attr(attribute);
        var [eventName, functionCall] = attribute_value.split("->");
        // Extrahování jména události
        var event = eventName.trim();
        // Extrahování části funkčního volání
        var match = functionCall.match(/(\w+)\.(\w+)\((.*?)\)/);
        if (match) {
            var [, gObject, gFunction, paramsString] = match;
            var functionParams = paramsString.split(",").map(param => param.trim());
            this.event_controller.Event(event, gObject, object, gFunction, functionParams);
        }
        else {
            this._debug.log("Uncaught method.", "error");
        }
    }
}
;
