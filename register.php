

<?php

    // configuration
    require("../includes/config.php");

    // if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // TODO
        if (empty($_POST["username"]))
        {
            apologize("No username!\n");
            return false;
        }
        if (empty($_POST["password"]))
        {
            apologize("No password!\n");
            return false;
        }
        
        if ($_POST["password"] !== $_POST["confirmation"])
        {
            apologize("Rewrite your password correctly\n");
            return false;
        }
        
        query("INSERT INTO users (username, hash, cash) VALUES(?, ?, 10000.00)",
        $_POST["username"], crypt($_POST["password"]));
        
        if (query === false)
        {
            apologize("This username has been taken.\n");
        }
        
        $rows = query("SELECT LAST_INSERT_ID() AS id");
        $id = $rows[0]["id"];

        $_SESSION["id"] = $id;
        redirect("index.php");
    }
    else
    {
        // else render form
        render("register_form.php", ["title" => "Register"]);
    }

?>
