<?php include "header.php"; ?>
<div id="stats" class="page_text round">
    <h2><a href="/Stats.php">Player Stats Lookup</a></h2>
    <div class="round input_div">
        <form method="get" name="form" id="form">
            <fieldset>
                <legend>UUID Lookup:</legend>
                <p><label for="name">Username or UUID:</label><br>
                    <input id="name" size="20" maxlength="32" minlength="3" name="name" placeholder="ex: Notch, 069a79f444e94726a5befca90e38aaf5"
                           type="text" value="<?php if (isset($_GET["name"])) echo htmlspecialchars($_GET["name"]) ?>"/>
                </p>
                <button onsubmit="lookup()">Lookup</button>
                <p id="form_response"><?php include "mcuuid.php"; ?></p>
            </fieldset>
        </form>
        <script>
            document.getElementById("form").addEventListener('submit', event => {
                event.preventDefault();
                lookup(document.getElementById("name").value);
            });

            async function lookup(name) {
                const response = await fetch("/mcuuid.php?name=" + name);
                document.getElementById("form_response").innerText = await response.text();
            }
        </script>
    </div>
</div>
<?php include "footer.html"; ?>
