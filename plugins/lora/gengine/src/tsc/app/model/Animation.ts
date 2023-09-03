export default class Animation
{
    constructor(){
        
    }

    /**
     * 
     * @param target_object 
     * @param angle 
     * @param duration 
     */
    public rotate(target_object: HTMLElement | any, angle: any, duration: any): void
    {
        var duration_time = parseInt(duration);
        var angle_int = parseInt(angle);

        //Simply rotate the element
        target_object[0].style.transition = `transform ${duration_time}ms`;
        target_object[0].style.transform = `rotateZ(${angle_int}deg)`;
    }

    public translate(target_object: HTMLElement | any, vector: string, direction_operator: string, duration: any): void
    {
        var direction: string;

        if(vector == "X"){
            $(target_object[0]).animate({ left: direction_operator+"="+parseInt(duration)+"px" }, 1000);
        }
        else if(vector == "Y"){
            $(target_object[0]).animate({ top: direction_operator+"="+parseInt(duration)+"px" }, 1000);
        }
    }

    /**
     * 
     * @param target_object 
     * @param scroll_duration 
     */
    public anchor(target_object: HTMLElement | any, scroll_duration: any): void
    {

    }
}