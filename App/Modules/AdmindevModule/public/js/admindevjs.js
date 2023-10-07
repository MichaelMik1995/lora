$(document).ready(() => {

    //CODE for checking template for splitter
    $('#check-templates').click(() => {
        if($('#check-templates').hasClass("button-info"))
        {
            $('#check-templates').removeClass("button-info").addClass("button-success");
            $('#check-templates i').removeClass("fa-close").addClass("fa-check");
            $('#if-check-templates').val("1");
        }
        else
        {
            $('#check-templates').removeClass("button-success").addClass("button-info");
            $('#check-templates i').removeClass("fa-check").addClass("fa-close");
            $('#if-check-templates').val("0");
        }
    });

    //Check if creates Table data
    $('#check-database-data').click(() => {
        if($('#check-database-data').hasClass("button-info"))
        {
            $('#check-database-data').removeClass("button-info").addClass("button-success");
            $('#check-database-data i').removeClass("fa-close").addClass("fa-check");
            $('#if-database-data').val("1");
        }
        else
        {
            $('#check-database-data').removeClass("button-success").addClass("button-info");
            $('#check-database-data i').removeClass("fa-check").addClass("fa-close");
            $('#if-database-data').val("0");
        }
    });

    $('#check-database-table').click(() => {
        if($('#check-database-table').hasClass("button-info"))
        {
            $('#check-database-table').removeClass("button-info").addClass("button-success");
            $('#check-database-table i').removeClass("fa-close").addClass("fa-check");
            $('#if-database-table').val("1");
        }
        else
        {
            $('#check-database-table').removeClass("button-success").addClass("button-info");
            $('#check-database-table i').removeClass("fa-check").addClass("fa-close");
            $('#if-database-table').val("0");
        }
    });

    //CODE for creating new line of splitter
    $("#add-new-splitter").click(() => {
        var id = randomInt(1111,9999);

        var new_line = '<div id="row-'+id+'" class="mgy-1 row background-dark pd-1 bd-round-3">'+
            '<div class="column-8 column-7-xsm">'+
                '<input name="splitter['+id+'][name]" type="text" class="background-none bd-none t-light width-100 subheader-1" placeholder=">> Module[SplitterName]Controller">'+
                '<input hidden id="create-templates-'+id+'" type="text" name="splitter['+id+'][templates]" value="0">'+
            '</div>'+
            '<div class="column-2 column-3-xsm pdy-1 content-right pdx-2">'+
                '<span onClick="toggleCheckTemplates('+id+')" id="check-splitter-templates-'+id+'" title="Vytvořit složku s CRUD šablonami?"><i id="template-icon-'+id+'" class="fa fa-file header-6 mgx-1 cursor-point t-light t-create-hover "></i>'+
                
                '<i onClick="removeSplitterLine('+id+')" class="fa fa-trash t-error header-6"></i>'+
                
            '</div>'+
        '</div>';

        $("#splitters").append(new_line);
    });

    //Add new model line
    $("#add-new-model").click(() => {
        var id = randomInt(1111,9999);

        var new_model_line = '<div id="m-row-'+id+'" class="row mgy-1 background-dark pd-1 bd-round-3">'+
            '<div class="column-8 column-7-xsm">'+
                '<input name="model['+id+'][name]" type="text" class="background-none bd-none t-light width-100 subheader-1" placeholder=">> Module[ModelName]">'+
                '<input hidden id="create-database-'+id+'" type="text" value="0" name="model['+id+'][database]">'+
            '</div>'+
            '<div class="column-2 column-3-xsm pdy-1 content-right pdx-2">'+
                '<span onClick="toggleCheckDatabase('+id+')" title="Vytvořit CRUD model?"><i id="model-icon-'+id+'" class="fa fa-database header-6 mgx-1 cursor-point t-light t-create-hover "></i></span>'+
                '<i onClick="removeModelLine('+id+')" class="fa fa-trash t-error header-6"></i>'+
            '</div>'+
        '</div>';

        $("#models").append(new_model_line);
    });

});


//Functions
function toggleCheckTemplates(id) 
{
    var icon_templates = $("#template-icon-"+id);
    var templates_input = $("#create-templates-"+id);

    if ($(icon_templates).hasClass("t-light")) {
        $(icon_templates).removeClass("t-light").addClass("t-create");
        $(templates_input).val("1");
    }
    else {
        $(icon_templates).removeClass("t-create").addClass("t-light");
        $(templates_input).val("0");
    }
}

function toggleCheckDatabase(id) 
{
    var icon_templates = $("#model-icon-"+id);
    var templates_input = $("#create-database-"+id);

    if ($(icon_templates).hasClass("t-light")) {
        $(icon_templates).removeClass("t-light").addClass("t-create");
        $(templates_input).val("1");
    }
    else {
        $(icon_templates).removeClass("t-create").addClass("t-light");
        $(templates_input).val("0");
    }
}

function removeSplitterLine(id)
{
    $("#row-"+id).slideUp(200).remove();
}

function removeModelLine(id)
{
    $("#m-row-"+id).slideUp(200).remove();
}