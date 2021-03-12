<?php if ($request->session()->has("flash_message")) { ?>
  <div class="alert <?= $request->session()->get("flash_message_class") ?>" role="alert">
    <?= $request->session()->get("flash_message") ?>
  </div>
<?php 
  $request->session()->forget("flash_message");
  $request->session()->forget("flash_message_class");
} 
?>