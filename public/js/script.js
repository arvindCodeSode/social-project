
"use_strict"
var emailValid=fnameValid=unameValid=passwordValid=cpasswordValid=mobileValid=matchPasssword=subjectValid=false;
$(document).ready(function(){
    $("input").keyup(function(){
        $(".Err").html("  ");
        $(".message").html(" ");
    })
    $(".setting-open").click(function(event){
        event.preventDefault();
        $("#sidenav").css("left","0px");
    });
    $("#close-sidenav").click(function(){
        $("#sidenav").css("left","-510px");
    });
    //this is for form
    $("#reg-form").submit(function(event){
        event.preventDefault();
    var nameReg=/^[a-zA-Z\s]+$/;
    // var mReg=/^[0-9]+$/;
    var emailReg=/^[a-zA-Z]+(\.|_)?[a-zA-Z0-9]*@[a-zA-Z]+\.[a-z]{2,4}$/;
    var passwordReg=/^[a-zA-Z0-9\d!@#$%^&*()_=]$/;
    var fname=$("#fname").val();
    // var mobile=$("#mobile").val();
    var email=$("#email").val();
    var uname=$("#uname").val();
    var password=$("#password").val();
    var cpassword=$("#cpassword").val();
    var submit=$("#reg-submit").val();
    if(fname!=""){
        if(fname.length<=50){
            if(fname.length>=2){
                if(fname.match(nameReg)){
                    fnameValid=true;
                }else{
                    $("#fnameErr").html("only alphawate allowed aaa");
                    $("#fname").focus();
                    return false;
                }
            }else{
                $("#fnameErr").html("name must be greater than 1");
                $("#fname").focus();
                return false;
            }
        }else{
            $("#fnameErr").html(" * name must be less than 20 character");
            $("#fname").focus();
            return false;

        }
    }else{
        $("#fnameErr").html(" * First name Required");
        $("#fname").focus();;
        // $("#fnameErr").html(" *");
        return false;
    }
    if(email!=""){
        if(email.match(emailReg)){
        emailValid=true
        }else{
            $("#emailErr").html(" * Invalid Email")
            $("#email").focus();
            return false;
        }
    }else{
        $("#emailErr").html(" * Email Id Required");
        $("#email").focus();
         return false;

    }
    if(uname!=""){
        if(uname.length>=6){
            unameValid=true;
        }else{
            $("#unameErr").html(" *minimum 6 character Required");
            $("#uname").focus();
            return false;
        }
    }else{
        $("#unameErr").html(" * Username Required");
        $("#uname").focus();
        return false;
    }
    if(password!=""){
        if(password.length>=6){
            passwordValid=true;
        }else{
            $("#passwordErr").html(" * minimum 6 charecter");
            $("#password").focus();
            return false;
        }
    }else{
        $("#passwordErr").html(" * Password Required");
        $("#password").focus();
        return false;
    }
    if(cpassword!=""){
        if(cpassword.length>=6){
            cpasswordValid=true;
        }else{
            $("#cpasswordErr").html(" * minimum 6 charecter");
            $("#cpassword").focus();
            return false;
        }
    }else{
        $("#cpasswordErr").html(" *Confirm Password Required");
        $("#cpassword").focus();
        return false;
    }
    if(password==cpassword){
        matchPasssword=true
    }else{
        ("#cpasswordErr").html(" * Password and Confirm password not matched");
        $("#cpassword").focus();
    }
    if(fnameValid && unameValid && emailValid && passwordValid && cpasswordValid && matchPasssword==true){
        var formdata=new FormData(this);
        $("#img-loader").show();
        $.ajax({
            url:"ajax_registers.php",
            method:"post",
            data:formdata,
            success:function(responce){
                var responce=JSON.parse(responce);
                if(responce.status=="success"){
                    $("#img-loader").hide();
                    window.location=responce.url;
                }else if(responce.status=="error"){
                    $("#img-loader").hide();
                    $("#reg-message").html(responce.data);
                }
            },
             cache:false,
            contentType:false,
            processData:false
        });
    }

});
    $(".setting-open").click(function(event){
        event.preventDefault();
        $("#sidenav").css("left","0px");
    });
    $("#close-sidenav").click(function(){
        $("#sidenav").css("left","-510px");
    });
    //this si for form
$("#contact-form").submit(function(event){
    event.preventDefault();
    var nameReg=/^[a-zA-Z\s]+$/;
    var mReg=/^[0-9]+$/;
    var emailReg=/^[a-zA-Z]+(\.|_)?[a-zA-Z0-9]*@[a-zA-Z]+\.[a-z]{2,4}$/;
    var fname=$("#fname").val();
    var mobile=$("#mobile").val();
    var email=$("#email").val();
    var subject=$("#subject").val();
    var description=$("#description").val();
    var csrf=$("#csrf").val();
    if(fname!=""){
        if(fname.length<=50){
            if(fname.length>=2){
                if(fname.match(nameReg)){
                    fnameValid=true;
                }else{
                    $("#fnameErr").html("only alphawate allowed aaa");
                    $("#fname").focus();
                    return false;
                }
            }else{
                $("#fnameErr").html("name must be greater than 1");
                $("#fname").focus();
                return false;
            }
        }else{
            $("#fnameErr").html(" * name must be less than 20 character");
            $("#fname").focus();
            return false;

        }
    }else{
        $("#fnameErr").html(" * First name Required");
        $("#fname").focus();
        return false;
    }
    if(mobile!=""){
        if(mobile.match(mReg)){
            if(mobile.length>=10){
                if(mobile.length<=12){
                mobileValid=true;
                }else{$("#mErr").html(" * minimum 10 Number Required!");$("#mobile").focus();return false}
            }else{$("#mErr").html(" * Invalid Mobile No.");$("#mobile").focus();return false}
        }else{$("#mErr").html(" * Invalid Mobile No.");$("#mobile").focus();return false}
    }else{$("#mErr").html(" * Please fill Mobile Number");$("#mobile").focus();return false}

    if(email!=""){
        if(email.match(emailReg)){
        emailValid=true
        }else{
            $("#emailErr").html(" * Invalid Email")
            $("#email").focus();
            return false;
        }
    }else{
        $("#emailErr").html(" * Email Id Required");
        $("#email").focus();
         return false;

    }

    if(subject!=""){
        if(subject.length<=250){
            subjectValid=true;
        }else{
            $("#SubErr").html(" maximum 250 character");
            $("#subject").focus();
            return false;
        }
    }else{
        $("#SubErr").html(" Subject Required");
        $("#subject").focus();
        return false;
    }
    if(description!=""){
        if(description.length<=250){
            matchPasssword=true;
        }else{
            $("#descErr").html(" maximum 250 character");
            $("#description").focus();
            return false;
        }
    }else{
        $("#descErr").html(" description Required");
        $("#description").focus();
        return false;
    }


    if(fnameValid && emailValid && mobileValid && subjectValid && matchPasssword ==true){
        var formdata=new FormData(this);
        $("#img-loader").show();
        $.ajax({
            url:"user/contacts.php",
            method:"post",
            data:formdata,
            success:function(responce){
                // console.log(responce);
                var responce=JSON.parse(responce);
                if(responce.status=="success"){
                $("#img-loader").hide();
                    alert("Form successfully submitted");
                    window.location.reload();
                }else if(responce.status=="error"){
                $("#img-loader").hide();
                    $("#reg-message").html(responce.data);
                }
            },
            error:function(responce){
                console.log(responce);
            },
            cache:false,
            contentType:false,
            processData:false
        });
    }

});
$("#suggestion-form").submit(function(event){
    event.preventDefault();
    var nameReg=/^[a-zA-Z\s]+$/;
    var fname=$("#fname").val();
    var subject=$("#subject").val();
    var csrf=$("#csrf").val();
    if(fname!=""){
        if(fname.length<=50){
            if(fname.length>=2){
                if(fname.match(nameReg)){
                    fnameValid=true;
                }else{
                    $("#fnameErr").html("only alphawate allowed aaa");
                    $("#fname").focus();
                    return false;
                }
            }else{
                $("#fnameErr").html("name must be greater than 1");
                $("#fname").focus();
                return false;
            }
        }else{
            $("#fnameErr").html(" * name must be less than 20 character");
            $("#fname").focus();
            return false;

        }
    }else{
        $("#fnameErr").html(" * First name Required");
        $("#fname").focus();
        return false;
    }
    if(subject.length<=250){
        subjectValid=true;
    }else{
        $("#SubErr").html(" maximum 250 character");
        $("#subject").focus();
        return false;
    }
    if(fnameValid  && subjectValid ==true){
        var formdata=new FormData(this);
        $.ajax({
            url:"user/suggestions.php",
            method:"post",
            data:formdata,
            success:function(responce){
                console.log(responce);
                var responce=JSON.parse(responce);
                if(responce.status=="success"){
                    alert("Form successfully submitted");
                    window.location.reload();
                }else if(responce.status=="error"){
                    $("#reg-message").html(responce.data);
                }
            },
             cache:false,
            contentType:false,
            processData:false
        });
    }

});
$("#report-form").submit(function(event){
    event.preventDefault();
    var nameReg=/^[a-zA-Z\s]+$/;
    var fname=$("#fname").val();
    var subject=$("#subject").val();
    var csrf=$("#csrf").val();
    if(fname!=""){
        if(fname.length<=50){
            if(fname.length>=2){
                if(fname.match(nameReg)){
                    fnameValid=true;
                }else{
                    $("#fnameErr").html("only alphawate allowed aaa");
                    $("#fname").focus();
                    return false;
                }
            }else{
                $("#fnameErr").html("name must be greater than 1");
                $("#fname").focus();
                return false;
            }
        }else{
            $("#fnameErr").html(" * name must be less than 20 character");
            $("#fname").focus();
            return false;

        }
    }else{
        $("#fnameErr").html(" * First name Required");
        $("#fname").focus();
        return false;
    }
    if(subject!=""){
        if(subject.length<=250){
            subjectValid=true;
        }else{
            $("#SubErr").html(" maximum 250 character");
            $("#subject").focus();
            return false;
        }
    }else{
        $("#SubErr").html(" * Report Required!");
        $("#subject").focus();
        return false;
    }
    if(fnameValid  && subjectValid ==true){
        var formdata=new FormData(this);
        $.ajax({
            url:"user/reports.php",
            method:"post",
            data:formdata,
            success:function(responce){
                var responce=JSON.parse(responce);
                if(responce.status=="success"){
                    alert("Form successfully submitted");
                    window.location.reload();
                }else if(responce.status=="error"){
                    $("#reg-message").html(responce.data);
                }
            },
             cache:false,
            contentType:false,
            processData:false
        });
    }
});
$("#forgot-form").submit(function(event){
    event.preventDefault();
    var emailReg=/^[a-zA-Z]+(\.|_)?[a-zA-Z0-9]*@[a-zA-Z]+\.[a-z]{2,4}$/;
    var email=$("#for-email").val();
    if(email!=""){
        if(email.match(emailReg)){
            emailValid=true
        }else{
            $("#emailErr").html(" * Invalid Email")
            $("#email").focus();
             return false;
        }
    }else{
        $("#emailErr").html(" * Email Id Required");
        $("#email").focus();
         return false;

    }
    if(emailValid==true){
        var formdata=$("#forgot-form").serialize();
        $("#loader").show();
        $.ajax({
            url:"email.php",
            data:formdata+"&action=fetch_email",
            method:"post",
            success:function(responce){
                var responce=JSON.parse(responce);
                console.log(responce);
                $("#loader").hide();
                if(responce.status=="success"){
                $("#forgot-form").hide();
                $("#forgot-form-token").show();
                    $("#message").html(responce.data);
                }else if(responce.status=="error"){
                    $("#loader").hide();
                    $("#message").html(responce.data);
                }
            },
            error:function(responce){
                $("#loader").hide();
                alert("Erro");
                location.reload();
            }        
        });
    }

});
$("#forgot-form-token").submit(function(event){
    event.preventDefault();
    var fToken=$("#f-token").val();
    var password=$("#password").val();
    var cpassword=$("#cpassword").val();
    if(fToken!=""){
        fnameValid=true
    }
    else{
        $("#tokenErr").html(" * Token Required");
        $("#f-token").focus();
        return false;
    }
    if(password!=""){
        if(password.length>=6){
            passwordValid=true;
        }else{
            $("#passwordErr").html(" * minimum 6 charecter");
            $("#password").focus();
            return false;
        }
    }else{
        $("#passwordErr").html(" * Password Required");
        $("#password").focus();
        return false;
    }
    if(cpassword!=""){
        if(cpassword.length>=6){
            cpasswordValid=true;
        }else{
            $("#cpasswordErr").html(" * minimum 6 charecter");
            $("#cpassword").focus();
            return false;
        }
    }else{
        $("#cpasswordErr").html(" *Confirm Password Required");
        $("#cpassword").focus();
        return false;
    }
    if(password==cpassword){
        matchPasssword=true
    }else{
        $("#cpasswordErr").html(" * Password and Confirm password not matched");
        $("#cpassword").focus();
    }
    if(passwordValid && fnameValid && cpasswordValid && matchPasssword==true){
        var formdata=$("#forgot-form-token").serialize();
        $("#loader").show();
        $.ajax({
            method:"post",
            url:"email.php",
            data:formdata+"&action=reset",
            success:function(responce){
                var responce=JSON.parse(responce);
                console.log(responce);
                if(responce.status=="success"){
                    $("#loader").hide();
                    alert("Password successfully Reset");
                    location.href="login";
                }else if(responce.status=="error"){
                     $("#loader").hide();
                    $("#message").html(responce.data);
                }else if(responce.status=="tknErr"){
                     $("#loader").hide();
                    $("#tokenErr").html(responce.data);
                }else if(responce.status=="cpswErr"){
                    $("#loader").hide();
                    $("#cpasswordErr").html(responce.data);
                }

            },
            error:function(responce){
                var responce=JSON.parse(responce);
                $("#loader").hide();
                alert("Erro");
                location.reload()
            }
        });
    }
     
});
    //this is login form
$("#login-form").submit(function(){
var email=$("#email").val();
var password=$("#password").val();
if(email==""){
    $("#emailErr").html(" * Email Required");
    $("#email").focus();
    return false;
}
if(password==""){
    $("#passwordErr").html(" * Password Required");
    $("#password").focus();
    return false;
}
});
$("#admin-form").submit(function(){
var email=$("#email").val();
var password=$("#password").val();
if(email==""){
    $("#emailErr").html(" * Email Required");
    $("#email").focus();
    return false;
}
if(password==""){
    $("#passwordErr").html(" * Password Required");
    $("#password").focus();
    return false;
}
});
// this is close bloggers
var closeBloggers=$(".close-bloggers");
var i;
for(i=0;i<closeBloggers.length;i++){
closeBloggers.click(function(){
    $(this).parents(".popular-blogggers-c").hide();
})
}
var follow=$(".follow");
var i;
for(i=0;i<follow.length;i++){
    $(follow).click(function(){
        $(this).html("following").css("color","#2196f5");
    })
}
var connect=$(".connecting");
var i;
for(i=0;i<connect.length;i++){
    $(connect).click(function(){
        $(this).html("connecting").css("color","#2196f5");
    })
}
var removeUser=$(".friends-list .hide");
var i;
for(i=0;i<removeUser.length;i++){
    $(removeUser).click(function(){
        $(this).parents(".friends-list").hide();
        $(this).parents(".friends-list + .hide-hr").hide();
    })
}
// this is for posting data
$("#post-mind").on('submit',function(event){
        event.preventDefault();
        var middle=$("#middle-blog-con");
        var files=$("#file-input").get(0).files;
         var formdata=new FormData(this);
        $.ajax({
            url:"user/post.php",
            data:formdata,
            method:"post",
            success:function(responce){
                var responce =JSON.parse(responce);
                console.log(responce);
                if(responce.status=="success"){
                    middle.html("");
                    $("#post-text").val("");
                    middle.html(responce.data);
                }
                else if(responce.error=="error"){
                    $("#post-text").focus();
                }
            },
            cache:false,
            contentType:false,
            processData:false
        });
    });
$("#post-p-mind").on('submit',function(event){
        event.preventDefault();
        var middle=$("#middle-blog-con");
        var files=$("#file-input").get(0).files;
         var formdata=new FormData(this);
        $.ajax({
            url:"user/post_p.php",
            data:formdata,
            method:"post",
            success:function(responce){
                var responce =JSON.parse(responce);
                // console.log(responce);
                if(responce.status=="success"){
                    middle.html("");
                    $("#post-text").val("");
                    middle.html(responce.data);
                }
                else if(responce.error=="error"){
                    $("#post-text").focus();
                }
            },
            cache:false,
            contentType:false,
            processData:false
        });
    });
// this is search box
$("#m-search").keyup(function(){
    var result=$(".result-wrapper");
    var search=$("#m-search").val();
    $(result).find("ul").remove();
    if(search!="" && search!==null){
        $.ajax({
        url:"search.php",
        method:"post",
        data:{search:search},
        success:function(responce){

            var responce=JSON.parse(responce);
            if(responce.success=="success"){
                result.html(responce.data);
            }
            else if(responce.error=="error"){
                result.html(responce.data);
            }
            
        },
        error:function(responce){
            var responce=JSON.parse(responce);
            result.html(responce.error);
        }
        });
    }
});

$(".comment-like").click(function(event){
    event.preventDefault();
});
$(".c-reply-icon").click(function(event){
    event.preventDefault();
    

});

$(".reply-like").click(function(event){
    event.preventDefault();
    var span=event.target;
});
$(document).on("click","#btn_more",function(){
            var PostId=$(this).attr("data-vid");
            $("#btn_more").html("Loading <i class='fas fa-spinner'></i>");
            $.ajax({
                url:"user/load.php",
                method:"post",
                data:{post_id:PostId},
                dataType:"text",
                success:function(responce){
                    var responce=JSON.parse(responce);
                    
                    if(responce.status=="success"){
                        if(responce.data!=""){
                        $("#btn_more").html("See More");
                        $("#btn_more").attr("data-vid",responce.last_id);
                        $("#middle-blog-con").append(responce.data);
                        }
                        
                    }else if(responce.status=="error"){
                        $("#btn_more").html(responce.data);
                    }
                }
            });
   });
$(document).on("click","#btn_video_more",function(){
            var PostId=$(this).attr("data-vid");
            $("#btn_video_more").html("Loading...");
            $.ajax({
                url:"user/load-video.php",
                method:"post",
                data:{post_id:PostId},
                dataType:"text",
                success:function(responce){
                    var responce=JSON.parse(responce);
                    
                    if(responce.status=="success"){
                        if(responce.data!=""){
                        $("#btn_video_more").html("See More..");
                        $("#btn_video_more").attr("data-vid",responce.last_id);
                        $("#middle-blog-con").append(responce.data);
                        }
                        
                    }else if(responce.status=="error"){
                        $("#btn_video_more").html(responce.data);
                    }
                }
            });
   });
$(document).on("click","#btn_more_fri",function(event){
            var UserId=$(this).attr("data-usrid");
            $("#btn_more_fri").html("Loading...");
            $.ajax({
                url:"user/load_friends.php",
                method:"post",
                data:{user_id:UserId},
                dataType:"text",
                success:function(responce){
                    var responce=JSON.parse(responce);
                    
                    if(responce.status=="auth_required"){
                        window.location="user/"+responce.url;
                    }
                    else if(responce.status=="success"){
                        if(responce.data!=""){
                        $("#btn_more_fri").html("See More");
                        $("#btn_more_fri").attr("data-usrid",responce.last_id);
                        $("#friends").append(responce.data);
                        }
                        
                    }else if(responce.status=="error"){
                        $("#btn_more_fri").html(responce.data);
                    }
                }
            });
   });
$(document).on("click",".open-imgs",function(event){
    event.preventDefault();
    var imgContainer=$("#user-img01");
    $(".open-pro-form").hide();
    $(imgContainer).attr("src",$(this).attr("src"));
    $("#open-modal-img").show();
});

$("#close-image").click(function(){
    $("#open-modal-img").hide("slow");
    $(".open-pro-form").show();
});
$(".open-pass-c").click(function(event){
    event.preventDefault();
    $("#pass-cont-c").show();
});
$(".open-change-u-c").click(function(event){
    event.preventDefault();
    $("#change-user-cont").show();
});
$("#pass-close").click(function(event){
    event.preventDefault();
    $("#pass-cont-c").hide();
});
$("#user-close").click(function(event){
    event.preventDefault();
    $("#change-user-cont").hide();
});
$("#delete_acccount").click(function(event){
    event.preventDefault();
    $("#open-pro-form").hide();
    $("#delete_acccount-c").show();
});
$("#delete-close").click(function(event){
    event.preventDefault();
    $("#open-pro-form").show(); 
    $("#delete_acccount-c").hide();
});
$("#Change-Pass").submit(function(event){
    event.preventDefault();
var oldpsw=$("#oldpsw").val();
var newpsw=$("#newpsw").val();
var conpsw=$("#conpsw").val();
 if(oldpsw==""){
        $("#CopswErr").html(" * Old Password Required");
        $("#oldpsw").focus();
        return false;
    }
else if(oldpsw.length<6){
        $("#CopswErr").html(" * minimum 6 charecter");
        $("#oldpsw").focus();
        return false;
}
else if(newpsw==""){
        $("#CnpswErr").html(" * New Password Required");
        $("#newpsw").focus();
        return false;
    }
else if(newpsw.length<6){
        $("#CnpswErr").html(" * minimum 6 charecter");
        $("#newpsw").focus();
        return false;
}
else if(conpsw==""){
        $("#CcpswErr").html(" * Confirm Password Required");
        $("#conpsw").focus();
        return false;
    } 
else if(conpsw.length<6){
        $("#CcpswErr").html(" * minimum 6 charecter");
        $("#conpsw").focus();
        return false;
}
else if(newpsw!==conpsw){
    $("#CcpswErr").html(" * Password and Confirm Password not matched!");
    $("#conpsw").focus();
    return false;
}
else{
    var formdata=new FormData(this);
    $.ajax({
        url:"user/cpassword.php",
        data:formdata,
        method:"post",
        dataType:"TEXT",
        success:function(responce){
            
            var responce=JSON.parse(responce);
            if(responce.status=="auth_required"){
                window.location="user/"+responce.url;
            }
            else if(responce.status=="success"){
               // $("#Change-Pass").reset();
                $("#CopswErr").html(" * ");
                $("#CnpswErr").html(" * ");
                $("#CcpswErr").html(" * ");
                $("#c-pass-message").text(responce.data);
            }
            else if(responce.status=="error"){
                $("#c-pass-message").text(responce.data);
            }
        },
        cache:false,
        contentType:false,
        processData:false
    });
}
});
$("#Change-User").submit(function(event){
event.preventDefault();
var olduser=$("#olduser").val();
var newuser=$("#newuser").val();
var conuser=$("#conuser").val();
 if(olduser==""){
        $("#CuserErr").html(" * Old Username Required");
        $("#olduser").focus();
        return false;
    }
else if(olduser.length<2){
        $("#CuserErr").html(" * minimum 2 charecter");
        $("#olduser").focus();
        return false;
}
else if(newuser==""){
        $("#CnewErr").html(" * New Username Required");
        $("#newuser").focus();
        return false;
    }
else if(newuser.length<2){
        $("#CnewErr").html(" * minimum 2 charecter");
        $("#newuser").focus();
        return false;
}
else if(conuser==""){
        $("#CcuserErr").html(" * Confirm Username Required");
        $("#conuser").focus();
        return false;
    } 
else if(conuser.length<2){
        $("#CcuserErr").html(" * minimum 6 charecter");
        $("#conuser").focus();
        return false;
}
else if(newuser!==conuser){
    $("#CcuserErr").html(" * Username and Confirm Username not matched!");
    $("#conuser").focus();
    return false;
}
else{
    var formdata=new FormData(this);
    $.ajax({
        url:"user/cusername.php",
        data:formdata,
        method:"post",
        dataType:"TEXT",
        success:function(responce){
            // console.log(responce);
            var responce=JSON.parse(responce);
            if(responce.status=="auth_required"){
                window.location="user/"+responce.url;
            }
            else if(responce.status=="success"){
                window.location="profile?uname="+responce.uname;
            }
            else if(responce.status=="error"){
                $("#c-user-message").text(responce.data);
            }
        },
        cache:false,
        contentType:false,
        processData:false
    });
}
});
$("#delete-user").submit(function(event){
event.preventDefault();
var email=$("#email_d").val();
var uname=$("#uname_d").val();
var captcha=$("#captcha").val();
var password=$("#pass_d").val();
 if(email==""){
        $("#Email_dErr").html(" * Please Enter Email");
        $("#email_d").focus();
        return false;
    }
else if(uname==""){
        $("#Uname_dErr").html(" * Please Enter Username");
        $("#uname_d").focus();
        return false;
    }
else if(password==""){
    $("#Pass_dErr").html(" * Please Enter Password");
    $("#pass_d").focus();
}
else if(captcha==""){
    $("#Captcha_dErr").html(" * Please Enter Below Cpatcha!");
    $("#captcha").focus();
    return false;
}
else{
    var formdata=new FormData(this);
    $.ajax({
        url:"user/user_delete.php",
        data:formdata,
        method:"post",
        dataType:"TEXT",
        success:function(responce){
            var responce=JSON.parse(responce);
            
            if(responce.status=="auth_required"){
                window.location="user/"+responce.url;
            }
            else if(responce.status=="success"){
                window.location="user/"+responce.url;
            }
            else if(responce.status=="error"){
                $("#c-delete-message").text(responce.data);
            }else if(responce.status=="email"){
                $("#Email_dErr").html(responce.data);
            }else if(responce.status=="uname"){
                $("#Uname_dErr").html(" * Username not matched");
            }else if(responce.status=="captcha"){
                $("#Captcha_dErr").html(responce.data);
            }else if(responce.status=="password"){
                $("#Pass_dErr").html(responce.data);
            }
        },
        cache:false,
        contentType:false,
        processData:false
    });
}

});
$("#open-pro-form").click(function(event){
        $("#o-p-image").addClass("open-full-share");
    });
$("#open-image-form").click(function(event){
    $("#open-i-img").addClass("open-full-share");
});




$("#cancel-pro").click(function(event){
        $("#o-p-image").removeClass("open-full-share");
    });
$("#cancel-image").click(function(event){
    $("#open-i-img").removeClass("open-full-share");
});
$("#open-edit").click(function(event){
    event.preventDefault();
    $(".full-share-box").removeClass("open-full-share");
    $("#full-edit-share-box").addClass("open-full-share"); 
});
$("#e-close-b").click(function(event){
    $(".full-edit-share-box").removeClass("open-full-share"); 
})


$("#img-upload-pro").submit(function(event){
    event.preventDefault();
    var formdata=new FormData(this);
    $.ajax({
        url:"user/img-upload.php",
        data:formdata,
        method:"post",
        xhr:function(){
            xhr=new XMLHttpRequest();
            var percentge=0;
        xhr.upload.addEventListener('progress',function(e){
            percentge=Math.round((e.loaded/e.total)*100);
            $("#a-i-u").show();
            $(".f-s-bio").hide();
            $("#upload-buttons").hide();
            $("#progress-bar").css("width",percentge+"%");
            if(percentge==100){
            $(".f-s-bio").show();
            $("#upload-buttons").show();
            $(".progress-cont").hide();
        }
            });
            return xhr;
        },

        success:function(responce){
            var responce =JSON.parse(responce);
            // console.log(responce);
            if(responce.status=="success"){
                $("#image-u-f").val(responce.img);
                $("#image-name").val(responce.data);
                $("#type").val(responce.type1);
                $("#upload-image").attr("data-id",responce.type);
                $("#upload-image").attr("src","dataimage/"+responce.data);
            }
            else if(responce.status=="error"){
                $("#upload-message").show();
                $("#upload-message").html(responce.data);
            }
        },
        cache:false,
        contentType:false,
        processData:false
        });   
});

$("#img-upload-image").submit(function(event){
    event.preventDefault();
    var formdata=new FormData(this);
    $.ajax({
        url:"user/img-upload.php",
        data:formdata,
        method:"post",
        xhr:function(){
            xhr=new XMLHttpRequest();
            var percentge=0;
        xhr.upload.addEventListener('progress',function(e){
            percentge=Math.round((e.loaded/e.total)*100);
            $("#a-i-u").show();
            $(".f-s-bio").hide();
            $("#upload-buttons").hide();
            $("#progress-bar").css("width",percentge+"%");
            if(percentge==100){
            $(".f-s-bio").show();
            $("#upload-buttons").show();
            $(".progress-cont").hide();
        }
            });
            return xhr;
        },
        success:function(responce){
            var responce =JSON.parse(responce);
            console.log(responce);
            if(responce.status=="success"){
                $("#image-u-f").val(responce.img);
                $("#image-name").val(responce.data);
                $("#type").val(responce.type1);
                $("#upload-image").attr("data-id",responce.type);
                $("#upload-image").attr("src","dataimage/"+responce.data);
            }
            else if(responce.status=="error"){
                
                $("#upload-message").text(responce.data);
            }
        },
        cache:false,
        contentType:false,
        processData:false
        });    
});


$("#cancel-upload").click(function(){
    $("#a-i-u").hide();
});
$("#post-upload").click(function(event){
    event.preventDefault();
    var post_u_text=$("#post-upload-text").val();
    var image_u_f=$("#image-u-f").val();
    var image_name=$("#image-name").val();
    var csrfe=$("#csrfe").val();
    var type1=$("#type").val();
    var type=$("#upload-image").data("id");
    $.ajax({
        url:"user/post_v_edit.php",
        method:"post",
        data:{post_u_text:post_u_text,image_u_f:image_u_f,image_name:image_name,csrfe:csrfe,type:type,type1:type1},
        success:function(responce){
            
            var responce=JSON.parse(responce);
            console.log(responce)
            if(responce.status=="auth_required"){
                window.location="user/"+responce.url;
            }
            else if(responce.status=='success'){
                if(responce.image_img=="img"){
                    $("#user-pro-image").attr("src","dataimage/"+responce.image_name);
                    $("#left-pro-img").attr("src","dataimage/"+responce.image_name);
                    $("#m-pro-img").attr("src","dataimage/"+responce.image_name);
                    $("#pro-form-img").attr("src","dataimage/"+responce.image_name);
                }
                if(responce.image_img=="pro"){
                    $("#user-cover-image").attr("src","dataimage/"+responce.image_name);
                    $("#cover-form-img").attr("src","dataimage/"+responce.image_name);
                }
                $("#middle-blog-con").html(responce.data);
                $("#a-i-u").hide();
                $("#open-i-img").hide();
                $("#o-p-image").hide();
            }else if(responce.status=="error"){
                alert("error! "+responce.data);
            }
        },
        error:function(responce){
            
        }
    });

});
$("#edit-profile").submit(function(event){
    event.preventDefault();
    var nameReg=/^[a-zA-Z\s]+$/;
    var fname=$("#fname").val();
    var userBio=$("#user-bio").val();
    var mobileNo=$("#mobile").val();
    var location=$("#location").val();
    var profession=$("#profession").val();

    if(fname!=""){
        if(fname.length<=50){
            if(fname.length>=2){
                if(fname.match(nameReg)){
                    fnameValid=true;
                }else{
                    $("#fnameErr").html("only alphawate allowed aaa");
                    $("#fname").focus();
                    return false;
                }
            }else{
                $("#fnameErr").html("name must be greater than 1");
                $("#fname").focus();
                return false;
            }
        }else{
            $("#fnameErr").html(" * name must be less than 20 character");
            $("#fname").focus();
            return false;

        }
    }else{
        $("#fnameErr").html(" * Name Required");
        $("#fname").focus();;
        $("#fnameErr").html(" *");
        return false;
    }
    if(userBio.length<=250){
       unameValid=true;
    }else{
        $("#bioErrr").html(" * maximum 150 character");
        $("#user-bio").focus();
        return false;
    }
    if(location.length<=50){
       passwordValid=true;
    }else{
        $("#locationErr").html(" * maximum 50 character");
        $("#location").focus();
        return false;
    }
    if(profession.length<=50){
       cpasswordValid=true;
    }else{
        $("#professionErr").html(" * maximum 50 character");
        $("#profession").focus();
        return false;
    }
    if(mobileNo.length<=10){
       if(!isNaN(mobileNo)){
        mobileValid=true;
       }else{
            $("#mobileErr").html(" * Invalid Mobile No.");
            $("#mobile").focus();
            return false;
       }
    }else{
        $("#mobileErr").html(" * Invalid Mobile No");
        $("#mobile").focus();
        return false;
    }

     if(fnameValid && unameValid && passwordValid && mobileNo && cpasswordValid==true){
        var formdata=new FormData(this);
        $.ajax({
            url:"user/edit-profile.php",
            data:formdata,
            method:"post",
            success:function(responce){
                var responce =JSON.parse(responce);
                
                if(responce.status=="success"){
                    window.location="profile?uname="+responce.uname;
                }
                else if(responce.status=="error"){
                        $("#user-message").text(responce.data);
                }
            },
            cache:false,
            contentType:false,
            processData:false
        });   
     }

});

});


function likeOrDislike(post_id){
    var action='likes';
    $.ajax({
        url:"user/updatelike.php",
        data:{action:action,post_id:post_id},
        method:"post",
        success:function(responce){
            var responce=JSON.parse(responce);
            if(responce.status=="auth_required"){
                window.location="user/"+responce.url;
            }
            else if(responce.status=="success"){
                $("#user_like"+post_id).html(responce.data);
            }
        }
    })
} 
$(".user-like").on("click" ,function(event){
    event.preventDefault();
});
function replyLike(CommentId,PostId,replyId){
    var action="likes";
       $.ajax({
        url:"user/reply_like.php",
        data:{CommentId:CommentId,PostId:PostId,replyId:replyId,action:action},
        method:"post",
        success:function(responce){
            var responce=JSON.parse(responce);
            
            if(responce.status=="auth_required"){
                window.location="user/"+responce.url;
            }else if(responce.status=="success"){
                $("#r-like-c_"+replyId).html(responce.data);
            }
        },
        error:function(responce){
            var responce=JSON.parse(responce);
            
        }
    }); 
}
function commentLike(CommentId,PostId){
        var action="likes";
       $.ajax({
        url:"user/comment_like.php",
        data:{dataCommentId:CommentId,dataPostId:PostId,action:action},
        method:"post",
        success:function(responce){
            var responce=JSON.parse(responce);
            
            if(responce.status=="auth_required"){
                window.location="user/"+responce.url;
            }else if(responce.status=="success"){
                $("#c-like-c_"+CommentId).html(responce.data);
            }
        },
        error:function(responce){
            
        }
    }); 
}

// update like
function update_like(icon,action,post_id){
    var par=$(icon).parents(".user-like");
    $.ajax({
        url:"user/updatelike.php",
        data:{action:action,post_id:post_id},
        method:"post",
        success:function(responce){
            var responce=JSON.parse(responce);
            if(responce.status=="auth_required"){
                window.location="user/"+responce.url;
            }
            else if(responce.status=="success"){
                $(par).html(responce.data);
            }
            

        }
    })
}
// update user profile  like
function update_p_like(icon,action,post_id){
    var par=$(icon).parents(".user-like-p");
    $.ajax({
        url:"updatelike.php",
        data:{action:action,post_id:post_id},
        method:"post",
        success:function(responce){
            var responce=JSON.parse(responce);
            if(responce.status=="auth_required"){
                window.location=responce.url;
            }
            else if(responce.status=="success"){
                $(par).html(responce.data);
            }
            

        }
    })
}

    function commentForm(event,x){
    event.preventDefault();
    var formdata=new FormData(x);
    var target=event.target;
    var child=$(target).find(".post_id");
    var post_id=$(child).val();
    var parents=$(target).parents(".comment-cont");
    var commentContainer=$(parents).find(".inner-c-cont")
    $.ajax({
        url:"user/comment.php",
        data:formdata,
        method:"post",
        success:function(responce){
            var responce=JSON.parse(responce);
            
            if(responce.status=="success"){
                $(commentContainer).append(responce.data);
                $("#comment_"+post_id).text(responce.totalComment);
                $(target).find(".com-text").val("");
            }else if(responce.status=="error"){
              $(target).find(".com-text").focus();

            }
        },
        error:function(responce){
            var responce=JSON.parse(responce);
            if(responce.status=="error"){
                alert(responce.data);
            }
        },
        cache:false,
            contentType:false,
            processData:false

    });
};

function replyForm(event,x){
    event.preventDefault();
    var formdata=new FormData(x);
    var target=event.target;
    var child=$(target).find(".post_id");
    var post_id=$(child).val();
    var parents=$(target).parents(".fcb");
    var commentContainer=$(parents).find(".reply-container");
    $.ajax({
        url:"user/comment_reply.php",
        data:formdata,
        method:"post",
        success:function(responce){
            var responce=JSON.parse(responce);
            if(responce.status=="success"){
                $(commentContainer).append(responce.data);
                $("#comment_"+post_id).text(responce.totalComment);
                $(target).find(".com-text").val("");
            }else if(responce.status=="error"){
              $(target).find(".com-text").focus();

            }
        },
        error:function(responce){
            var responce=JSON.parse(responce);
            if(responce.status=="error"){
                alert(responce.data);
            }
        },
        cache:false,
            contentType:false,
            processData:false

    });
};
function getTotalComment(post_id){
    $.ajax({
        url:"user/get-comment.php",
        method:"post",
        async:false,
        data:{post_id,post_id},
        success:function(data){
            totalComment= data;
        }
    })
}
 function openComment(event){
    event.preventDefault();
    var commentIcon=event.target;
    var post_id=$(commentIcon).parents("a").attr("data-id");
    var middleBlog=$(commentIcon).parents(".middle-blog");
    var appendData=$(middleBlog).find(".comment-cont");
    if($(commentIcon).hasClass("comment-text")){
        $(appendData).toggle(100);

    }
};
function openReply(event,uname){
    var replyIcon=event.target;
    var fullCont=$(replyIcon).parents(".fcb");
    var commentContainer=$(replyIcon).parents(".comment-cont");
    var textArea=$(fullCont).find(".com-text");
    $(textArea).val(uname+" ");
    var replyBOx=$(fullCont).find(".reply-box");
    $(commentContainer).find(".login-user").hide();
    $(replyBOx).toggle("100").css({"margin":"0 5px"});
    $(textArea).focus();

}
$("#more-popup-btn").click(function(event){
    event.preventDefault();
    $(".more-popup").toggle("slow");
});
// user-bar").click(function(event){
    function openRestrict(event){
    event.preventDefault();
    var target=event.target;
    var popupC=$(target).parents(".user-restrict-cont");
    var popup=$(popupC).find(".user-restrict");
    $(popup).show("1");
}
 function closeRestrict(event){
    event.preventDefault();
    var target=event.target;
    var popupC=$(target).parents(".user-restrict-cont");
    var popup=$(popupC).find(".user-restrict");
    $(popup).show("1");   
    }
function openShare(event){
    event.preventDefault();
    var target=event.target;
    
    var popupC=$(target).parents("div.user-share");
    var popup=$(popupC).find(".f-s-cont");
    $(popup).toggle();   
    }
function closeShare(event){
    event.preventDefault();
    var target=event.target;
    $(target).parents(".f-s-cont").hide();
}
function openTShare(event,post_id){
    event.preventDefault();
        $.ajax({
            url:"user/open-share.php",
            method:"post",
            data:{post_id,post_id},
            success:function(responce){
                var responce=JSON.parse(responce);
                
                if(responce.status=="success"){
                $("#main-full-share").addClass("open-full-share");
                    $("#share-box").append(responce.data);
                }else if(responce.status=="error"){
                    alert("alert"+responce.data);
                }
            }
        })
}
function cancelShare(event){
    event.preventDefault();
    var target=event.target;
    $(target).parents(".middle-blog-c").remove();
    $("#main-full-share").removeClass("open-full-share");
    $(".f-s-cont").hide();
}
function shareNow(event,post_id){
    event.preventDefault();
    var target=event.target;
    var middle=$("#middle-blog-con");
    var shareBox=$(target).parents(".share-box");
    var postShare=$(shareBox).find("#post-share-text");
    var ShareData=$(postShare).val();
    $.ajax({
        url:"user/share-data.php",
        method:"post",
        data:{share_data:ShareData,post_id:post_id},
        success:function(responce){
            
            var responce=JSON.parse(responce);
             if(responce.status=="success"){
                    middle.html("");
                    $(target).parents(".middle-blog-c").remove();
                    $("#main-full-share").removeClass("open-full-share");
                    $(".f-s-cont").hide();
                    $("#share_"+post_id).text(responce.totalShare);
                    middle.html(responce.data);
            }
            else if(responce.error=="error"){
                   alert("error :There was an problem post not share");
            }
        }
    })
}
function openIShare(event,post_id){
    event.preventDefault();
    var target=event.target;
    var ShareData="";
    var middle=$("#middle-blog-con");
    $.ajax({
        url:"user/share-data.php",
        method:"post",
        data:{share_data:ShareData,post_id:post_id},
        success:function(responce){
            
            var responce=JSON.parse(responce);
             if(responce.status=="success"){
                    middle.html("");
                    $("#share_"+post_id).text(responce.totalShare);
                    middle.html(responce.data);
            }
            else if(responce.error=="error"){
                   alert("error :There was an problem post not share");
            }
        }
    })
}
function postde(post_id,csrfm,event){
    event.preventDefault();
    if(confirm("Are you sure! you want to delete the post")){
        if(post_id!="" && csrfm!=""){
        $.ajax({
            url:"user/post_delete.php",
            method:"post",
            data:{post_id:post_id,csrfm:csrfm},
            dataType:"text",
            success:function(responce){
                
                var responce=JSON.parse(responce);
                if(responce.status=="success"){
                    alert(responce.data);
                    location.reload();
                }else if(responce.status="error"){
                    alert(responce.data);
                }else if(responce.status=="auth_required"){
                    window.location="user/"+responce.url;
                }
            }
        });
        }
    }
}
function commentde(CommentId,PostId,csrfr,event){
    event.preventDefault();
    if(confirm("Are you sure! you want to delete the Comment")){
        if(CommentId!="" && csrfr!=""){
        $.ajax({
            url:"user/comment_delete.php",
            method:"post",
            data:{comment_id:CommentId,post_id:PostId,csrfr:csrfr},
            dataType:"text",
            success:function(responce){
                
                var responce=JSON.parse(responce);
                if(responce.status=="success"){
                    alert(responce.data);
                    location.reload();
                }else if(responce.status="error"){
                    alert(responce.data);
                }else if(responce.status=="auth_required"){
                    window.location="user/"+responce.url;
                }
            }
        });
        }
    }
}
function replyde(ReplyId,CommentId,PostId,csrfr,event){
    event.preventDefault();
    if(confirm("Are you sure! you want to delete the Reply")){
        if(CommentId!="" && csrfr!=""){
        $.ajax({
            url:"user/reply_delete.php",
            method:"post",
            data:{reply_id:ReplyId,comment_id:CommentId,post_id:PostId,csrfr:csrfr},
            dataType:"text",
            success:function(responce){
                
                var responce=JSON.parse(responce);
                if(responce.status=="success"){
                    alert(responce.data);
                    location.reload();
                }else if(responce.status="error"){
                    alert(responce.data);
                }else if(responce.status=="auth_required"){
                    window.location="user/"+responce.url;
                }
            }
        });
        }
    }
}
window.onclick=function(event){
    if(!event.target.matches("#more-popup-btn")){
        $(".more-popup").hide("slow");
    }
    if(!event.target.matches(".m-user-bar")){
        $(".user-restrict").hide();
    }
}
