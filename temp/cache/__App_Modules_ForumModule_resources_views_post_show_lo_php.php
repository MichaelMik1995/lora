<div class="pd-2">
        <button redirect="forum/posts/category/<?php echo $category ?>" class="button-circle width-32p height-32p bd-none cursor-point" style="background-color: <?php echo $style['second_color'] ?>"><i class="fa fa-chevron-left"></i></button>
    </div>

<div class="header-3 content-center pdy-1">
    <?php echo $post["title"] ?>
</div>
<div class="content-right content-center-xsm">
    <?php if($post["author"] == $user_uid || $is_admin) : ?>
        <?php if($post["solved"] == 0) : ?>
        <button redirect="forum/post-edit/<?php echo $post['url'] ?>" class="button button-bd-warning bd-round-3"><i
                class="fa fa-edit"></i><span class="display-0-xsm"> Upravit</span></button>
    
            <button
                onClick="GUIDialog.dialogConfirm('Opravdu chceš uzavřít příspěvek? V uzavřeném příspěvku již nelze psát komentáře', () => {redirect('forum/post-close/<?php echo $post['url'] ?>')})"
                class="button button-bd-info bd-round-3"><i class="fa fa-close"></i><span class="display-0-xsm">
                    Uzavřít</span></button>
        <?php endif; ?>
    <?php if(in_array("admin", ['admin','admin','editor','developer'])) : ?>

        <?php if($post["solved"] == 1) : ?>
            <button
                    onClick="GUIDialog.dialogConfirm('Opravdu chceš otevřít příspěvek? V otevřeném příspěvku lze psát komentáře', () => {redirect('forum/post-open/<?php echo $post['url'] ?>')})"
                    class="button button-bd-info bd-round-3"><i class="fa fa-eye"></i><span class="display-0-xsm">
                        Otevřít</span>
            </button>
        <?php endif; ?>
        <button
            onClick="GUIDialog.dialogConfirm('Opravdu chceš smazat příspěvek?', () => {redirect('forum/post-delete/<?php echo $post['url'] ?>')})"
            class="button button-bd-error bd-round-3 mgx-1 mgx-3-xsm"><i class="fa fa-trash"></i><span
                class="display-0-xsm"> Smazat</span></button>
                
    <?php endif; ?>
    <?php endif; ?>
</div>


<div class="pdx-2 pdy-6">
    <?php echo $post["_content"] ?>
</div>


<?php if($post["solved"] == 0) : ?>
    <?php if('1' == '1') : ?>
    <div class="pd-1 header-6 bd-top-info bd-1 t-info content-center-xsm"><i class="fa fa-pencil"></i> Napsat komentář</div>

    <div class="pd-2">
        <form method="post" action="forum/comment-insert">
            <input hidden type="text" name="token" value="aff45cdd815c892333d8239672b010697d96d27268113252245f44ce3dc8750c"> <input hidden type="text" name="SID" value="a274caab31aed3ab3b482fd540ff89d0">
            <input hidden type='text' name='method' value='insert'>

            <input hidden type="text" name="post-url" value="<?php echo $post['url'] ?>">
            <input hidden type="text" name="reply" value="null">
            <div class="row width-60 width-100-xsm width-100-sm">
                <div class="display-flex column-2 column-justify-center">
                    <div class="als-center display-0-xsm"><img class="width-64p height-64p bd-round-symetric" src="<?php echo asset('img/avatar/64/111111111.png') ?>"></div>
                    <div class="als-center t-bold pdy-1">Admin</div>
                </div>
                <div class="column-8 column-10-xsm">
                    <?php echo $form ?>
                    <div class="mgy-2 form-line">
                        <button class="button button-info bd-round-3"><i class="fa fa-comment-dots"></i>
                            Okomentovat</button>
                    </div>
                </div>
            </div>

        </form>
    </div>

    <?php else : ?>
    <div class="pdy-1 t-error header-6 t-bold">Komentář může napsat pouze přihlášený uživatel! Pokud máte učet,
        přihlaste se <a class="header-6 t-info t-info-2-hover" href="/auth/login">ZDE</a>
    </div>
    <?php endif; ?>
<?php else : ?>
<div class="pdy-1 t-success header-6 t-bold">Příspěvek je již uzavřen. Nelze již odpovídat</div>
<?php endif; ?>

<div class="pd-1 header-6 bd-top-info bd-1 t-info content-center-xsm"><i class="fa fa-comments"></i> Komentáře</div>
<div class="content-right">
    <button id="button-great" event-toggle-class="click:button-dark:button-success:#button-great"
        onClick="$('.great-comment').slideToggle(200)" class="button button-success bd-round-3"><i
            class="fa fa-star"></i></button>
    <button id="button-bad" event-toggle-class="click:button-dark:button-error:#button-bad"
        onClick="$('.bad-comment').slideToggle(200)" class="button button-error bd-round-3"><i
            class="fa fa-thumbs-down"></i></button>
    <button id="button-neutral" event-toggle-class="click:button-dark:button-light:#button-neutral"
        onClick="$('.neutral-comment').slideToggle(200)" class="button button-light bd-round-3"><i
            class="fa fa-comment"></i></button>
</div>

<div class="row">
    <div class="column-1 column-xsm column-sm column-md"></div>

    <div class="column-7 column-10-xsm column-10-sm column-9-md">
        <?php if(!empty($post["comments"])) : ?>
            <?php $replies = $post["comments"] ?>
            <?php foreach($post["comments"] as $comment) : ?>

                <?php if($comment["great_comment"] > $comment["bad_comment"]) : ?>
                    <?php $color = "success"; $icon = "fa fa-star"; $type = "great-comment" ?>
                <?php elseif($comment["great_comment"] < $comment["bad_comment"]) : ?> 
                    <?php $color="error"; $icon="fa fa-thumbs-down"; $type="bad-comment" ?> 
                <?php else : ?> 
                    <?php $color="light"; $icon="fa fa-comment"; $type="neutral-comment" ?>
                <?php endif; ?>
            
                <?php if($comment["reply_to"]=="null") : ?> 
                    <div class="mgy-3 row <?php echo $type ?>">
                        <div class="column-1 display-0-xsm content-center pd-2">
                            <img class="width-40p height-40p bd-round-symetric"
                                src="<?php echo asset('img/avatar/64/'.$comment['author'].'.png') ?>">
                        </div>
                        <div class="column-9 column-10-xsm bd-top-<?php echo $color ?> bd-3">
                            <div class="bgr-dark-2">
                                <div class="pd-2 t-<?php echo $color ?>">
                                    <div class="row">
                                        <div class="column-8 column-6-xsm">
                                            <i class="<?php echo $icon ?>"></i> <i class="fa fa-user"></i> <?php echo $user_utils->getUserName($comment["author"]) ?>
                                        </div>
                                        <div class="column-2 column-4-xsm content-right header-6">
                                            <?php if('1' == '1') : ?>
                                                <?php if($post["solved"] == 0) : ?>
                                                <button redirect="forum/comment-bad/<?php echo $comment['url'] ?>" title="Tento komentář je nevhodný"
                                                        class="button-circle button-error width-28p height-28p">
                                                        <i class="fa fa-thumbs-down"></i>
                                                </button>

                                                <button redirect="forum/comment-great/<?php echo $comment['url'] ?>" title="Tento komentář mi pomohl" class="button-circle button-success width-28p height-28p mgx-1">
                                                    <i class="fa fa-star"></i>
                                                </button>
                                                <?php endif; ?>
                                            <?php endif; ?>

                                            <button onClick="$('#replies-<?php echo $comment['url'] ?>').slideToggle(200)"
                                                    event-toggle-class="click:fa fa-chevron-down:fa fa-chevron-up:#close-<?php echo $comment['url'] ?>"
                                                    class="button-circle width-28p height-28p button-bd-info"><i
                                                    id="close-<?php echo $comment['url'] ?>" class="fa fa-chevron-up"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>


                                <div class="pd-2">
                                    <?php echo $comment["_content"] ?>
                                </div>

                                <div class="content-right pd-2">
                                    <i class="fa fa-calendar"></i> <?php echo DATE("d.m.Y H:i:s",$comment["updated_at"]) ?> |
                                    <i class="fa fa-star t-success"></i><sub><?php echo $comment["great_comment"] ?></sub>
                                    <i class="fa fa-thumbs-down t-error"></i><sub><?php echo $comment["bad_comment"] ?></sub>
                                </div>

                                <?php if('1' == '1') : ?>
                                    <div class="bgr-dark-3">
                                        <form method="post" action="/forum/comment-insert">
                                            <input hidden type="text" name="token" value="aff45cdd815c892333d8239672b010697d96d27268113252245f44ce3dc8750c"> <input hidden type="text" name="SID" value="a274caab31aed3ab3b482fd540ff89d0">
                                            <input hidden type='text' name='method' value='insert'>
                                            <input hidden type="text" name="reply" value="<?php echo $comment['url'] ?>">
                                            <input hidden type="text" name="post-url" value="<?php echo $post['url'] ?>">

                                            <div class="mgy-2 form-line">
                                                <div class="">
                                                    <div class="">
                                                        <textarea required id="reply-<?php echo $comment['url'] ?>" name="content"
                                                            class="background-none bd-none t-light pd-1 width-100 v-resy"
                                                            placeholder="Aa..."></textarea>
                                                    </div>
                                                    <div class="content-center-xsm">
                                                        <button type="submit"
                                                            class="button background-none bd-none t-light t-info-hover cursor-point pd-2-xsm"><i
                                                                class="fa fa-reply fa-rotate-180"></i> Odpovědět</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div id="replies-<?php echo $comment['url'] ?>" class="row">
                            <div class="column-1"></div>

                            <div class="column-9 column-10-xsm">
                                <?php foreach($replies as $reply) : ?>

                                    <?php if($reply["great_comment"] > $reply["bad_comment"]) : ?>
                                        <?php $color_r = "success"; $icon_r = "fa fa-star" ?>
                                    <?php elseif($reply["great_comment"] < $reply["bad_comment"]) : ?> 
                                        <?php $color_r="error"; $icon_r="fa fa-thumbs-down" ?> 
                                    <?php else : ?> 
                                        <?php $color_r="light"; $icon_r="fa fa-reply-all fa-rotate-180" ?> 
                                    <?php endif; ?> 

                                    <?php if($reply["reply_to"] !=null && $reply["reply_to"]==$comment["url"]) : ?> 
                                        <div class="mgy-2 row">
                                            <div class="column-1 column-2-xsm header-2 header-5-xsm mg-auto-all">
                                                <div class="">
                                                    <i class="fa fa-reply fa-rotate-180 t-<?php echo $color_r ?>"></i>
                                                </div>
                                            </div>
                                            <div class="column-9 column-8-xsm bgr-dark-3 bd-dark-2 bd-round-3">
                                                <div class="pd-2 t-<?php echo $color_r ?>">
                                                    <div class="row">
                                                        <div class="column-8 column-6-xsm">
                                                            <i class="<?php echo $icon_r ?>"></i> <i class="fa fa-user"></i> <?php echo $user_utils->getUserName($reply["author"]) ?>
                                                        </div>
                                                        <div class="column-2 column-4-xsm content-right header-6">
                                                            <?php if('1' == '1') : ?>
                                                                <?php if($post["solved"] == 0) : ?>
                                                                <button redirect="forum/comment-great/<?php echo $reply['url'] ?>" title="Tento komentář mi pomohl"
                                                                        class="button-circle button-success width-20p height-20p mgx-1"><i
                                                                        class="fa fa-star"></i></button>

                                                                <button redirect="forum/comment-bad/<?php echo $reply['url'] ?>" title="Tento komentář je nevhodný"
                                                                        class="button-circle button-error width-20p height-20p"><i
                                                                        class="fa fa-thumbs-down"></i></button>
                                                                <?php endif; ?>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="pd-1">
                                                    <?php echo $reply["_content"] ?>
                                                </div>

                                                <div class="content-right pdy-1 pdx-2">
                                                    <i class="fa fa-calendar"></i> <?php echo DATE("d.m.Y H:i:s",$reply["updated_at"]) ?> |
                                                    <i class="fa fa-star t-success"></i><sub><?php echo $reply["great_comment"] ?></sub>
                                                    <i class="fa fa-thumbs-down t-error"></i><sub><?php echo $reply["bad_comment"] ?></sub>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div> 
                        </div>  
                    </div>                  
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <div class="column-2 column-xsm column-sm"></div>
</div>