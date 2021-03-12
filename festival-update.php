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
        "festival_id" => "present|integer|min:1",
        "title" => "present|minlength:2|maxlength:64",
        "description" => "present|minlength:20|maxlength:2000",
        "location" => "present|in:" . implode(',', $locations),
        "start_date" => "present|minlength:10|maxlength:10",
        "end_date" => "present|minlength:10|maxlength:10",
        "contact_name" => "present|minlength:4|maxlength:64",
        "contact_email" => "present|email|minlength:7|maxlength:128",
        /*Needs 2-3 digits, followed by a heifen, followed by 5-7 more digits.*/
        "contact_phone" => "present|match:/\A[0-9]{2,3}[-][0-9]{5,7}\Z/",

    ];

    $request->validate($rules);
    if ($request->is_valid()) {
        $image = null;
        if (FileUpload::exists('profile')) {
            //If a file was uploded for profile,
            //create a FileUpload object
            $file = new FileUpload("profile");
            $filename = $file->get();
            //Create a new image object and save it.
            $image = new Image();
            $image->filename = $filename;
            $image->save();
        }
        $festival = Festival::findById($request->input("festival_id"));
        $festival->title = $request->input("title");
        $festival->description = $request->input("description");
        $festival->location = $request->input("location");
        $festival->start_date = $request->input("start_date");
        $festival->end_date = $request->input("end_date");
        $festival->contact_name = $request->input("contact_name");
        $festival->contact_email = $request->input("contact_email");
        $festival->contact_phone = $request->input("contact_phone");
        /*If not null, the user must have uploaded an image, so reset the image id to that of the one we've just uploaded.*/
        if ($image !== null) {
            $festival->image_id = $image->id;
        }
        $festival->save();

        $request->session()->set("flash_message", "The festival was successfully updated in the database");
        $request->session()->set("flash_message_class", "alert-info");
        /*Forget any data that's already been stored in the session.*/
        $request->session()->forget("flash_data");
        $request->session()->forget("flash_errors");

        $request->redirect("/home.php");
    } else {
        $festival_id = $request->input("festival_id");
        /*Get all session data from the form and store under the key 'flash_data'.*/
        $request->session()->set("flash_data", $request->all());
        /*Do the same for errors.*/
        $request->session()->set("flash_errors", $request->errors());

        $request->redirect("/festival-edit.php?festival_id=" . $festival_id);
    }
} catch (Exception $ex) {
    /*Get all data and errors again and redirect.*/
    $request->session()->set("flash_message", $ex->getMessage());
    $request->session()->set("flash_message_class", "alert-warning");
    $request->session()->set("flash_data", $request->all());
    $request->session()->set("flash_errors", $request->errors());

    $request->redirect("/festival-create.php");
}
