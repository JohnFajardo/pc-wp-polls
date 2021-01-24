<?php

function createPoll() {

    define('PLUG_NAME', "polls");
    $backLink = "<a href=\"admin.php?page=".PLUG_NAME."\">Create another!</a>";
    global $wpdb;

    $wpdb->insert(
        $wpdb->prefix . "polls_" ."polls",
        array(
            'name' => stripslashes($_POST["poll-name"]),
            'creationDate' => date('Y-m-d H:i:s')
        )
    );

    $pollId = $wpdb->insert_id;
    
    foreach($_POST as $fieldName => $fieldValue) {
        if($fieldName === "poll-name" || $fieldValue === '') {
            continue;
        } else {
            $wpdb->insert(
                $wpdb->prefix . "polls_" . "options",
                array(
                    'poll_id' => $pollId,
                    'name' => stripslashes($fieldValue)
                )
            );
        }
    }

    echo <<< EOD
        <div class="wrap">
            <h1>A new poll called {$_POST["poll-name"]} was created with the following options:</h1>
        </div>
    EOD;

    echo "<ul>";
        foreach($_POST as $fieldName => $fieldValue){
            echo "<li>" . $fieldName . ": " . $fieldValue . "</li>";
        }

    echo "</ul>";
    echo $backLink;
}

createPoll();
