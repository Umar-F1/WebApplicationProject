function validateLoginForm()
{
    validateLoginEmail();
    validateLoginPassword();
}

function validateLoginEmail()
{
    var email = document.login.email.value;
    var mailformat = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;

    if(mailformat.test(email))
    {
        return true;
    }
    else
    {
        alert("Invalid email address.");
        return false;
    }
}   

function validateLoginPassword() 
{  
    var pw1 = document.getElementById("password").value;  

    //check empty password field  
    if(pw1== "" || pw1.length < 8) 
    {  
       alert("Please enter a valid password");  
       return false;  
    }
    else
    {
        alert("Password accepted")
        return true;
    }
  }
