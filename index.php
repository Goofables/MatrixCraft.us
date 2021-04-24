<?php include "header.php"; ?>
<div id="players" class="page_text round">

    <?php
    require __DIR__ . "/PHP-Minecraft-Query/src/MinecraftQuery.php";
    require __DIR__ . "/PHP-Minecraft-Query/src/MinecraftQueryException.php";

    use xPaw\MinecraftQuery;
    use xPaw\MinecraftQueryException;

    $query = new MinecraftQuery();
    try {
        $query->Connect("10.0.0.200", 25565, 1);
    } catch (MinecraftQueryException $e) {
    }
    ?>
    <table>
        <caption><h2 style="margin-bottom:0;">Players:</h2></caption>
        <tbody style="margin-top:0;">
        <tr>
            <?php if (($players = $query->GetPlayers()) != false):
                $amt = 0;
                foreach ($players as $player):
                    $amt += 1 ?>
                    <td>
                        <figure><img src="https://minotar.net/avatar/<?php echo $player; ?>"
                                     class="player" title="<?php echo $player; ?>">
                            <figcaption><?php echo $player; ?></figcaption>
                        </figure>
                    </td>
                    <?php
                    if ($amt % 3 == 0 && $amt < count($players)) echo "</tr><tr>";
                endforeach;
            else: ?>
                <td><h3>No players online</h3></td>
            <?php endif; ?>
        </tr>
        </tbody>
    </table>
</div>


<?php include "footer.html"; ?>
