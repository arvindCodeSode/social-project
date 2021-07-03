  function load_all_notification(view=null){
  $.ajax({
    url:"user/all-notification.php",
      method:"post",
      data:{view:view},
      success:function(responce){
        var responce=JSON.parse(responce);
        console.log(responce);
        if(responce.status=="auth_required"){
          window.location="user/"+responce.url;
        }
        if(responce.status=="success"){
          $("#notification").html(responce.data);
          if(responce.unseen_notificaton){
            $(".notification-noti").show().html(responce.unseen_notificaton);
          }
        }
      }
  });
}
load_all_notification();
setInterval(function(){load_all_notification()},600000);
$(".get-not").click(function(){
  $(".notification-noti").hide();
  load_all_notification("yes");
 setInterval(function(){ window.open("notification","_self")},1000);
});
$(".get-video").click(function(){
 setInterval(function(){ window.open("video","_self")},1000);
});
$(".get-home").click(function(){
  $(".home-noti").hide();
 setInterval(function(){ window.open("home","_self")},1000);
});

$(".get-trends").click(function(){
  $(".trends-not").hide();
  setInterval(function(){window.open("trends","_self")},500);
});
setInterval(function(){$(".home-noti").show().html(10)},100000);
setInterval(function(){$(".video-noti").show().html(5)},100000);