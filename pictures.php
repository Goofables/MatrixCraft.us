<?php include "header.php"; ?>
<div id="pictures" class="round page_text">
    <h2>Server pictures from discord</h2>
    <?php
    try {
        // Token stored out of web path cuz im not dumb or something
        $auth_token = json_decode(file_get_contents("../matrixcraft-auth.json"), true)["token"];
        $options = ["http" => ["header" => ["Authorization: Bot " . $auth_token], "method" => "GET"]];
        /** @noinspection PhpUsageOfSilenceOperatorInspection */
        $result = @file_get_contents("https://discordapp.com/api/v8/channels/702991693292765294/messages", false, stream_context_create($options));
        //$result = @file_get_contents("https://discordapp.com/api/v6/channels/391431247773302784/messages", false, stream_context_create($options));
    } catch (Exception $e) {
        exit("Fatal call exception");
    }
    $amount = 0;
    foreach (json_decode($result, true) as $msg) {
        $imgs = [];
        if (isset($msg["attachments"])) foreach ($msg["attachments"] as $a) $imgs[$msg["author"]["username"] . "#" . $msg["author"]["discriminator"]] = $a;
        if (isset($msg["embeds"])) foreach ($msg["embeds"] as $e) $imgs[$msg["author"]["username"] . "#" . $msg["author"]["discriminator"]] = $e["thumbnail"];
        foreach ($imgs as $user => $img):?>
            <figure id="image_<?php echo ++$amount ?>">
                <figcaption><?php echo $user; ?>:</figcaption>
                <img class="round picture" loading="lazy" src="<?php echo $img["url"] ?>" alt=""
                     onerror="document.getElementById('pictures').removeChild(document.getElementById('image_<?php echo $amount ?>'))">
            </figure>
        <?php endforeach;
    } ?>

</div>

<?php include "footer.html"; ?>
