<div class="container-fluid row">
    <div class="col-2">      
        <button onClick="document.location='/admin/main'" class="webstyle_href text-left button py-3 w-100 background-none border-0 background-bd-basic t-basic"><i class="fa fa-tachometer-alt"></i> <span class="display-md-0">Přehled</span></button>
        <button onClick="document.location='/admin/users'" class="webstyle_href text-left  button py-3 w-100 background-none border-0 background-bd-basic t-basic"> <i class="fa fa-users"></i><span class="display-md-0"> Uživatelé</span></button>  
        <button onClick="document.location='/admin/plugins'" class="webstyle_href text-left  button py-3 w-100 background-none border-0 background-bd-basic t-basic"> <i class="fa fa-plug"></i><span class="display-md-0"> pluginy</span></button>  
        <button onClick="document.location='/admin/modules'" class="webstyle_href text-left  button py-3 w-100 background-none border-0 background-bd-basic t-basic"> <i class="fa-solid fa-box"></i><span class="display-md-0"> Moduly</span></button>  

    </div>
    
    <div class="col-10 p-3">
        <?php $this->admin_controll->loadView() ?>
    </div>
</div>

