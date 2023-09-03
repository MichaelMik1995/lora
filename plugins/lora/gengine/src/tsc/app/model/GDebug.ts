export default class GDebug
{
    constructor()
    {

    }

    /**
     * Returns a log of Gengine
     * @param message 
     * @param level 
     * @returns 
     */
    public log(message: string, level: string = "info"): void
    {
        var prefix = "";

        switch (level)
        {
            case "info":
                prefix = "[GE_Debug]INFO: ";
            break;

            case "warn":
                prefix = "[GE_Debug]WARNING: ";
            break;

            case "error":
                prefix = "[GE_Debug]ERROR: ";
            break;

            default:
                prefix = "[GE_Debug]INFO: ";
            break;
        }

        return console.log(prefix + message);
    }
}