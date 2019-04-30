 
 function detailsmodal(data)   {   

    var data = { 'id' : data };
  //   console.log($id);
    $.ajax({
      url: '/shoppingStore/includes/detailsmodal.php',
      type: 'get',
      data: data,
      dataType:'json',
      success: function(data){ 
            
          jQuery('#details-modal').modal('toggle');
          jQuery("#modal_title").text(data.title);
          
      },
      error:function(){
          alert("Ohhhh, Something Go Running Wait...");
      }  
  });

}
/*============================================================================================*/

// Function to get data in childs_categories.php
function get_shild_options() { 
    var parent_id = $('#parent').val();
    $.ajax({
       url:'/shoppingStore/admin/parsers/childs_categories.php',
       type: 'post',
       data:{parentID : parent_id},
       success: function(data) {
            $("#child").html(data);
        }, 
       error: function(){
           alert("ohhhh, something go wrong....");
       }

    });
}


$('select[name="parent"]').change(get_shild_options);