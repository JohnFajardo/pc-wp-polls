<?php

// GET all polls from /wp-json/partnercomm/polls
add_action("rest_api_init", "getPolls");
// GET one poll by ID from /wp-json/partnercomm/polls/:id
add_action("rest_api_init", "getPoll");
// POST cast vote to /wp-json/partnercomm/polls
add_action("rest_api_init", "castVote");

// First we register the endpoint path and tell it what to do when hit
function getPolls() {
    register_rest_route('partnercomm', 'polls', array(
        'methods' => 'GET',
        'callback' => 'queryPolls'
        )
    );
}

// This is what happens when we hit the endpoint we created above.
// We're qerying the database for all the "poll" rows in our database...
function queryPolls() {
    global $wpdb;
    $table = $wpdb->prefix . "polls_" ."polls";

    $result = $wpdb->get_results("
        SELECT *
        FROM {$table}
    ");

    // ...and then rendering the result as JSON for our frontend
    return rest_ensure_response($result);
}

// GET single poll by id from /wp-json/partnercomm/polls/:id
// Same stuff as before but now with an id param in the url
function getPoll() {
    register_rest_route('partnercomm', '/polls/(?P<id>[\d]+)', array(
        'methods' => 'GET',
        'callback' => 'queryPoll'
    ));
}

function queryPoll($data) {
    global $wpdb;
    $id = $data['id'];
    $table = $wpdb->prefix . "polls_" . "polls";
    $pollOptions =  $wpdb->prefix . "polls_" . "options";

    $poll = $wpdb->get_row("
        SELECT *
        FROM {$table}
        WHERE id = {$id}
    ");

    $options = $wpdb->get_results("
        SELECT *
        FROM {$pollOptions}
        WHERE poll_id = {$id}
    ");

    return rest_ensure_response([$poll, $options]);
}

// And now let's build the endpoint to cast votes.
// This is mostly the same stuff as above, but with a POST request instead of a GET
// request, we are also taing two arguments and the SQL query is an insert one
// instead of insert, so not commenting on this one.

function castVote() {
    register_rest_route('partnercomm', 'polls', array(
        'methods' => 'POST',
        'callback' => 'insertVote',
        'args' => ['poll_id', 'option_id']
        )
    );
}

function insertVote($data) {
    global $wpdb;
    $table = $wpdb->prefix . "polls_" . "votes";

    $wpdb->insert(
        $table,
        array(
            'poll_id' => $data['poll_id'],
            'option_id' => $data['option_id']
        )
    );

    return rest_ensure_response('Vote cast');
}
