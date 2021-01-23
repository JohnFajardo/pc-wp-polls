<?php

wp_enqueue_style('partnerCommStyles', plugin_dir_path(__FILE__) . 'assets/css/styles.css');

function add_poll () {
    if($_POST){
        include(plugin_dir_path(__FILE__) . '/create-poll.php');
    } else {
?>

<div class="wrap">
        <div class="container">
            <img class="logo" src="<?php echo plugin_dir_url( __FILE__ ) . 'assets/images/logo.svg'; ?>">

            <span class="tagline">Poll Plugin v1.0</span>
            <hr />
            <h2>Create a new poll</h2>
            <form method="POST" action="#">
                <label for="poll-name">Poll Name</label>
                <input name="poll-name" id="poll-name" type="text" placeholder="Enter a name for your new poll" />

                <ul>
                    <li>
                        <label for="poll-option1">Option 1</label>
                        <input name="poll-option1" id="poll-option1" type="text"placeholder="Enter a name for option 1" />
                    </li>
                    <li>
                        <label for="poll-option2">Option 2</label>
                        <input name="poll-option2" id="poll-option2" type="text" placeholder="Enter a name for option 2" />
                    </li>
                    <li>
                        <label for="poll-option3">Option 3</label>
                        <input name="poll-option3" id="poll-option3" type="text" placeholder="Enter a name for option 3" />
                    </li>
                    <li>
                        <label for="poll-option4">Option 4</label>
                        <input name="poll-option4" id="poll-option4" type="text" placeholder="Enter a name for option 4" />
                    </li>
                    <li>
                        <label for="poll-option5">Option 5</label>
                        <input name="poll-option5" id="poll-option5" type="text" placeholder="Enter a name for option 5" />
                    </li>
                </ul>
                <button type="submit">Create poll</submit>
            </form>
        </div>
</div>

<?php
    }
}

add_poll();