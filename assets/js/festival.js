window.addEventListener('load', function (event) {
 
    const festival_btns = document.getElementsByClassName('btn-festival');
    for (var i = 0; i != festival_btns.length; i++) {
      let festival_btn = festival_btns.item(i);
      festival_btn.addEventListener("click", function (event) {
        const checked_radio_btns = document.querySelectorAll('input[name=festival_id]:checked');
        if (checked_radio_btns.length === 0) {
          event.preventDefault();
          event.stopImmediatePropagation();
          alert("Please select a festival first");
        }
      });
    };
   
    const festival_delete_btn = document.getElementsByClassName('btn-festival-delete')[0];
    festival_delete_btn.addEventListener("click", function (event) {
      if (!confirm("Are you sure you want to delete this festival?")) {
        event.preventDefault();
      }
    });

    /*I want to display a placeholder on dates, which the 'date' input doesn't support.*/
    /*My start/end dates are type 'text' by default, and switch to type 'date' on focus.*/
    const dateInputs = document.getElementsByClassName('dateInput');
    for(var i=0; i!= dateInputs.length; i++){
      let dateInput = dateInputs.item(i);
      dateInput.addEventListener("focusin", function (event){
        dateInput.attributes["type"].value = "date";
      });
      dateInput.addEventListener("focusout", function (event){
        dateInput.attributes["type"].value = "text";
      });
    }
   
  });