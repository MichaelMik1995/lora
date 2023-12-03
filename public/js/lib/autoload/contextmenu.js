/* $(document).ready(function() {
    var new_content_menu = "\
    <div id=\"custom-menu\">\
        <ul id='menu-list'></ul>\
    </div>";

    $("body").append(new_content_menu); 
    $(document).contextmenu(function (e) {
        e.preventDefault();

        var targetElement = $(e.target);
        var elementType = targetElement.prop('tagName').toLowerCase();

        var menuList = $('#menu-list');
        if (menuList.length === 0) {
            console.error("Element with id 'menu-list' not found.");
            return;
        }

        menuList.empty(); // Vyprázdnění existující nabídky

        var elementMenuItems = definedMenu[elementType] || definedMenu['_default'];

        for (var i = 0; i < elementMenuItems.length; i++) {
            var menuItem = elementMenuItems[i];
            var li = $('<li>')
                .text(menuItem.label)
                .data('action', menuItem.action)
                .data('menu', menuItem['data-menu'])
                .on('click', createActionHandler(menuItem, targetElement));
            menuList.append(li);
        }

        // Zobrazit nabídku na správném místě
        showCustomMenu(e.pageX, e.pageY);
    });

    $(document).mousedown(function (e) {
        // Zkontrolovat, zda kliknutí není uvnitř nabídky
        if (!$(e.target).closest('#custom-menu').length) {
            hideCustomMenu();
        }
    });

    function showCustomMenu(x, y) {
        var menu = $('#custom-menu');
        menu.css({ display: 'block', left: x + 'px', top: y + 'px' });
    }

    function hideCustomMenu() {
        var menu = $('#custom-menu');
        menu.css('display', 'none');
    }

    function createActionHandler(menuItem, targetElement) {
        return function() {
            executeAction(menuItem, targetElement);
        };
    }

    function executeAction(menuItem, targetElement) {
        // Zde můžete pracovat s targetElement
        var elementId = targetElement.attr('id');
        var elementType = targetElement.prop('tagName').toLowerCase();
        // ... další manipulace s targetElement

        // Definujte vaše akce zde
        switch (menuItem.action) {
            case 'functionOpenHref':
                openHref(targetElement);
                break;
            case 'functionAlertMessage':
                alertMessage();
                break;
            case 'functionCustomAction':
                customAction();
                break;
            default:
                console.error("Unknown action:", menuItem.action);
        }

        hideCustomMenu();
    }

    function openHref(element) {
        var redirectUrl = element.attr('redirect');
    
        if (redirectUrl) {
            // Má atribut redirect, vykonáme window.open
            window.open(redirectUrl);
        } else {
            // Nemá atribut redirect, zkoušíme nadřazené prvky
            var parentElement = element.parent();
    
            if (parentElement.length > 0) {
                openHref(parentElement);
            }
        }
    }

    function alertMessage(color) {
        // Definujte, co má být provedeno pro "functionAlertMessage"
        console.log('Showing Alert Message with color:', color);
    }

    function customAction(data) {
        // Definujte, co má být provedeno pro "functionCustomAction"
        console.log('Executing Custom Action with data:', data);
    }

    // Načtení nabídek ze souboru
    var definedMenu;
    $.getJSON('./resources/js/contextmenu/defined.json', function (data) {
        definedMenu = data;
    });
}); */