<div class="container-lg">
    <form method="post" action="contact/send">
        @csrfgen
        <div class="form-line">
            <label for="email">Zadejte svůj email: </label><br>
            <input class="ws-input-text pd-1 f-input-25" id="email" type="email" name="email_from" value="@">
        </div>
        <div class="form-line">
            <label for="subject">Předmět emailu: </label><br>
            <input class="ws-input-text pd-1 f-input-25" id="subject" type="text" name="subject" value="">
        </div>
        
        <div class="form-line">
            <label for="content">Předmět emailu: </label><br>
            <textarea id="content" name="content" class="ws-input-text pd-1 f-input-50" style="height: 12em;"></textarea>
        </div>
        
        <div class="form-line">
            <button type="submit" class="button-large button-basic">Odeslat zprávu</button>
        </div>
    </form>
</div>