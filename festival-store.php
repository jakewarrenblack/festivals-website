<?php
require_once 'config.php';

try {
    // $request = new HttpRequest();

    $locations = [
        "USA",  "Belgium", "Brazil", "UK",
        "Germany", "Japan", "Netherlands",
        "Hungary", "Morocco", "Spain",
        "Canada", "Croatia", "Philippines"
    ];

    $rules = [
        "title" => "present|minlength:2|maxlength:64",
        "description" => "present|minlength:20|maxlength:2000",
        "location" => "present|in:" . implode(',', $locations),
        "start_date" => "present|match:/\A[0-9]{4}[-][0-9]{2}[-][0-9]{2}/",
        "end_date" => "present|match:/\A[0-9]{4}[-][0-9]{2}[-][0-9]{2}/",
        "contact_name" => "present|minlength:4|maxlength:64",
        "contact_email" => "present|email|minlength:7|maxlength:128",
        /*Needs 2-3 digits, followed by a heifen, followed by 5-7 more digits.*/
        "contact_phone" => "present|match:/\A[0-9]{2,3}[-][0-9]{5,7}\Z/"

    ];

    $request->validate($rules);
    if ($request->is_valid()) {
        /*Pass the name of the file upload button as a parameter.*/
        $file = new FileUpload("profile");
        /*Get our new FileUpload object, which is stored in a temporary folder on our web server.*/
        $filename = $file->get();
        /*Create an image object and store the file path in that object.*/
        $image = new Image();
        /*Save the pathname for where the image is stored in the database*/
        $image->filename = $filename;
        $image->save();

        $festival = new Festival();
        $festival->title = $request->input("title");
        $festival->description = $request->input("description");
        $festival->location = $request->input("location");
        $festival->start_date = $request->input("start_date");
        $festival->end_date = $request->input("end_date");
        $festival->contact_name = $request->input("contact_name");
        $festival->contact_email = $request->input("contact_email");
        $festival->contact_phone = $request->input("contact_phone");
        /*Insert the value for the image object we've created above.*/
        $festival->image_id = $image->id;
        $festival->save();

        $request->session()->set("flash_message", "The festival was successfully added to the database");
        /*We specify a class to change the appearance of our Bootstrap message.*/
        $request->session()->set("flash_message_class", "alert-info");
        /*Forget any data that's already been stored in the session.*/
        /*We've specified a flash message instead.*/
        $request->session()->forget("flash_data");
        $request->session()->forget("flash_errors");

        $request->redirect("/home.php");
    } else {
        /*Get all session data from the form and store under the key 'flash_data'.*/
        $request->session()->set("flash_data", $request->all());
        /*Do the same for errors.*/
        $request->session()->set("flash_errors", $request->errors());

        //Redirect the user to the create script.
        $request->redirect("/festival-create.php");
    }
} catch (Exception $ex) {
    /*Get all data and errors again and redirect.*/
    $request->session()->set("flash_message", $ex->getMessage());
    $request->session()->set("flash_message_class", "alert-warning");
    $request->session()->set("flash_data", $request->all());
    $request->session()->set("flash_errors", $request->errors());

    $request->redirect("/festival-create.php");
}
