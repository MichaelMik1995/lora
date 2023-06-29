<!-- Testování elementů (nejpovedenější se tu zanechají ;)) -->

<div id="success-block" template="1">
    <div id="{id}" class="mgy-2 width-50 width-100-xsm background-{bcg} bd-left-{border} bd-3 pd-2 bd-round-2">
        <div class="row">
        <div class="column-9">
            <div class="subheader-1 t-bold">
                <i class="fa {icon} subheader-3 t-{color}"></i> {title}
            </div>
            <div class="t-italic">
                {content}
            </div>
        </div>
        <div class="column-center pdx-2 content-right">
            <i onClick="$('#{id}').slideToggle(200)" class="fa fa-close t-dark t-bold cursor-point"></i><sup>9</sup>
        </div>
        </div>
    </div>
</div>

<div 
    copy-element="success-block" 
    data="id:info,bcg:info,border:basic,color:basic,icon:fa-info-circle,title:Information!,content:Your mwssage has valid"
>
</div>

<div 
    copy-element="success-block" 
    data="id:success,bcg:success,border:create,color:create-2,icon:fa-check-circle,title:Success!,content:Your mwssage has valid"
>
</div>

<div 
    copy-element="success-block" 
    data="id:warning,bcg:warning,border:warning-2,color:warning-2,icon:fa-exclamation-triangle,title:Warning!,content:Your mwssage has not valid"
>
</div>

<div 
    copy-element="success-block" 
    data="id:error,bcg:error,border:error-2,color:error-2,icon:fa-close,title:Error!,content:Your message has nYour message has not validYour message has not validot valid"
>
</div>

<input type="text" class="input-basic" placeholder="text">
<input type="text" class="input-error" placeholder="text">
<input type="text" class="input-warning" placeholder="text">
<input type="text" class="input-dark" placeholder="text">
<input type="text" class="input-light" placeholder="text">
<br>
<input type="text" class="input-basic-bg" placeholder="text">
<input type="text" class="input-error-bg" placeholder="text">
<input type="text" class="input-warning-bg" placeholder="text">
<input type="text" class="input-dark-bg" placeholder="text">
<input type="text" class="input-light-bg" placeholder="text">

<div class="mgy-2 bgr-success width-30 bd-top-create">
    <div class="t-create-2 t-bold header-6 content-center pdy-1">
        <i class="fa fa-check-circle"></i> Success!
    </div>
    <div class="pd-2 content-center">
        Your email was successfully valid
    </div>
    <hr>
    <div class=" content-right pd-2">
        <button class="button button-create bd-round-3"><i class="fa fa-check"></i> OK</button>
    </div>
</div>

<div class="mgy-2 bgr-info bd-top-basic width-30">
    <div class="t-basic-2 header-6 pd-1 content-center">
        <i class="fa fa-info-circle"></i> Information
    </div>
    <div class="pd-2 content-center">
        Your email was successfully valid
    </div>
    <hr>
    <div class=" content-right pd-1">
        <button class="button button-basic bd-round-3"><i class="fa fa-check"></i> OK</button>
    </div>
</div>