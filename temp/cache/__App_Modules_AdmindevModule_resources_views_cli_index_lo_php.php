<div class="pd-1">
    > <input list="cli-list" focused id="clicmd-input" type="text" class="background-none t-light t-bold width-50 width-75-xsm" placeholder="Příkaz" value="php ">
    <button id="clicmd-button" class="button button-create"><i class="fa fa-send"></i> <span class="display-0-xsm">Vykonat příkaz</span></button>
</div>

<datalist id="cli-list">
    <option value="php lora help">
    <option value="php lora help [page]">
    <option value="php lora migrate">
    <option value="php lora migrate:data">
    <option value="php lora migrate:create [name] --data">
    <option value="php bin/module create [module]">
    <option value="php bin/module splitter:create [splitter] [module]">

</datalist>

<div id="cli-log" class="pd-1 bgr-dark bd-dark-2 bd-2 bd-round-3">
    <?php foreach($log as $line) : ?>
    <div class="row mgy-1 pd-2 background-dark-2 bd-round-3">
        <div class="column-2 t-bolder t-success">
            <?php echo DATE("d.m.Y H:i:s", $line["created_at"]) ?>
        </div>

        <div class="column-6">
            <details>
                <summary><?php echo $line["cmd_execute"] ?></summary>

                <?php echo $line["_output"] ?>
            </details>
        </div>

        <div class="column-2 t-info">
            <?php echo $line["cmd_type"] ?>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<script>
    $(document).ready(() => {
        var cli_button = $('#clicmd-button');
        var cli_input = $('#clicmd-input');
        var cli_log = $('#cli-log');

        cli_button.click((e) => {
            e.preventDefault();
            var input_command = cli_input.val();
            var log = cli_log.html();

            var new_log = input_command+"<br>"+log;
            cli_log.html(new_log);

            

            var send_command = $.post("/admin/app/phpcli-insert", {
                "cli_command": cli_input.val(),
                "token": "<?php echo $_SESSION["token"] ?>",
                "method": "get",
            });
            cli_input.val("");

            send_command.done((data) => {
                console.log(data);
            });
        });
    });
</script>